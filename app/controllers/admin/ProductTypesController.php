<?php

class ProductTypesController extends AdminController {

	public static $table = 'options';
    public static $name = 'Product Types';

	public function index()
	{
		$this->layout->title = 'Product Option Types';
		$this->layout->content = View::make('admin.product-types-all');
	}

	public function listProductType()
   	{
   		if( !Request::ajax() ) {
            return App::abort(404);
        }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$productTypes = ProductType::select('id', 'name', 'description');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
                $value = ltrim(rtrim($value));
        		$productTypes->where($key,'like', '%'.$value.'%');
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$productTypes->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $productTypes->count();
        if($length > 0) {
			$productTypes = $productTypes->skip($start)->take($length);
		}
		$arrTypes = $productTypes->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => ProductType::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrTypes)){
			foreach($arrTypes as $type){
				$arrReturn['data'][] = array(
	                              ++$start,
	                              $type['id'],
	                              $type['name'],
	                              $type['description'],
	                              );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
   	}

   	public function updateProductType()
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
	   			$type = ProductType::findorFail($id);
	   			$type->$name = $value;
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
   		} else {
   			$type = new ProductType;
   			$type->name = Input::get('name');
   			$type->description = Input::get('description');
   		}
	    $pass = $type->valid();
        if($pass->passes()) {
        	$type->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = $type->name.' has been saved';
        	$arrReturn['data'] = $type;
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

   	public function deleteProductType($id)
   	{
   		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$type = ProductType::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $type->name;
   		    if( $type->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
   	}
}