<?php

class ProductOptionsController extends AdminController {

	public static $table = 'options';
    public static $name = 'Product Options';

	public function index()
	{
		$this->layout->title = 'Product Options';
		$this->layout->content = View::make('admin.product-options-all')->with(['option_group' => ProductOptionGroup::getSource(true)]);
	}

	public function listProductOption()
   	{
   		if( !Request::ajax() ) {
            return App::abort(404);
        }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$productOptions = ProductOption::select('options.id', 'options.name', 'options.key', 'option_group_id', 'option_groups.name as option_group_name')
												->leftJoin('option_groups', 'options.option_group_id', '=', 'option_groups.id');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'option_group_id' ) {
	        		$productOptions->where($key, (int)$value);
				} else {
	                $value = ltrim(rtrim($value));
	        		$productOptions->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$productOptions->orderBy('options.'.$columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $productOptions->count();
        if($length > 0) {
			$productOptions = $productOptions->skip($start)->take($length);
		}
		$arrOptions = $productOptions->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => ProductOption::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrOptions)){
			foreach($arrOptions as $option){
				$arrReturn['data'][] = array(
	                              ++$start,
	                              $option['id'],
	                              $option['name'],
	                              $option['key'],
	                              $option['option_group_id'],
	                              is_null($option['option_group_name']) ? '' : $option['option_group_name'],
	                              );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
   	}

   	public function updateProductOption()
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
	   			$option = ProductOption::findorFail($id);
	   			$option->$name = $value;
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
   		} else {
   			$option = new ProductOption;
   			$option->name = Input::get('name');
   			$option->key = Input::get('key');
   			$option->option_group_id = Input::has('option_group_id') ? (int)Input::get('option_group_id') : 0;
   		}
	    $pass = $option->valid();
        if($pass->passes()) {
        	$option->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = $option->name.' has been saved';
        	$arrReturn['data'] = $option;
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

   	public function deleteProductOption($id)
   	{
   		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$optionGroup = ProductOption::findorFail($id);
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