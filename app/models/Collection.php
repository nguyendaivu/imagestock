<?php

class Collection extends BaseModel {

	protected $table = 'collections';

    protected $rules = [
                'name'      => 'required',
            ];

	public function images()
    {
        return $this->belongsToMany('VIImage', 'collections_images', 'collection_id', 'image_id')
                    ->withPivot('type')
                    ->addSelect('images.*', 'image_details.width', 'image_details.height', 'image_details.ratio')
                    ->join('image_details', 'images.id', '=', 'image_details.image_id')
                    ->groupBy('images.id');
    }

    public function mainImage()
    {
        return $this->belongsToMany('VIImage', 'collections_images', 'collection_id', 'image_id')
                    ->addSelect('images.*', 'image_details.width', 'image_details.height', 'image_details.ratio')
                    ->join('image_details', 'images.id', '=', 'image_details.image_id')
        				->where('collections_images.type', 'main');
    }

    public function type()
    {
        return $this->belongsTo('Type');
    }

    public static function getAll()
    {
    	$arrData = [];
    	$collections = self::select('id', 'name', 'type_id', 'on_screen', DB::raw('
    															(SELECT COUNT(*)
                                                                 FROM `collections_images`
                                                                 WHERE `collections_images`.`collection_id` = `collections`.`id`) as image_total'))
    						->with('type')
    						->orderBy('name', 'asc')
    						->get();
    	if( !$collections->isEmpty() ) {
    		$arrData = $collections->toArray();
    	}
    	return $arrData;
    }

    public static function getSource($toJson = false, $notEmpty = false)
	{
		$arrReturn = [];
		if( !$notEmpty ) {
			$arrReturn[] = ['value' => 0, 'text' => ''];
		}
		$arrData = self::select('id', 'name')->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				$arrReturn[] = ['value' => $data->id, 'text' => $data->name];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

    public static function getFrontend($type)
    {
        $collections = self::with('mainImage')
                                //->where('on_screen', true)
                                ->where('type_id', $type)
                                ->take(8)
                                ->orderBy('order_no', 'asc')
                                ->get();
        $arrData = [];
        if( !$collections->isempty() ) {
            foreach($collections as $collection) {
                $image = null;
                if( isset($collection->main_image[0]) ) {
                    $image = $collection->main_image[0];
                } else {
                    $image = CollectionImage::select('images.id', 'images.short_name', 'images.name', 'image_details.ratio')
                                    ->join('images', 'images.id', '=', 'collections_images.image_id')
                                    ->join('image_details', 'image_details.image_id', '=', 'images.id')
                                    ->where('collections_images.collection_id', $collection->id)
                                    ->first();
                }
                if(  $image ) {
                    $image = [
                            'id' => $image->id,
                            'short_name' => $image->short_name,
                            'name'  => $image->name,
                            'ratio' => $image->ratio
                        ];
                } else {
                    $image = [];
                }
                $arrData[] = [
                                'id'    => $collection->id,
                                'name'  => $collection->name,
                                'short_name'    => $collection->short_name,
                                'image' => $image
                            ];
            }
        }
        return $arrData;
    }

    public function beforeDelete($collection)
    {
        $collection->images()->detach();
    }

}