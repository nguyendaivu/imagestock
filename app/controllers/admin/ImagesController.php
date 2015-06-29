<?php

use League\ColorExtractor\Client as ColorExtractor;

class ImagesController extends AdminController {

	public static $table = 'images';
	protected $take = 20;

	public function index()
	{
		if( !Input::has('page') ) {
			$pageNum = 1;
		} else {
			$pageNum = (int)Input::get('page');
		}
		$admin_id = Auth::admin()->get()->id;
		$arrCategories = [];
		$name = '';
		$take = $this->take;
		$skip = floor( ($pageNum -1) * $take );
		$images = VIImage::select('id', 'name', 'short_name', 'description', 'keywords',
									'artist', 'model', 'gender', 'age_from', 'age_to', 'number_people',
																					DB::raw('(SELECT COUNT(*)
																							FROM notifications
																				         	WHERE notifications.item_id = images.id
																				         		AND notifications.item_type = "Image"
																								AND notifications.admin_id = '.$admin_id.'
																								AND notifications.read = 0 ) as new'))
							->withType('main')
							->with('categories')
							->with('collections');
		if( Input::has('categories') ) {
			$arrCategories = (array)Input::get('categories');
			$images->whereHas('categories', function($query) use($arrCategories){
				$query->whereIn('id', $arrCategories);
			});
		}
		if( Input::has('name') ) {
			$name = Input::get('name');
			$nameStr = '*'.$name.'*';
			$images->search($nameStr);
		}
		$images = $images->take($take)
							->skip($skip)
							->orderBy('id', 'desc')
							->get();
		$arrImages = [];
		if( !$images->isempty() ) {
			$arrImages = $arrRemoveNew = [];
			foreach($images as $image) {
				$image->path = URL.'/pic/large-thumb/'.$image->short_name.'-'.$image->id.'.jpg';
				$image->dimension = $image->width.'x'.$image['height'];
				if( $image->new ) {
					$arrRemoveNew[] = $image->id;
				}
				$arrImages[$image->id] = $image;
				foreach(['arrCategories' => [
											'name' => 'categories',
											'id' 	=> 'id'
										],
						'arrCollections' => [
											'name' => 'collections',
											'id' => 'id'
										]
						] as $key => $value) {
					$arr = [];
					foreach($image->$value['name'] as $v) {
						$arr[] = $v[$value['id']];
					}
					$arrImages[$image->id][$key] = $arr;
				}
				unset($arr);
			}
			if( !empty($arrRemoveNew) ) {
				Notification::whereIn('item_id', $arrRemoveNew)
							->where('item_type', 'Image')
							->where('admin_id', $admin_id)
							->update(['read' => 1]);
			}
		}
		if( Request::ajax() ) {
			return $arrImages;
		}
		$this->layout->title = 'Images';
		$this->layout->content = View::make('admin.images-all')->with([
															'images' 		=> $arrImages,
															'pageNum'		=> $pageNum,
															'categories' 	=> Category::getSource(),
															'name' 			=> $name,
															'arrCategories' => $arrCategories,
															'collections' 	=> Collection::getSource(),
															'apiKey'		=> Configure::getApiKeys()
														]);
	}

	public function updateImage()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		$arrReturn = ['status' => 'error'];
		$id = Input::has('id') ? Input::get('id') : 0;
		if( $id ) {
			$create = false;
			try {
				$image = VIImage::findorFail( (int)Input::get('id') );
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$message = 'has been updated successful';
		} else {
			$create = true;
			$image = new VIImage;
			$message = 'has been created successful';
		}

		if( $create && !Input::hasFile('image') ) {
			return ['status' => 'error', 'message' => 'You need to upload at least 1 image.'];
		}

		$image->name = Input::get('name');
		$image->short_name = Str::slug($image->name );
		$image->description = Input::get('description');
		$image->keywords = Input::get('keywords');
		$image->keywords = rtrim(trim($image->keywords), ',');

		$image->model = Input::get('model');
		$image->model = rtrim(trim($image->model), ',');

		$image->artist = Input::get('artist');
		$image->age_from = Input::get('age_from');
		$image->age_to = Input::get('age_to');
		$image->gender = Input::get('gender');
		$image->number_people = Input::get('number_people');

		$pass = $image->valid();

		if( $pass->passes() ) 
		{
            if( Input::hasFile('image') )
            {
            	$color_extractor = new ColorExtractor;
	            $myfile = Input::file('image');

	            $mime_type = $myfile->getClientMimeType();
	            
	            switch ($mime_type) {
	                case 'image/jpeg':
	                    $palette_obj = $color_extractor->loadJpeg($myfile);
	                    break;
	                case 'image/png':
	                    $palette_obj = $color_extractor->loadPng($myfile);
	                    break;
	                case 'image/gif':
	                    $palette_obj = $color_extractor->loadGif($myfile);
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
	            $image->main_color = $main_color;
            }	

			$image->save();

	        //insert into statistic_images table
	        if($create)
	        {
        		StatisticImage::create([
	                'image_id'  =>$image->id,
	                'view'      => '0',
	                'download'  => '0',
	            ]);	        	
	        }
	

			foreach(['category_id' => 'categories', 'collection_id' => 'collections'] as $key => $value) {
				$arrOld = $remove = $add = [];
				$old = $image->$value;
				$data =  Input::has($key) ? Input::get($key) : [];
				$data = (array)json_decode($data[0]);
				if( !empty($old) ) {
					foreach($old as $val) {
						if( !in_array($val->id, $data) ) {
							$remove[] = $val->id;
						} else {
							$arrOld[] = $val->id;
						}
					}
				}

				foreach($data as $id) {
					if( !$id ) continue;
					if( !in_array($id, $arrOld) ) {
						$add[] = $id;
					}
				}

				if( !empty($remove) ) {
					$image->$value()->detach( $remove );
				}
				if( !empty($add) ) {
					$image->$value()->attach( $add );
				}
				foreach($add as $v) {
					$arrOld[] = $v;
				}
				$image->{'arr'.ucfirst($value)} = $arrOld;
			}

			$path = public_path('assets'.DS.'upload'.DS.'images'.DS.$image->id);
			if(  $create ) {
				$main = new VIImageDetail;
				$main->image_id = $image->id;
				$main->type = 'main';
				File::makeDirectory( $path, 0755, true );
			} else {
				$main = VIImageDetail::where('type', 'main')
										->where('image_id', $image->id)
										->first();
				File::delete( public_path( $main->path ) );
			}
			if( Input::hasFile('image') ) {
				$file = Input::file('image');
				$name = $image->short_name.'.'.$file->getClientOriginalExtension();
				$file->move($path, $name);
				$imageChange = true;
			} else if( Input::has('choose_image') && Input::has('choose_name') ) {
				$chooseImage = Input::get('choose_image');
				$name = Input::get('choose_name');
				file_put_contents($path.DS.$name, file_get_contents($chooseImage));
				$imageChange = true;
			}

			if( isset($imageChange) ) {
				$main->path = 'assets/upload/images/'.$image->id.'/'.$name;
				$img = Image::make($path.DS.$name);
				$main->width = $img->width();
				$main->height = $img->height();
				$main->ratio = $main->width / $main->height;
				$img = new Imagick($path.DS.$name);
				$dpi = $img->getImageResolution();
				$main->dpi = $dpi['x'] > $dpi['y'] ? $dpi['x'] : $dpi['y'];
				$main->size = $img->getImageLength();
				$main->extension = strtolower($img->getImageFormat());
				$main->save();
				BackgroundProcess::makeSize($main->detail_id);
				$image->changeImg = true;
				if( $create ) {
					$image->dimension = $main->width.'x'.$main->height;
					$image->newImg = true;
					$image->path = URL.'/pic/large-thumb/'.$image->short_name.'-'.$image->id.'.jpg';
				}
			}

			$arrReturn['status'] = 'ok';
			$arrReturn['message'] = "{$image->name} $message.";
			$arrReturn['data'] = $image;
			return $arrReturn;
		}
		$arrReturn['message'] = '';
		$arrErr = $pass->messages()->all();
		foreach($arrErr as $value)
		    $arrReturn['message'] .= "$value\n";

		return $arrReturn;
	}
}