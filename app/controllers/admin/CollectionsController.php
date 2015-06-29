<?php

class CollectionsController extends AdminController {

	public static $table = 'collections';

	public function index()
	{
		$this->layout->title = 'Collection';
		$this->layout->pageBar = false;
		$this->layout->content = View::make('admin.collections-all')->with([
																		'collections' 	=> Collection::getAll(),
																		'types'			=> Type::getSource(false),
																		'categories'	=> Category::getSource(false),
																		'maxHeight'		=> 500
																	]);
	}

	public function getCollectionImages()
	{
		if( !Request::ajax() ) {
	        return App::abort(404);
	    }

	    $id = Input::has('id') ? Input::get('id') : 0;

	    $collection = Collection::with('images')
	    							->find($id);
	    if( $collection ) {
	    	$collection =  $collection->toArray();
	    	if( !empty($collection['images']) ) {
	    		foreach($collection['images'] as $key => $image) {
		    		if( $image['ratio'] > 1 ) {
		    			$width = 150;
		    			$height = $width / $image['ratio'];
		    		} else {
		    			$height = 150;
		    			$width = $height * $image['ratio'];
		    		}
	    			$collection['images'][$key] = [
	    											'id' 	=> $image['id'],
	    											'name' 	=> $image['name'],
	    											'short_name' 	=> $image['short_name'],
	    											'description' 	=> $image['description'],
	    											'path' 	=> URL.'/pic/thumb/'.$image['short_name'].'-'.$image['id'].'.jpg',
	    											'width' => $width,
	    											'height' => $height,
	    											'ratio' => $image['ratio'],
	    											'main' => $image['pivot']['type'] == 'main' ? 1 : 0
	    										];
	    		}
	    	}
	    	return $collection;
	    }

	    return [];
	}

	public function getImages()
	{
		if( !Request::ajax() ) {
	        return App::abort(404);
	    }

	    $id = Input::has('id') ? Input::get('id') : 0;

	    if( !Input::has('page') ) {
	    	$pageNum = 1;
	    } else {
	    	$pageNum = (int)Input::get('page');
	    }

	    $name = '';
	    $take = 25;
	    $skip = floor( ($pageNum -1) * $take );
	    $images = VIImage::select('id', 'name', 'short_name')
	    					->withType('main')
	    					->whereRaw('id NOT IN (SELECT image_id FROM collections_images WHERE collection_id = ?)',
	    								[$id]);
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
	    $total = $images->count();
	    $images = $images->take($take)
	    		->skip($skip)
	    		->orderBy('id', 'desc')
	    		->get();
	    $arrReturn = [];
	    $arrReturn['total_page'] = ceil($total / $take);
	    $arrReturn['page'] = $pageNum;
	    if( !$images->isEmpty() ) {
	    	foreach($images as $image) {
	    		if( $image->ratio > 1 ) {
	    			$width = 150;
	    			$height = $width / $image->ratio;
	    		} else {
	    			$height = 150;
	    			$width = $height * $image->ratio;
	    		}
	    		$arrReturn['data'][] = [
	    				'id'	=> $image->id,
	    				'name' 	=> $image->name,
	    				'short_name' => $image->short_name,
	    				'path' 	=> URL.'/pic/thumb/'.$image->short_name.'-'.$image->id.'.jpg',
	    				'width' => $width,
	    				'height' => $height,
	    				'ratio' => $image->ratio
	    		];
	    	}
	    }

	    return $arrReturn;
	}

	public function updateCollection()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}

		if( Input::has('id') ) {
			try {
				$collection = Collection::findorFail( (int)Input::get('id') );
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$message = 'has been updated successful.';
		} else {
			$collection = new Collection;
			$message = 'has been created successful.';
		}
		if( Input::has('name') ) {
			$collection->name = Input::get('name');
			$collection->short_name = Str::slug($collection->name);
		}
		if( Input::has('type_id') ) {
			$collection->type_id = Input::get('type_id');
		}
		if( Input::has('on_screen') ) {
			$collection->on_screen = (int)Input::get('on_screen');
		}
		$pass = $collection->valid();

		if( $pass->passes() ) {

			$collection->save();

			return ['status' => 'ok', 'message' => 'Collection <b>'.$collection->name.'</b> '.$message, 'data' => $collection];
		}

		$message = '';
		$arrErr = $pass->messages()->all();
		foreach($arrErr as $value)
			$message .= "$value\n";

		return ['status' => 'error', 'message' => $message];

	}

	public function updateImage()
	{
		if( !Request::ajax() ) {
	        return App::abort(404);
	    }

	    $id = Input::has('id') ? Input::get('id') : 0;
	    $image_id = Input::has('image_id') ? Input::get('image_id') : 0;
	    $name = Input::has('name') ? Input::get('name') : '';
	    $arrReturn = ['status' => 'error', 'message' => 'Collection was not existed.'];
	    if( $id && $image_id ) {
	    	try {
	    		$collection = Collection::findorFail( $id );
	    	} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	    		return App::abort(404);
	    	}
	    	$type = Input::has('type') ? Input::get('type') : '';
	    	$arrReturn = ['message' => 'Please do a valid type action. [Append, Delete]'];
	    	if( !empty($type) ) {
	    		if( $type == 'append' ) {
	    			$collection->images()->attach([$image_id]);
	    			$arrReturn = ['status' => 'ok', 'message' => 'Image <b>'. $name .'</b> has been added to collection <b>'. $collection->name .'</b>.'];
	    		} else if( $type == 'delete' ) {
	    			$collection->images()->detach([$image_id]);
	    			$arrReturn = ['status' => 'ok', 'message' => 'Image <b>'. $name .'</b> has been removed from collection <b>'. $collection->name .'</b>.'];
	    		} else if( $type == 'main' ) {
	    			CollectionImage::where('collection_id', $id)
	    								->update([
											'collections_images.type' => NULL,
										]);
	    			$main = Input::get('main');
	    			if( $main ) {
	    				CollectionImage::where('collection_id', $id)
	    									->where('image_id', $image_id)
	    									->update([
													'collections_images.type' => 'main',
													]);
	    				$arrReturn = ['status' => 'ok', 'message' => 'Image <b>'. $name .'</b> has been set as main Photo'];
	    			} else {
	    				$arrReturn = ['status' => 'ok', 'message' => 'Image <b>'. $name .'</b> has been unset as main Photo'];
	    			}
	    		}
	    	}
	    }
		return $arrReturn;
	}

	public function deleteCollection($id)
	{
		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$collection = Collection::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $collection->name;
   		    if( $collection->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "Collection <b>{$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
	}
}