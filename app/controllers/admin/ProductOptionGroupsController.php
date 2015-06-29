<?php

class ProductOptionGroupsController extends AdminController {

	public static $table = 'options';
    public static $name = 'Product Option Groups';

	public function index()
	{
		$this->layout->title = 'Product Option Groups';
		$this->layout->content = View::make('admin.product-option-groups-all');
	}

	public function listProductOptionGroup()
   	{
   		if( !Request::ajax() ) {
            return App::abort(404);
        }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$productOptionGroups = ProductOptionGroup::select('id', 'name', 'key', 'description');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
                $value = ltrim(rtrim($value));
        		$productOptionGroups->where($key,'like', '%'.$value.'%');
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$productOptionGroups->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $productOptionGroups->count();
        if($length > 0) {
			$productOptionGroups = $productOptionGroups->skip($start)->take($length);
		}
		$arrOptionGroups = $productOptionGroups->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => ProductOptionGroup::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrOptionGroups)){
			foreach($arrOptionGroups as $optionGroup){
				$arrReturn['data'][] = array(
	                              ++$start,
	                              $optionGroup['id'],
	                              $optionGroup['name'],
	                              $optionGroup['key'],
	                              $optionGroup['description'],
	                              );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
   	}

   	public function updateProductOptionGroup()
   	{
   		if( !Request::ajax() ) {
   			return App::abort(404);
   		}
   		$arrReturn = ['status' => 'error'];
   		if( Input::has('pk') ) {
	   		$id = (int)Input::get('pk');
	   		$name = (string)Input::get('name');
	   		$value = e((string)Input::get('value'));
	   		try {
	   			$optionGroup = ProductOptionGroup::findorFail($id);
	   			$optionGroup->$name = $value;
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
   		} else {
   			$optionGroup = new ProductOptionGroup;
   			$optionGroup->name = Input::get('name');
   			$optionGroup->key = Input::get('key');
   			$optionGroup->description = Input::get('description');
   		}
	    $pass = $optionGroup->valid();
        if($pass->passes()) {
        	$optionGroup->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = $optionGroup->name.' has been saved';
        	$arrReturn['data'] = $optionGroup;
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

   	public function deleteProductOptionGroup($id)
   	{
   		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$optionGroup = ProductOptionGroup::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $optionGroup->name;
   		    if( $optionGroup->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
   	}
}