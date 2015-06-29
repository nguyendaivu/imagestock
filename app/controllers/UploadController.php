<?php

use Illuminate\Support\Facades\File;

use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem;
use Dropbox\Client;
use Faker\Factory as Faker;
use League\ColorExtractor\Client as ColorExtractor;


class UploadController extends BaseController {

    private $filesystem;

    public function __construct(){

        // if(app()->environment() === "local")
        // {
        //     $this->filesystem = new Filesystem(new Adapter( public_path() . '/images/'));
        // }

        $client = new Client(Config::get('services.dropbox.token'), Config::get('services.dropbox.appName'));
        $this->filesystem = new Filesystem(new DropboxAdapter($client, '/images/'));

    }

    public function index()
    {
        if(Auth::user()->check())
        {
			$page = Input::has('page')?Input::get('page'):1;
			$take = Input::has('take')?Input::get('take'):20;
			$skip = ($page-1)*$take;
			
            $data = VIImage::select('images.id',
                                            'image_details.detail_id',
                                            'image_details.width',
                                            'image_details.height',
                                            'image_details.dpi',
                                            'image_details.size',
                                            'image_details.size_type',
                                            'image_details.path',
                                            'images.name',
                                            'images.short_name',
                                            'images.description',
                                            'images.store'
                                        )->leftJoin('image_details', function($join){
                                                $join->on('image_details.image_id', '=', 'images.id');
                                            })
                                        ->where('images.author_id', Auth::user()->get()->id)
                                        ->orderBy('images.id', 'desc')
                                        ->groupBy('images.id');
										
			$total_image = $data->get()->count();
			$total_page = ceil($total_image/$take);
			$from = $page - 2> 0 ? $page - 2: 1;
			$to = $page + 2<= $total_page ? $page + 2: $total_page;
			
			$data = $data->skip($skip)->take($take)->get();
			
            $arrImages = array();
            if($data->count() > 0)
            {
                $i = 0;
                foreach ($data as $key => $value)
                {
                    $arrImages[$i]['image_id'] = $value->id;
                    $arrImages[$i]['detail_id'] = $value->detail_id;
                    $arrImages[$i]['name'] = $value->name;
                    $arrImages[$i]['short_name'] = $value->short_name;
                    $arrImages[$i]['description'] = $value->description;
                    $arrImages[$i]['store'] = $value->store;
                    $arrImages[$i]['path'] = '/pic/with-logo/'.$value->short_name.'-'.$value->id.'.jpg';

                    $i++;
                }
            }
			
			$this->layout->metaTitle = Auth::user()->get()->first_name.'\'s Uploads';
			
            $this->layout->content = View::make('frontend.upload.index', ['files'=>$arrImages,
                                                                        'categories'    => Category::getSource(),
																		'total_image'    => $total_image,
																		'total_page'    => $total_page,
																		'current'    => $page,
																		'from'    => $from,
																		'to'    => $to
                                                                        ]);
            return;
        }
        return Redirect::route('account-sign-in');
    }

