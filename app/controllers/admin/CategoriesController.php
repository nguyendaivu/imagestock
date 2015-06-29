<?php

class CategoriesController extends AdminController {

	public static $table = 'categories';

	public function index()
	{
		$this->layout->title = 'Categories';
		$categories = Category::select('id','name')->get();
		$this->layout->content = View::make('admin.categories-all')->with([
													'categories'=>$categories,
												]);
	}

	public function listCategory()
	{
		if( !Request::ajax() ) {
				return App::abort(404);
			 }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$categories = Category::select('categories.id', 'categories.name','categories.description', 'categories.order_no','parent.name as parent_name', 'categories.active');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'active' ) {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
					$categories->where('categories.'.$key, $value);
				} else {
					if($key=='parent_id'){
						$categories->where('categories.'.$key,'=', (int)$value);
					} else {
						$value = ltrim(rtrim($value));
						$categories->where('categories.'.$key,'like', '%'.$value.'%');
					}
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$categories->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
		$count = $categories->count();
		if($length > 0) {
			$categories = $categories->skip($start)->take($length);
		}
		$arrcategories = $categories->leftJoin('categories as parent', 'categories.parent_id', '=', 'parent.id')->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Category::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrcategories)){
			foreach($arrcategories as $category){
					$category['parent_name'] = is_null($category['parent_name']) ? 'No Parent' : $category['parent_name'];
					$arrReturn['data'][] = [
											++$start,
											$category['id'],
											$category['name'],
											$category['description'],
											$category['order_no'],
											$category['parent_name'],
											$category['active'],
										];
			}
		}
		return $arrReturn;
	}

	public function updateCategory()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		if( Input::has('pk') ) {
			return self::updateQuickEdit();
		}

		$arrReturn = ['status' => 'error'];

		$category = new Category;
		$category->name = Input::get('name');
		$category->short_name 	= Str::slug($category->name);
		$category->description = Input::get('description');
		$category->parent_id = (int)Input::get('parent_id');
		$category->order_no = (int)Input::get('order_no');
		$category->active = Input::has('active') ? 1 : 0;

		$pass = $category->valid();

		if( $pass ) {
			$category->save();
			$arrReturn = ['status' => 'ok'];
			$arrReturn['message'] = $category->name.' has been saved';
			$arrReturn['data'] = $category;
		} else {
			$arrReturn['message'] = '';
			$arrErr = $pass->messages()->all();
			foreach($arrErr as $value)
				$arrReturn['message'] .= "$value\n";
		}
		return $arrReturn;
	}

	public function updateQuickEdit()
	{
		$arrReturn = ['status' => 'error'];
		$id = (int)Input::get('pk');
		$name = Input::get('name');
		$value = Input::get('value');
		try {
			$category = Category::findorFail($id);
			$category->$name = $value;
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			  return App::abort(404);
		}
		$pass = $category->valid();
		if($pass->passes()) {
			$category->save();
			$arrReturn = ['status' => 'ok'];
			$arrReturn['message'] = $category->name.' has been saved';
		} else {
			$arrReturn['message'] = '';
			$arrErr = $pass->messages()->all();
			foreach($arrErr as $value)
				$arrReturn['message'] .= "$value\n";
		}
		return $arrReturn;
	}


	public function deleteCategory($id)
	{
		if( Request::ajax() ) {
			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
			try {
				$category = Category::findorFail($id);
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$name = $category->name;
			if( $category->delete() ) {
				$arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
			}
			return $arrReturn;
		}
		return App::abort(404);
	}
}