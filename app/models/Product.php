<?php

class Product extends BaseModel {

	protected $table = 'products';

	protected $rules = [
			'name' 		=> 'required|min:6|unique:products',
			'sku' 		=> 'required|unique:products',
			'price' 	=> 'integer',
			'active' 	=> 'integer',
	];

	public function valid()
    {
        $arr = $this->toArray();
        if(isset($arr['id'])) {
            $this->rules['name'] .= ',name,'.$arr['id'];
            $this->rules['sku'] .= ',sku,'.$arr['id'];
        }
        return Validator::make(
            $arr,
            $this->rules
        );
    }

	public function images()
	{
		return $this->morphToMany('VIImage', 'imageable', 'imageables', 'imageable_id', 'image_id')
						->withPivot('option')
						->orderBy('imageables.id', 'desc');
	}

	public function mainImage()
	{
		return $this->morphToMany('VIImage', 'imageable', 'imageables', 'imageable_id', 'image_id')
						->withPivot('option')
						->select('images.id')
						->where('option', 'like', '%"main":1%');
	}

	public function options()
	{
		return $this->morphedByMany('ProductOption', 'optionable', 'optionables', 'product_id')
						->withPivot('option')
						->orderBy('options.name', 'asc');
	}

	public function optionGroups()
	{
		return $this->morphedByMany('ProductOptionGroup', 'optionable', 'optionables', 'product_id')
						->withPivot('option')
						->orderBy('option_groups.name', 'asc');
	}

	public function categories()
	{
		return $this->belongsToMany('ProductCategory', 'products_categories', 'product_id', 'category_id');
	}

	public function category($categoryName)
	{
		return $this->belongsToMany('ProductCategory', 'products_categories', 'product_id', 'category_id')
									->where('categories.short_name', $categoryName);

	}

	public function type()
	{
		return $this->belongsTo('ProductType', 'product_type_id');
	}

	public function priceBreaks()
    {
        return $this->hasMany('PriceBreak', 'product_id')
        				->orderBy('price_breaks.range_from', 'asc');
    }

    public function sizeLists()
    {
        return $this->hasMany('SizeList', 'product_id')
        				->orderBy('size_lists.sizew', 'asc')
        				->orderBy('size_lists.sizeh', 'asc');
    }

    public function layout()
	{
		return $this->belongsTo('Layout', 'svg_layout_id');
	}

	public function shapeLayout()
	{
		return $this->belongsTo('ShapeLayout', 'svg_layout_id');
	}

