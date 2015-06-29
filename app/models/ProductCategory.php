<?php

class ProductCategory extends BaseModel {

	protected $table = 'categories';

	protected $rules = [
			'name' 		=> 'required|min:6|unique:option_groups',
			'parent_id' => 'numeric'
	];

	public function valid()
    {
        $arr = $this->toArray();
        if(isset($arr['id'])) {
            $this->rules['name'] .= ',name,'.$arr['id'];
        }
        return Validator::make(
            $arr,
            $this->rules
        );
    }

	public static function get($arrArg = [])
	{
		if( Cache::has('categories') ) {
			$cache = Cache::get('categories');
		} else {
			$cache = self::getRecursive($arrArg);
			Cache::forever('categories', $cache);
		}
		return $cache;
	}

	public static function getHTML($arrOptions = [], $arrCategories = [], $html = '')
	{
		if( empty($arrCategories) ) {
			$arrCategories = self::get();
		}
		if( !isset($arrOptions['checked']) ) {
			$arrOptions['checked'] = [];
		}
		if( !isset($arrOptions['name']) ) {
			$arrOptions['name'] = 'categories';
		}
		foreach($arrCategories as $category) {
			$html .= '<ul class="list-unstyled">';
			$check = '';
			if( in_array($category['id'], $arrOptions['checked']) ) {
				$check = 'checked';
			}
			$html .=  '<li>
						<label>
							<input type="checkbox" name="'.$arrOptions['name'].'" value="'.$category['id'].'" '.$check.' />
							'.$category['name'].'
						</label>
					';
			if( isset($category['childrend']) ) {
				$html .= self::getHTML($arrOptions, $category['childrend']);
			}
			$html .= '</li>
					</ul>';
		}
		return $html;
	}

	private static function getRecursive($arrArg, $arrReturn = [])
	{
		if( !isset($arrArg['parent_id']) )
			$arrArg['parent_id'] = 0;
		$categories = self::select('id', 'name')
							->where('id', '<>', $arrArg['parent_id'])
							->where('parent_id', $arrArg['parent_id'])
							->where('active', 1)
							->orderBy('order_no', 'desc')
							->get();
		if( !$categories->isEmpty()  ) {
			$categories = $categories->toArray();
			foreach($categories as $category) {
				$arrReturn[$category['id']] = $category;
				$children = self::select('id', 'name')
									->where('parent_id', $category['id'])
									->where('active', 1)
									->orderBy('order_no', 'desc')
									->get();
				if( !$children->isEmpty() ) {
					$arrArg['parent_id'] =  $category['id'];
					$arrReturn[$category['id']]['childrend'] = self::getRecursive($arrArg);
				}
			}
		}
		return $arrReturn;
	}

	public static function getSource($toJson = false, $notIncludedId = 0, $notEmpty = false)
	{
		$arrReturn = [];
		if( !$notEmpty ) {
			$arrReturn[] = ['value' => 0, 'text' => '', 'short_name' => ''];
		}
		$arrData = self::select('id', 'name', 'short_name')->where('active', 1)->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				if( $data->id == $notIncludedId ) continue;
				$arrReturn[] = ['value' => $data->id, 'text' => $data->name, 'short_name' => $data->short_name];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

	public function images()
	{
		return $this->morphToMany('VIImage', 'imageable', 'imageables', 'imageable_id', 'image_id');
	}

	public function categories()
    {
        return $this->hasMany('ProductCategory', 'parent_id');
    }

    public function products($take = 0, $skip = 0)
	{
		$products = $this->belongsToMany('Product', 'products_categories', 'category_id', 'product_id')
									->orderBy('products.id', 'desc');
		if( $take ) {
			$products = $products->take($take);
		}
		if( $skip ) {
			$products = $products->skip($skip);
		}
		return $products;
	}

    public function firstProduct()
    {
        return $this->belongsToMany('Product', 'products_categories', 'category_id', 'product_id')
        				->with('mainImage')
        				->orderBy('products.id', 'desc')
        				->first();
    }

	public function menu()
	{
		return $this->belongTo('Menu', 'menu_id');
	}

    public function beforeDelete($category)
    {
    	$category->categories()->delete();
		$category->images()->detach();
		$category->products()->detach();
		$category->menu()->delete();
		return Cache::forget('categories');
    }

	public function afterSave($category)
	{
		return Cache::forget('categories');
	}

}