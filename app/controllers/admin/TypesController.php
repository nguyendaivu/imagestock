<?php

class TypesController extends AdminController {

	public static $table = 'types';

	public function index()
	{
		$this->layout->title = 'Types';
		$this->layout->content = View::make('admin.types-all')->with([
													'types'=> Type::getSource(),
												]);
	}

	public function listType()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$types = Type::select('types.id','types.image', 'types.name','types.description', 'types.order_no','parent.name as parent_name', 'types.active');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'active' ) {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
					$types->where('types.'.$key, $value);
				} else {
					if($key == 'parent_id') {
						$types->where('types.'.$key, (int)$value);
					} else {
						$value = ltrim(rtrim($value));
						$types->where('types.'.$key,'like', '%'.$value.'%');
					}
				}
			}
		}
		$count = $types->count();
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$types->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
		if($length > 0) {
			$types = $types->skip($start)->take($length);
		}
		$arrtypes = $types->leftJoin('types as parent', 'types.parent_id', '=', 'parent.id')->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Type::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrtypes)){
			foreach($arrtypes as $type){
				$type['parent_name'] = is_null($type['parent_name']) ? 'No Parent' : $type['parent_name'];
				$arrReturn['data'][] = [
									++$start,
									$type['id'],
									$type['name'],
									$type['description'],
									$type['image'],
									$type['order_no'],
									$type['parent_name'],
									$type['active'],
								];
			}
		}
		return $arrReturn;
	}

	public function updateType()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		if( Input::has('pk') ) {
			return self::updateQuickEdit();
		}

		$arrReturn = ['status' => 'error'];

		$type = new type;

		$type->name = Input::get('name');
		$type->short_name 	= Str::slug($type->name);
		$type->description = Input::get('description');
		$type->parent_id = (int)Input::get('parent_id');
		$type->order_no = (int)Input::get('order_no');
		$type->active = Input::has('active') ? 1 : 0;
		$oldImg = $type->image;
		if (Input::hasFile('image')) {
			$file = Input::file('image');
			$path = VIImage::upload(Input::file('image'), public_path('assets'.DS.'images'.DS.'types'), 1360, false);
			$path = str_replace(public_path().DS, '', $path);
			$path = str_replace(DS, '/', $path);
			if( $path) {
				$type->image =  $path;
			}
		}

		$pass = $type->valid();

		if( $pass ) {
			$type->save();
			if( !empty($oldImg) && File::exists(public_path($oldImg)) ) {
				File::delete(public_path($oldImg));
			}
			$arrReturn = ['status' => 'ok'];
			$arrReturn['message'] = $type->name.'\'s image has been saved';
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

	public function updateQuickEdit()
	{
		$arrReturn = ['status' => 'error'];
		$id = (int)Input::get('pk');
		$name = Input::get('name');
		$value = Input::get('value');
		try {
			$type = Type::findorFail($id);
			if( $name == 'image' ) {
				if (Input::hasFile('image')) {
					$file = Input::file('image');
					$path = VIImage::upload(Input::file('image'), public_path('assets'.DS.'images'.DS.'types'), 1360, false);
					$path = str_replace(public_path().DS, '', $path);
					$path = str_replace(DS, '/', $path);
					if( $path) {
						$oldImg = $type->image;
						$type->image =  $path;
					}
				}
			} else {
				$value = Input::get('value');
				if( $name == 'active' ) {
					$type->active = (int)$value;
				} else {
					$type->$name = $value;
				}
			}
		} catch (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return App::abort(404);
		}
		$pass = $type->valid();
		if($pass->passes()) {
			$type->save();
			if( isset($oldImg) && File::exists(public_path($oldImg)) ) {
				File::delete(public_path($oldImg));
			}
			$arrReturn = ['status' => 'ok'];
			$arrReturn['message'] = $type->name.' has been saved';
			$arrReturn['image'] = $type->image;
		} else {
			$arrReturn['message'] = '';
			$arrErr = $pass->messages()->all();
			foreach($arrErr as $value)
				$arrReturn['message'] .= "$value\n";
		}
		return $arrReturn;
	}


	public function deleteType($id)
	{
		if( Request::ajax() ) {
			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
			try {
				$type = Type::findorFail($id);
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$name = $type->name;
			if( $type->delete() )
				$arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
			return $arrReturn;
		}
		return App::abort(404);
	}
}