	public static function getSource($toJson = false)
	{
		$arrReturn = [];
		$arrReturn[] = ['value' => 0, 'text' => '', 'short_name' => ''];
		$arrData = self::select('id', 'name', 'short_name')->where('active', 1)->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				$arrReturn[$data->id] = ['value' => $data->id, 'text' => $data->name, 'short_name' => $data->short_name];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

	public static function getPrice($data)
	{
		if( isset($data->products) ) {
			return JTProduct::getPriceByManyProducts($data);
		}

		return JTProduct::getPrice($data);
	}

	public static function getSmallestPrice($product, $includeSize = false)
	{
		$sizew = $sizeh = $bleed = 0;
		if( !isset($product->size_lists) ) {
			$smallestSize = SizeList::where('product_id', $product->id)
						->cacheTags(['size_lists', 'products'])
						->orderBy('size_lists.sizew', 'asc')
						->orderBy('size_lists.sizeh', 'asc')
						->remember(30)
						->first();
			if( is_object($smallestSize) ) {
				$sizew = $smallestSize->sizew;
				$sizeh = $smallestSize->sizeh;
			}
		} else {
			$min = [];
			foreach($product->size_lists as $size_list) {
				if( !isset($min->sizew) || $min->sizew > $size_list->sizew ) {
					$min = $size_list;
				}
			}
		}
		$smallestDepth = ProductOption::select('name')
						->whereIn('id', function($query) use ($product){
							$query->select('optionable_id')
									->from('optionables')
									->where('product_id', $product->id)
									->where('optionable_type', 'ProductOption');
						})
						->whereIn('option_group_id', function($query){
							$query->select('id')
									->from('option_groups')
									->where('key', 'depth');
						})
						->orderBy('key', 'asc')
						->first();
		if( is_object($smallestDepth) ) {
			$bleed = (float)str_replace('" Box', '', $smallestDepth->name);
		}
		if( $sizew && $sizeh || $bleed ) {
			$product->sizew = $sizew;
			$product->sizeh = $sizeh;
			$product->bleed = $bleed;
			$price = JTProduct::getPrice($product);
			$sellPrice = $price['sell_price'];
		} else {
			$sellPrice = JTProduct::getDefaultPrice($product);
		}
		if( $includeSize ) {
			return [
				'sell_price' => $sellPrice,
				'sizew'		 => $sizew,
				'sizeh'		 => $sizeh
			];
		}
		return $sellPrice;
	}

	public static function viFormat($number)
	{
		//return number_format($number, Configure::getFormat());
		return number_format($number, 2);
	}

	public function afterSave($product)
	{
		Cache::tags(['products', 'sizelists'])->flush();
	}

	public function beforeDelete($product)
	{
		Cache::tags(['products', 'sizelists'])->flush();
		$product->images()->detach();
		$product->categories()->detach();
		$product->options()->detach();
		$product->optionGroups()->detach();
		$product->priceBreaks()->delete();
		$product->sizeLists()->delete();
	}

	public function afterCreate($product)
	{
		Notification::add($product->id, 'Product');
	}

	public static function getProductByKey($arrData)
	{
		$skip = isset($arrData['skip']) ? $arrData['skip'] : 0;
		$take = isset($arrData['take']) ? $arrData['take'] : 0;
		$key = isset($arrData['key'])?$arrData['key']:'';
		$key = trim($key);
		$key = explode("+", $key);
		$raw_query = '';
		foreach ($key as $index => $value) {
			if($index==0)
				$raw_query.='`name` like "%'.$value.'%"  or `short_name` like "%'.$value.'%" ';
			else
				$raw_query.='or `name` like "%'.$value.'%"  or `short_name` like "%'.$value.'%" ';
		}
		$products = Product::select('id', 'sku', 'short_name', 'name')
					->with(['images'=> function($query){
						$query->select('path');
						$query->where('imageables.option', 'like', '%"main":1%');
					}])
					->with(['categories'=> function($query){
						$query->select('short_name');
					}])
					->whereRaw($raw_query)
					->where('active', 1)
					->take($take)
					->skip($skip)
					->orderBy('id', 'desc')
					->get();
		if( !$products->isEmpty() ) {
			foreach($products as $key => $product) {
				$product->sell_price = Product::getSmallestPrice($product);
				if( isset($product->images[0]) ) {
					$product->image = URL.'/'.str_replace('/images/products/', '/images/products/thumbs/', $product->images[0]->path);
				} else {
					$product->image = URL.'/assets/images/noimage/213x213.gif';
				}
				if( isset($product->categories[0]) ) {
					$product->category =$product->categories[0]['short_name'];
				} else {
					$product->category = '';
				}
				unset($product->images);
				unset($product->categories);
			}
			$products = $products->toArray();
			return $products;
		}
		return [];
	}

	public static function getTotalPageByKey($key,$take)
	{
		$key = trim($key);
		$key = explode("+", $key);
		$raw_query = '';
		foreach ($key as $index => $value) {
			if($index==0)
				$raw_query.='`name` like "%'.$value.'%"  or `short_name` like "%'.$value.'%" ';
			else
				$raw_query.='or `name` like "%'.$value.'%"  or `short_name` like "%'.$value.'%" ';
		}
		$total = Product::select('id')
					->whereRaw($raw_query)
					->where('active', 1)
					->count('id');
		return round( $total / $take );
	}
}