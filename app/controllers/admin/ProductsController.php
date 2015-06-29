<?php

class ProductsController extends AdminController {

	public static $table = 'products';

	public function index()
	{
		$this->layout->title = 'Products';
		$this->layout->content = View::make('admin.products-all')->with([
																		'arrCategories' => ProductCategory::getSource()
																	]);
	}

	public function listProduct()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		$admin_id = Auth::admin()->get()->id;

		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$products = Product::with('mainImage')
							->select(DB::raw('id, name, sku, sell_price, short_description, active,
												(SELECT COUNT(*)
													FROM notifications
										         	WHERE notifications.item_id = products.id
										         		AND notifications.item_type = "Product"
														AND notifications.admin_id = '.$admin_id.'
														AND notifications.read = 0 ) as new'));
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'active' ) {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
					$products->where($key, $value);
				} else if( $key == 'sell_price' ) {
					$value = trim($value);
					if( strpos($value, '-') !== false ) {
						list($from, $to) = explode('-', $value);
						$products->where($key, '>', (float)$from);
						$products->where($key, '<', (float)$to);
					} else {
						$products->where($key, (float)$value);
					}
				} else if( $key == 'category' && !empty($value) ) {
					if( is_numeric($value) ) {
						$products->whereHas('categories', function($query) use($value) {
							$query->where('categories.id', $value);
						});
					} else if( is_array($value) ) {
						foreach($value as $k => $v) {
							if( empty($v) ) {
								unset($value[$k]);
							}
						}
						if( empty($value) ) continue;
						$products->whereHas('categories', function($query) use($value) {
							$query->whereIn('categories.id', $value);
						});
					} else {
						$products->whereHas('categories', function($query) use($value) {
							$query->where('categories.name', 'like', '%'.$value.'%');
						});
					}
				} else {
					$value = ltrim(rtrim($value));
					$products->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$products->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
		$count = $products->count();
		if($length > 0) {
			$products = $products->skip($start)->take($length);
		}
		$arrProducts = $products->get();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Product::count(), 'recordsFiltered' => $count, 'data' => []];
		$arrRemoveNew = [];
		if(!empty($arrProducts)){
			foreach($arrProducts as $product){
				if( isset($product->main_image[0]) ) {
					$image = URL.'/'.str_replace('/images/products', '/images/products/thumbs', $product->main_image[0]->path);
				} else {
					$image = URL.'/assets/images/noimage/110x110.gif';
				}
				$name = $product->name;
				if( $product->new ) {
					$name .= '| <span class="badge badge-danger">new</span>';
					$arrRemoveNew[] = $product->id;
				}
				if( empty($product->short_description) ) {
					$product->short_description = '(empty)';
				}
				$data = Product::getSmallestPrice($product, true);
				$arrReturn['data'][] = array(
								  ++$start,
								  $product->id,
								  $name,
								  $product->sku,
								  "({$data['sizew']}x{$data['sizeh']})|{$data['sell_price']}",
								  $image,
								  $product->short_description,
								  $product->active,
								  );
			}
		}
		if( !empty($arrRemoveNew) ) {
			Notification::whereIn('item_id', $arrRemoveNew)
						->where('item_type', 'Product')
						->where('admin_id', $admin_id)
						->update(['read' => 1]);
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function addProduct()
	{
		$this->layout->title = 'Add Product';
		$this->layout->content = View::make('admin.products-one')->with([
															/*'categories' 	=> ProductCategory::getHTML([
																				'name' 		=> 'categories[]',
																			]),*/
															'arrCategories'	=> ProductCategory::getSource(false, 0, true),
															'arrChosenCategories' => [],
															'types'			=> ProductType::getSource(),
															'option_groups'	=> ProductOptionGroup::getSource(false, true),
															'layouts'		=> Layout::getSource(),
															'product'		=> [
																				'margin_up' => Configure::getMargin()
																			]
															]);
	}

	public function editProduct($productId)
	{
		try {
			$product = Product::with('images')
								->with('categories')
								->with('optionGroups')
								->with('options')
								->with('priceBreaks')
								->with('sizeLists')
								->findorFail($productId);
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return App::abort(404);
		}
		$product = $product->toArray();
		foreach(['option_groups', 'options'] as $value) {
			$tmpData = [];
			if( !empty($product[$value]) ){
				foreach($product[$value] as $v) {
					$tmpData[] = $v['id'];
				}
			}
			$product[$value] = $tmpData;
			unset($tmpData);
		}
		$product['sell_price'] = number_format($product['sell_price'], 2);
		$arrCategories = [];
		if( !empty($product['categories']) ) {
			foreach($product['categories'] as $category) {
				$arrCategories[] = $category['id'];
			}
		}
		$this->layout->title = 'Edit Product';
		$this->layout->content = View::make('admin.products-one')->with([
															'product' 		=> $product,
															/*'categories' 	=> ProductCategory::getHTML([
																				'name' 		=> 'categories[]',
																				'checked' 	=> $arrCategories
																			]),*/
															'arrCategories' => ProductCategory::getSource(false, 0, true),
															'arrChosenCategories' => $arrCategories,
															'types'			=> ProductType::getSource(),
															'option_groups'	=> ProductOptionGroup::getSource(false, true),
															'layouts'=>array()
															// 'layouts'		=> Layout::getSource()
															]);
	}

	public function updateProduct()
	{
   		if( Input::has('pk') ) {
   			if( !Request::ajax() ) {
	   			return App::abort(404);
	   		}
	   		return self::updateQuickEdit();
		}
		$prevURL = Request::header('referer');
		if( !Request::isMethod('post') ) {
			return App::abort(404);
		}
		if( Input::has('id') ) {
			$create = false;
			try {
				$product = Product::findorFail( (int)Input::get('id') );
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$message = 'has been updated successful';
		} else {
			$create = true;
			$product = new Product;
			$message = 'has been created successful';
		}
		if( !Input::has('categories') ) {
			return Redirect::to($prevURL)->with('flash_error',['Please choose at least one category.'])->withInput();
		}
		$product->name 			= Input::get('name');
		$product->short_name 	= Str::slug($product->name);
		$product->sku  			= Input::get('sku');
		$product->sell_price  	= Input::has('sell_price') ? round((float)str_replace(',', '', Input::get('sell_price')), 2) : 0;
		$product->margin_up  	= (float)Input::get('margin_up');
		$product->product_type_id  	 = (int)Input::get('product_type_id');
		$product->order_no  	= (int)Input::get('order_no');
		$product->custom_size  	= Input::has('custom_size') ? 1 : 0;
		$product->active  	  	= Input::has('active') ? 1 : 0;
		$product->meta_title 	 	 = e(Input::get('meta_title'));
		$product->meta_description   = e(Input::get('meta_description'));
		$product->short_description  = e(Input::get('short_description'));
		$product->description   = Input::get('description');
		$product->default_view  = json_encode(Input::has('default_view') ? Input::get('default_view') : []);

		$product->svg_layout_id 	= Input::has('svg_layout_id') ? Input::get('svg_layout_id') : 0;

		$pass = $product->valid();

		if( Input::hasFile('svg_file') ) {
			$file = Input::file('svg_file');
			// if( $file->getMimeType() === 'image/svg+xml' ) {
				$path = public_path().DS.'assets'.DS.'svg';
				if( !File::exists($path) ) {
					File::makeDirectory($path);
				}
				$fileName = md5($file->getClientOriginalName()).'.svg';
				if( $file->move($path, $fileName) ) {
					if( isset($product->svg_file) && File::exists(public_path().DS.$product->svg_file) ) {
						File::delete($product->svg_file);
					}
					$product->svg_file = 'assets/svg/'.$fileName;
				}
			/*} else {
				return Redirect::to($prevURL)->with('flash_error',['SVG file is not valid.'])->withInput();
			}*/
		}

		if( $pass->passes() ) {
			$product->save();
			// Category, Option Group, Option ==================================================================
			$arr = ['categories' => 'categories', 'optionGroups' => 'option_group_id', 'options' => 'option_id'];
			foreach($arr as $key => $value) {
				$old = $product->$key->toArray();
				$arrData = Input::has($value) ? Input::get($value) : [];
				$arrOld = $remove = $add = [];
				if( !empty($old) ) {
					foreach($old as $val) {
						$arrOld[] = $val['id'];
						if( !in_array($val['id'], $arrData) ) {
							$remove[] = $val['id'];
						}
					}
				}

				foreach($arrData as $id) {
					if( !in_array($id, $arrOld) ) {
						$add[] = $id;
					}
				}

				if( !empty($remove) ) {
					$product->$key()->detach( $remove );
				}
				if( !empty($add) ) {
					$product->$key()->attach( $add );
				}
			}
			// End ==============================================================================================
			// Images ===========================================================================================
			$path = public_path().DS.'assets'.DS.'images'.DS.'products';

			$removeImages = $createImages = [];
			if( Input::has('images') ) {
				$images = Input::get('images');
				foreach($images as $key => $image) {
					$data = ['main' => 0, 'view' => []];
					if( isset($image['delete']) && $image['delete'] ){
						$removeImages[] = $image['id'];
						unset($images[$key]);
						continue;
					}
					if( isset($image['view']) && !empty($image['view']) ) {
						foreach($image['view'] as $optionGroupID => $optionID)  {
							if( !$optionID ) continue;
							$data['view'][$optionID] = $optionID;
						}
						$data['view'] = array_values($data['view']);
					}
					if( isset($image['main']) ) {
						$data['main'] = 1;
					}
					$data = json_encode($data);
					$image_id = 0;
					if( Input::hasFile("images.$key.file") ){
						$file = Input::file("images.$key.file");
						$image_id = VIImage::upload($file, $path, 500);

					} else if( isset($image['choose_image']) ) {
						$image_id = $image['choose_image'];
					}
					if( $image_id != 0 ) {
						if( isset($image['id']) ) {
							$product->images()->updateExistingPivot( $image['id'], ['image_id' => $image_id, 'option' =>  $data] );
						} else {
							$createImages[$image_id] = ['option' => $data, 'imageable_id' => $product->id, 'imageable_type' => 'Product'];
						}
					} else {
						if( isset($image['new']) ) {
							continue;
						} else {
							$product->images()->updateExistingPivot( $image['id'], ['option' =>  $data] );
						}
					}
				}
				if( !empty($removeImages) ) {
					$product->images()->detach( $removeImages );
				}
				if( !empty($createImages) ) {
					$product->images()->attach( $createImages );
				}
			}
			// End ==============================================================================================
			// Price breaks =====================================================================================
			$removePB = $createPB = [];
			if( Input::has('price_breaks') ) {
				$price_breaks = Input::get('price_breaks');
				foreach( $price_breaks as $id => $pk ) {
					$pk['sell_price'] = str_replace(',', '', $pk['sell_price']);
					if( isset($pk['id']) ) {
						if( isset($pk['delete']) && $pk['delete'] ) {
							$removePB[] = $pk['id'];
						} else {
							$product->priceBreaks()->where('price_breaks.id', $pk['id'])->update([
																						'range_from' 	=> (int)$pk['range_from'],
																						'range_to' 		=> (int)$pk['range_to'],
																						'sell_price' 	=> (float)$pk['sell_price'],
																					]);
						}
					} else {
						$createPB[] = new PriceBreak([
											'range_from' 	=> (int)$pk['range_from'],
											'range_to' 		=> (int)$pk['range_to'],
											'sell_price' 	=> (float)$pk['sell_price']
										]);
					}
				}

				if( !empty($removePB) ) {
					PriceBreak::destroy($removePB);
				}

				if( !empty($createPB)  ) {
					$product->priceBreaks()->saveMany($createPB);
				}
			}
			// End ==============================================================================================
			// Price lists ======================================================================================
			$removeSL = $createSL = [];
			if( Input::has('price_lists') ) {
				$size_lists = Input::get('price_lists');
				foreach( $size_lists as $id => $sl ) {
					$arr = [];
					foreach( [ 'sizew', 'sizeh', 'cost_price', 'sell_price', 'bigger_price', 'sell_percent', 'bigger_percent'] as $float ) {
						$sl[$float] = (float)str_replace(',', '', $sl[$float]);
						$arr[$float] = $sl[$float];
					}
					$arr['default'] = 0;
					if( isset($sl['default']) ) {
						$arr['default'] = 1;
					}
					if( isset($sl['id']) ) {
						if( isset($sl['delete']) && $sl['delete'] ) {
							$removeSL[] = $sl['id'];
						} else {
							$product->sizeLists()->where('size_lists.id', $sl['id'])->update($arr);
						}
					} else {
						$createSL[] = new SizeList($arr);
					}
				}

				if( !empty($removeSL) ) {
					SizeList::destroy($removeSL);
				}

				if( !empty($createSL)  ) {
					$product->sizeLists()->saveMany($createSL);
				}
			}
			// End ==============================================================================================
			if( Input::has('continue') ) {
				if( $create ) {
					$prevURL = URL.'/admin/products/edit-product/'.$product->id;
				}
				return Redirect::to($prevURL)->with('flash_success',"<b>$product->name</b> {$message}.");
			}
			return Redirect::to(URL.'/admin/products')->with('flash_success',"<b>$product->name</b> {$message}.");
		}

		return Redirect::to($prevURL)->with('flash_error',$pass->messages()->all())->withInput();
	}

	public function updateQuickEdit()
	{
   		$arrReturn = ['status' => 'error'];
   		$id = (int)Input::get('pk');
   		$name = (string)Input::get('name');
   		$value = Input::get('value');
   		try {
   			$product = Product::findorFail($id);
   			$product->$name = $value;
	    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	        return App::abort(404);
	    }
	    $pass = $product->valid();
        if($pass->passes()) {
        	$product->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = $product->name.' has been saved';
        } else {
        	$arrReturn['message'] = '';
        	$arrErr = $pass->messages()->all();
        	foreach($arrErr as $value)
        	    $arrReturn['message'] .= "$value\n";
        }
        $response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public static function imageBrowser($page = 1)
	{
		if( Request::ajax() ) {
			if( Input::has('page') ) {
				$page = Input::get('page');
			}
			$response = Response::json(VIImage::imageBrowser('products', $page));
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return App::abort(404);
	}

	public function deleteProduct($id)
	{
		if( Request::ajax() ) {
			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
			try {
				$product = Product::findorFail($id);
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$name = $product->name;
			if( $product->delete() )
				$arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return App::abort(404);
	}

	public function autocompleSku()
	{
		$arrReturn = [];
		if( Request::ajax() && Input::has('sku') ) {
			$sku = (string)Input::get('sku');
			$products = JTProduct::select('sku', 'name')
						->where('deleted', false)
						->where('sku', 'like', '%'.$sku.'%')
						->where('product_type', 'web')
						->get();
			if( !$products->isEmpty() ) {
				foreach($products as $product) {
					$arrReturn[] = ['sku' => $product->sku, 'name' => isset($product->name) ? $product->name : ''];
				}
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function checkSku()
	{
		$arrReturn = ["check" => "error"];
		if( Request::ajax() && Input::has('sku') ) {
			$sku = (string)Input::get('sku');
			$count = JTProduct::select('sku', 'name')
						->where('deleted', false)
						->where('sku', $sku)
						->where('product_type', 'web')
						->count();
			if( $count ) {
				$arrReturn = ["check" => "ok"];
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function getCostPrice()
	{
		$arrReturn = ['status' => 'error'];
		if( Request::ajax() && Input::has('sku') ) {
			$sku 	= (string)Input::get('sku');

			$product = JTProduct::select('code', 'name', 'sku', 'sell_price', 'oum', 'oum_depend', 'sell_by','pricebreaks', 'sellprices', 'unit_price','options', 'products_upload', 'product_desciption', 'is_custom_size')
						->where('deleted', false)
						->where('sku', $sku)
						->where('product_type', 'web')
						->first();
			$sizew 	= (float)Input::get('sizew');
			$sizeh 	= (float)Input::get('sizeh');
			$costPrice = 0;
			if( is_object($product) ) {
				$costPrice = JTProduct::calculateCostPrice($product, $sizew, $sizeh);
			}
			$arrReturn = ['status' => 'ok', 'cost_price' => number_format($costPrice,2)];
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function listJtProducts()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$products = JTProduct::select('_id', 'code', 'sku', 'name', 'product_type', 'product_category', 'oum', 'sell_by', 'sell_price')
								->where('deleted', false)
								->where('name', 'not regexp', '/^blank/i');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				$value = ltrim(rtrim($value));
				if( $key == 'code' ) {
					$products->where($key, (int)$value);
				} else {
					$products->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$products->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
		$count = $products->count();
		if($length > 0) {
			$products = $products->skip($start)->take($length);
		}
		$arrProducts = $products->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => JTProduct::where('deleted', false)->count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrProducts)){
			foreach($arrProducts as $product){
				$arrReturn['data'][] = array(
								  ++$start,
								  $product['_id'],
								  isset($product['code']) ? $product['code'] : '',
								  $product['sku'],
								  isset($product['name']) ? $product['name'] : '',
								  isset($product['product_type']) ? $product['product_type'] : '',
								  isset($product['product_category']) ? $product['product_category'] : '',
								  isset($product['oum']) ? $product['oum'] : '',
								  isset($product['sell_by']) ? $product['sell_by'] : '',
								  number_format((float)$product['sell_price'], 2),
								  );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}
}