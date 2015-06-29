<?php

class CollectionImagesController extends BaseController {

	public function index($collectionId)
	{
		try {
			$collection = Collection::with('images')
				    					->findOrFail($collectionId);
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return App::abort(404);
		}

    	$collection =  $collection->toArray();
    	if( !empty($collection['images']) ) {
    		foreach($collection['images'] as $key => $image) {
    			$height = 175;
    			$width = $height * $image['ratio'];
    			$collection['images'][$key] = [
    											'id' 	=> $image['id'],
    											'name' 	=> $image['name'],
    											'short_name' 	=> $image['short_name'],
    											'description' 	=> $image['description'],
    											'path' 	=> URL.'/pic/with-logo/'.$image['short_name'].'-'.$image['id'].'.jpg',
    											'width' => $width,
    											'height' => $height,
    										];
    		}
    	}

		$this->layout->content = View::make('frontend.collections.index')->with([
																				'collection' => $collection
																			]);
	}
}