    public function uploadFile()
    {
        if(Auth::user()->check())
        {
            if (Input::hasFile('myfiles'))
            {                
                $name = Input::get('name');
                $short_name = Str::slug($name);
                $description = Input::get('description');
                $keywords = Input::get('keywords');
                $keywords = rtrim(trim($keywords), ',');

                $model = Input::get('model');
                $model = rtrim(trim($model), ',');

                $artist = Input::get('artist');
                $age_from = Input::get('age_from');
                $age_to = Input::get('age_to');
                $gender = Input::get('gender');
                $number_people = Input::get('number_people');

                $type_id = Input::get('type_id');
                $arr_category_ids = Input::get('category_id');
                
                $faker = Faker::create();

                $destination_store = Input::get('destination_store');

                //insert to images table
                // $keywords = '';
                // for( $i = 0; $i < $faker->numberBetween(4, 9); $i++ ) {
                //     $keywords .= $faker->word.',';
                // }
                // $keywords = rtrim($keywords, ',');
                // $name = $faker->name;
                // $short_name = Str::slug($name);
                // $gender = $faker->randomElement($array = array ('male','female','both','any'));
                // $age_from = $faker->numberBetween(0, 90);
                // $age_to = $faker->numberBetween(0, 90);
                // while($age_from >$age_to){
                //     $age_from = $faker->numberBetween(0, 90);
                //     $age_to = $faker->numberBetween(0, 90);
                // }
                $ethnicity = $faker->randomElement($array = array (
                                    'african',
                                    'african_american',
                                    'black',
                                    'brazilian',
                                    'chinese',
                                    'caucasian',
                                    'east_asian',
                                    'hispanic',
                                    'japanese',
                                    'middle_eastern',
                                    'native_american',
                                    'pacific_islander',
                                    'south_asian',
                                    'southeast_asian',
                                    'other',
                                    'any'
                                ));
                //$number_people = $faker->numberBetween(0, 10);
                $editorial = $faker->numberBetween(0, 1);
                //$type_id = $faker->numberBetween(1, 3);

                
                $color_extractor = new ColorExtractor;
                $myfiles = Input::file('myfiles');

                $mime_type = $myfiles[0]->getClientMimeType();
                
                switch ($mime_type) {
                    case 'image/jpeg':
                        $palette_obj = $color_extractor->loadJpeg($myfiles[0]);
                        break;
                    case 'image/png':
                        $palette_obj = $color_extractor->loadPng($myfiles[0]);
                        break;
                    case 'image/gif':
                        $palette_obj = $color_extractor->loadGif($myfiles[0]);
                        break;                    
                    default:
                        # code...
                        break;
                }
                $main_color = '';
                if(is_object($palette_obj))
                {                                        
                    $arr_palette = $palette_obj->extract(5);

                    if(!empty($arr_palette))
                    {
                        $main_color = strtolower($arr_palette[0]);
                        for($i=1; $i<count($arr_palette); $i++) 
                        {
                            $main_color .= ','.strtolower($arr_palette[$i]);
                        }
                    }
                }

                $image_id = VIImage::insertGetId([
                    'name' => $name,
                    'short_name' => $short_name,
                    'description' => $description,
                    'keywords' => $keywords,
                    'main_color' => $main_color,
                    'type_id'=>$type_id,
                    'model'=>$model,
                    'artist'=>$artist,
                    'gender'=>$gender,
                    'age_from'=>$age_from,
                    'age_to'=>$age_to,
                    'ethnicity'=>$ethnicity,
                    'number_people'=>$number_people,
                    'editorial'=>$editorial,
                    'author_id'=>Auth::user()->get()->id,
                    'store' => $destination_store
                ]);

                //insert into statistic_images table
                StatisticImage::create([
                        'image_id'  =>$image_id,
                        'view'      => '0',
                        'download'  => '0',
                    ]);

                //insert into images_categories table
                if(!empty($arr_category_ids))
                {
                    foreach ($arr_category_ids as $category_id) {
                        ImageCategory::create([
                            'image_id'  =>$image_id,
                            'category_id'      => $category_id                        
                        ]);                        
                    }                    
                }
    

                $result = array();
                for($i=0; $i < count($myfiles); $i++)
                {
                    $file = $myfiles[$i];
                    $extension = strtolower($file->getClientOriginalExtension());
                    $file_name = $faker->lexify($string = '???????????????????');
                    $url = $file_name.".".$extension;

                    //get image's information
                    $file_content = file_get_contents($file);
                    $image = new Imagick();
                    $image->pingImageBlob($file_content);
                    $dpi = $image->getImageResolution();
                    $dpi = $dpi['x'] > $dpi['y'] ? $dpi['x'] : $dpi['y'];
                    $size = $image->getImageLength();
                    $width = $image->getImageWidth();
                    $height = $image->getImageHeight();

                    $result[$i]['filename'] = $file->getClientOriginalName();
                    $result[$i]['result'] = true;

                    if($destination_store == 'dropbox')
                    {
                        try{
                            $this->filesystem->write($url, $file_content);
                        }catch (\Dropbox\Exception $e){
                            $result[$i]['result'] = false;
                            echo $e->getMessage();
                        }
                    }
                    else
                    {
                        $upload_folder = 'assets'.DS.'upload'.DS.'images'.DS.$image_id;
                        $imgDir = public_path().DS.$upload_folder;
                        if( !File::exists($imgDir) ) {
                            File::makeDirectory($imgDir, 0755);
                        }
                        $url = $upload_folder.DS.$url;
                        $url = str_replace('\\', '/', $url);

                        if(!VIImage::upload($file, $imgDir, $width, true, $file_name))
                        {
                            $result[$i]['result'] = false;
                        }

                    }

                    //insert to image_details table
                    $id = VIImageDetail::insertGetId([
                        'path' => $url,
                        'height' => $height,
                        'width' => $width,
                        'ratio' => $width / $height,
                        'dpi' => $dpi,
                        'size' => $size,
                        'extension' => $extension,
                        'type' => 'main',
                        'size_type' => $i+1,
                        'image_id' => $image_id
                    ]);
                    if(!$id)
                    {
                        $result[$i]['result'] = false;
                    }
                }

                Session::flash('message', $result);

            }
            else
            {
                Session::flash('message', 'Please choose the image!');
            }
            return Redirect::route('upload-page');
        }
        return Redirect::route('account-sign-in');
    }

    public function getImage($image_id, $image_name)
    {
        if( $img = VIImage::getImage($image_id, 'with-logo') )
        {
            $request = Request::instance();
            $response = Response::make( $img['image'], 200, [
                                    'Content-Type'      => 'image/jpeg',
                                ] );
            $time = date('r', $img['time']);
            $expires = date('r', strtotime('+1 year', $img['time']));

            $response->setLastModified(new DateTime($time));
            $response->setExpires(new DateTime($expires));
            $response->setPublic();

            if($response->isNotModified($request)) {
                return $response;
            } else {
                $response->prepare($request);
                return $response;
            }
        }
        //$file = $this->filesystem->read($image_name);

/*        $image = new Imagick();
        $image->pingImageBlob($file);
        $mimeType = $image->getImageMimeType();

        $response = Response::make($file, 200);
        $response->header('Content-Type', $mimeType);
        return $response;
*/
    }

    public function deleteFile()
    {
        if(Auth::user()->check())
        {
            $name = Input::get('del_file');
            $image_id = Input::get('image_id');
			$page = (Input::get('page')) ? (Input::get('page')) : '1';
			$result = array();
            try{
				$image = VIImage::findorFail($image_id);
				$store = $image->store;
				$image->delete();

                if($store == 'dropbox')
                {
                    try{
                        $this->filesystem->delete($name);
                    }catch (\Dropbox\Exception $e){
                        echo $e->getMessage();
                    }
                }
                else
                {
                    if($store == null || $store == '')
                    {
                        $path = public_path('assets'.DS.'upload'.DS.'images'.DS.$image_id);
                        $path = str_replace(['\\', '/'], DS, $path);
						try{
							File::deleteDirectory( $path );
						}catch (Exception $e){
							//echo $e->getMessage();
						}						                        
                    }
                }

                $result = 'Your image has removed successfully!';

                //return Response::json("{}", 200);
            }catch (Exception $e){
                //$result = $e;
            }

            Session::flash('message', $result);

            //return Redirect::route('upload-page');
			return Redirect::route('upload-page', array('page' => $page));
        }
        return Redirect::route('account-sign-in');
    }

}