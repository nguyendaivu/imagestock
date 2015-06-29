<?php

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dropbox\Client;

class VIImage extends BaseModel {

	protected $table = 'images';

    public static function upload($file, $path, $width = 110, $makeThumb = true, $fileName = '')
    {
        if( !File::exists($path) ) {
            File::makeDirectory($path, 493, true);
        }
        if( !empty($fileName) ) {
            $fileName .= '.'.$file->getClientOriginalExtension();
        } else {
            $fileName = Str::slug(str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName())).'.'.date('d-m-y').'.'.$file->getClientOriginalExtension();
        }
        $path = str_replace(['\\', '/'], DS, $path);
        if($file->move($path, $fileName)){
            BackgroundProcess::resize($width, $path, $fileName);
            if( $makeThumb ) {
                BackgroundProcess::makeThumb($path, $fileName);
            }
            return $path.DS.$fileName;
        }
        return false;
    }

    private static function __getImage($img, $type)
    {
        $client = new Client(Config::get('services.dropbox.token'), Config::get('services.dropbox.appName'));
        $fileSystem = new Filesystem(new DropboxAdapter($client, '/images/'));
        $biggerW = $biggerH = false;
        if( $img->width > $img->height ) {
            $biggerW = true;
        } else {
            $biggerH = true;
        }
        $image = $w = $h = null;
        $public_path = public_path($img->path);
        //code minh
        //get image from dropbox
        if($img->store == 'dropbox') {
            try {
                $file = $fileSystem->read($img->path);
                $public_path = $file;
            } catch (Exception $e) {
                return false;
            }

        }
        //end code
        if( in_array($type, ['with-logo', 'large-thumb']) ) {
            if( $biggerW ) {
                $w = 450;
            } else {
                $h = 450;
            }
        } else if( in_array($type, ['thumb', 'small-thumb']) ) {
            if( $type == 'thumb' ) {
                if( $biggerW ) {
                    $w = 150;
                } else {
                    $h = 150;
                }
            } else {
                if( $biggerW ) {
                    $w = 100;
                } else {
                    $h = 100;
                }
            }
        } else if( in_array($type, ['crop','newcrop']) ) {
            $h = 300;
            $w = 300;
            if($type=='newcrop')
                $w = 600;
        }
        try {
            if( in_array($type, ['crop','newcrop']) )
                 $image = Image::make($public_path)
                                ->fit($w, $h, function($constraint){
                                    $constraint->aspectRatio();
                                });
            else
                $image = Image::make($public_path)
                                ->resize($w, $h, function($constraint){
                                    $constraint->aspectRatio();
                                });
        } catch(Exception $e) {
            return false;
        }
        if( $type == 'with-logo' ) {
            if( Cache::has('mask') ) {
                $mask = Cache::get('mask');
            } else {
                $mask = Configure::where('ckey', 'mask')->pluck('cvalue');
                if( empty($mask) ) {
                    $mask = 'Visual Impact';
                }
                Cache::forever('mask', $mask);
            }

            $size = 50;
            $w = $image->width();
            $h = $image->height();
            $x = round($w / 2);
            $y = round($h / 2);

            $img = Image::canvas($w, $h);
            $string  = wordwrap($mask, 15, '|');
            $strings = explode('|',$string);

            $line = 2;
            $i = round($y - (count($strings) / 2) * ( $size + $line ));
            $from = $i - 20;
            foreach($strings as $string){
                $draw = new \ImagickDraw();
                $draw->setStrokeAntialias(true);
                $draw->setTextAntialias(true);

                $draw->setFont(public_path('assets'.DS.'fonts'.DS.'times.ttf'));
                $draw->setFontSize($size);
                $draw->setFillColor('rgb(0, 0, 0)');
                $draw->setFillOpacity(0.2);
                $draw->setTextAlignment(\Imagick::ALIGN_CENTER);
                $draw->setStrokeColor('#fff');
                $draw->setStrokeOpacity(0.2);
                $draw->setStrokeWidth(1);

                $dimensions = $img->getCore()->queryFontMetrics($draw, $string);
                $posy = $i + $dimensions['textHeight'] * 0.65 / 2;
                $img->getCore()->annotateImage($draw,  $x, $posy, 0, $string);

                $i += $size + $line;
            }
            return $image->insert($img, 'center', $x, $y)->encode('jpg');
        }
        if( $image ) {
            return $image->encode('jpg');
        }
        return false;
    }

    public static function getImage($id, $type)
    {
        $key = md5($type.$id);
        if( Cache::tags(['images', $id])->has($key) ) {
            return Cache::tags(['images', $id])->get($key);
        } else {
            $img = self::select('images.updated_at', 'images.store', 'image_details.path', 'image_details.width', 'image_details.height')
                        ->join('image_details', 'image_details.image_id', '=', 'images.id')
                        ->where('id', $id)
                        ->where('size_type', DB::raw( '(SELECT MIN(size_type) FROM image_details WHERE image_id = '.$id.' )'))
                        ->first();
            if( $img ) {
                $image = self::__getImage($img, $type);
                if( !$image ) {
                    return false;
                }
                $arr = [
                    'image' => $image,
                    'time'  => strtotime($img['updated_at']),
                ];
                Cache::tags(['images', $id])->put($key, $arr, 43200);
                return $arr;
            }
        }
        return false;
    }

    public function categories()
    {
        return $this->belongsToMany('Category', 'images_categories', 'image_id', 'category_id');
    }

    public function details()
    {
        return $this->hasMany('VIImageDetail', 'image_id');
    }

     public function statistic()
    {
        return $this->hasOne('StatisticImage','image_id');
    }

    public function collections()
    {
        return $this->belongsToMany('Collection', 'collections_images', 'image_id', 'collection_id');
    }

    public function downloads()
    {
        return $this->hasMany('Download', 'image_id');
    }

    public function scopeWithType($query, $type)
    {
        return $query->addSelect('image_details.*')
                        ->join('image_details', 'images.id', '=', 'image_details.image_id')
                        ->where('image_details.type', $type);
    }
    public function scopeWithOrientation($query, $orientation)
	{
		$query = $query->addSelect('image_details.ratio');
		switch($orientation){
			case 'horizontal':
				return $query = $query->where('image_details.ratio', '>',1);
				break;
			case 'vertical':
				return $query = $query->where('image_details.ratio', '<',1);
				break;
			case 'square':
				return $query = $query->where('image_details.ratio', '=',1);
				break;
			default:
				return $query;
		}
	}

    public function scopeSearch($query, $search)
    {
        if($search != '')
        {
            return $query->whereRaw(
                                        'MATCH(name,description,keywords) AGAINST(? IN BOOLEAN MODE)',
                                        [ trim($search) ]
                                    );

        }
        return $query;
    }

    public function scopeSearchKeyWords($query, $search)
    {
        return $query->whereRaw(
                                    'MATCH(keywords) AGAINST(? IN BOOLEAN MODE)',
                                    [ trim($search) ]
                                );
    }

    public function scopeNotSearchKeyWords($query, $search)
    {
        return $query->whereRaw(
                                    'NOT MATCH(keywords) AGAINST(? IN BOOLEAN MODE)',
                                    [ trim($search) ]
                                );
    }

    public function scopeSearchColor($query, $search)
    {
        return $query->whereRaw(
                                    'MATCH(main_color) AGAINST(? IN BOOLEAN MODE)',
                                    [ trim($search) ]
                                );
    }


    public function afterCreate($image)
    {
        Notification::add($image->id, 'Image');
    }

    public function afterSave($image)
    {
       Cache::tags('images', $image->id)->flush();
    }

    public function beforeDelete($image)
    {
       Cache::tags('images', $image->id)->flush();
    }

    public function orders()
    {
    return $this->belongsToMany("Order", "order_details");
    }
    public function orderDetails()
    {
    return $this->hasMany("OrderDetail");
    } 

    public static function viFormat($number)
    {
        return number_format($number, 2);
    }       

}