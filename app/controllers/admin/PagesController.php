<?php

class PagesController extends AdminController {

	public static $table = 'pages';

	public function index()
	{
		$this->layout->title = 'Page';
		$this->layout->content = View::make('admin.pages-all');

	}

	public function listPage()
	{
		if( !Request::ajax() ) {
            return App::abort(404);
        }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$pages = Page::select('id', 'name', 'menu_id', 'active', 'type');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'active' || $key == 'on_menu' ) {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
					if( $key == 'active' ) {
	        			$pages->where($key, $value);
					} else {
	        			$pages->where('menu_id', '>', 0);
					}
	        	} else {
	                $value = ltrim(rtrim($value));
	        		$pages->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$pages->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $pages->count();
        if($length > 0) {
			$pages = $pages->skip($start)->take($length);
		}
		$arrPages = $pages->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Page::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrPages)){
			foreach($arrPages as $page){
				$image = '';
				if( !empty($page['images']) ) {
					$image = reset($page['images']);
					$image = $image['path'];
				}
				$arrReturn['data'][] = array(
	                              ++$start,
	                              $page['id'],
	                              $page['name'],
	                              ucfirst($page['type']),
	                              $page['menu_id'] ? 1 : 0,
	                              $page['active'],
	                              );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function addPAge()
	{
		$this->layout->title = 'Add Page';
		$this->layout->content = View::make('admin.pages-one');
	}

	public function editPage($id)
	{
		try {
   			$page = Page::findorFail($id);
	    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	        return App::abort(404);
	    }
   		$page = $page->toArray();
		$this->layout->title = 'Add Page';
		$this->layout->content = View::make('admin.pages-one')->with([
																	'page' => $page
																]);
	}

	public function updatePage()
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
   				$page = Page::findorFail( (int)Input::get('id') );
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
   				return App::abort(404);
		    }
            $message = 'has been updated successful';
   		} else {
   			$create = true;
   			$page = new Page;
            $message = 'has been created successful';
   		}

   		$page->name 		= Input::get('name');
   		$page->short_name 	= Str::slug($page->name);
   		$page->content      = Input::has('content') ? e(Input::get('content')) : '';
		$page->meta_title 	 	 = e(Input::get('meta_title'));
		$page->meta_description   = e(Input::get('meta_description'));
   		$page->active 		= Input::has('active') ? 1 : 0;
   		$pass = $page->valid();

   		if( $pass->passes() ) {
   			$action = Input::has('on_menu') ? 'add' : 'delete';
   			$page = Menu::updateMenu($page, $action);

   			$page->save();

			if( Input::has('continue') ) {
				if( $create ) {
					$prevURL = URL.'/admin/pages/edit-page/'.$page->id;
				}
            	return Redirect::to($prevURL)->with('flash_success',"<b>{$page->name}</b> {$message}.");
			}
            return Redirect::to(URL.'/admin/pages')->with('flash_success',"<b>{$page->name}</b> {$message}.");
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
   			$page = Page::findorFail($id);
   			if( $name == 'active' ) {
   				$page->active = (int)$value;
   				$page = Menu::updateMenu($page, 'add');
   			} else if( $name == 'on_menu' ) {
   				$type = $value ? 'add' : 'delete';
   				$page = Menu::updateMenu($page, $type);
   			} else {
   				$page->$name = $value;
   			}
	    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	        return App::abort(404);
	    }
	    $pass = $page->valid();
        if($pass->passes()) {
        	$page->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = $page->name.' has been saved';
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

	public function deletePage($id)
	{
		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$page = Page::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $page->name;
   		    if( $page->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
	}

	public function contentBuilder($id = 0)
	{
		return View::make('admin.layout.content-builder')->with([
														'content' => Page::where('id', $id)->pluck('content')
													]);
	}

}