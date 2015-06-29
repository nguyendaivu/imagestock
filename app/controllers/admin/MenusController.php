<?php

class MenusController extends AdminController {

    public static $table = 'menus';

	public function index()
	{
		$arrType = [];
		$arrMenu = Menu::getCache(['active' => 0]);
		if( !empty($arrMenu) ) {
			foreach($arrMenu as $type => $html) {
				if( strpos($type, '-') !== false ) {
					unset($arrMenu[$type]);
					list($type, $subType) = explode('-', $type);
					$arrMenu[$type][$subType] = '<ol class="dd-list">'.$html.'</ol>';
					$arrType[] = $subType;
				} else {
					$arrMenu[$type] = '<ol class="dd-list">'.$html.'</ol>';
					$arrType[] = $type;
				}
			}
			arsort($arrMenu);
		} else {
			$arrMenu = [];
		}
		$arrParent = Menu::getCache(['parent' => true]);

	    $admin = Auth::admin()->get();
	    $permission = new Permission;
		$arrPermission = [
							'frontend' => [
								'view' => $permission->can($admin, 'menusfrontend_view_all'),
								'create' => $permission->can($admin, 'menusfrontend_create_all'),
								'edit' => $permission->can($admin, 'menusfrontend_edit_all'),
								'delete' => $permission->can($admin, 'menusfrontend_delete_all'),
							],
							'backend' => [
								'view' => $permission->can($admin, 'menusbackend_view_all'),
								'create' => $permission->can($admin, 'menusbackend_create_all'),
								'edit' => $permission->can($admin, 'menusbackend_edit_all'),
								'delete' => $permission->can($admin, 'menusbackend_delete_all'),
							]
						];

		$this->layout->title = 'Menu';
        $this->layout->content = View::make('admin.menus-all')->with([
        																'arrMenu' 		=> $arrMenu,
        																'arrParent' 	=> $arrParent,
        																'arrType' 		=> $arrType,
        																'arrPermission' => $arrPermission
        															]);
	}

	public function menuReorder()
	{
		$ajax = Request::ajax();
		$arrPost = Input::all();
		unset($arrPost['_token']);
		$updated = false;
		if(!empty($arrPost)){
			$frontend = Permission::can($this->layout->admin, 'menusfrontend_edit_all');
			$backend = Permission::can($this->layout->admin, 'menusbackend_edit_all');
			foreach($arrPost as $type => $menu){
				if(empty($menu)) continue;
				if( $type == 'backend' && !$backend ){
					continue;
				} else if( in_array($type, ['header', 'footer']) && !$frontend ) {
					continue;
				}
				$menu = json_decode($menu);
				foreach($menu as $key => $value) {
					$i = 1;
					Menu::where('id', $value->id)
							->update([
									'parent_id' => 	0,
									'order_no' 	=>	($key+1),
									'level' 	=>	$i,
								]);
					if( isset($value->children) ){
						Menu::updateRecursiveChildOrder($value->children, $value->id, $i+1);
					}
				}
				$updated = true;
			}

			if( $updated ) {
				Menu::clearCache();
			}


			if ( $ajax ) {
				if( $updated ) {
					$sidebar = Menu::get(["sidebar"=>true]);
					$arrParent = Menu::getCache(['parent' => true]);
					$arrReturn = ['status'=> 'ok', 'sidebar'=> $sidebar, 'parent'=> $arrParent];
				} else {
					$arrReturn = ['status' => 'warning', 'message' => 'Nothing was changed.'];
				}
				$response = Response::json($arrReturn);
				$response->header('Content-Type', 'application/json');
				return $response;
			}
			return Redirect::to(URL.'/admin/menus')->with(['flash_success'=> $updated ? 'Menu has been re-ordered.' : 'Nothing was change.']);
		}
		if ( $ajax ) {
			$response = Response::json(['status'=> 'error', 'message' => 'We found nothing to re-order. Please check again.']);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::to(URL.'/admin/menus');
	}

	public function updateMenu()
	{
		if( Request::isMethod('get') ) {
        	return Redirect::to(URL.'/admin/menus');
		}
		$ajax = Request::ajax();
		$arrPost = Input::all();
		if(!empty($arrPost)){
			$permission = true;
			if(  $arrPost['id'] ) {
            	$message = 'has been updated successful!';
				$menu = Menu::find($arrPost['id']);
			} else {
            	$message = 'has been added successful!';
				$menu = new Menu;
			}
			$menu->name 		= $arrPost['name'];
			$menu->icon_class 	= isset($arrPost['icon_class']) ? trim($arrPost['icon_class']) : '';
			if( empty($menu->icon_class) )
				$menu->icon_class = 'icon-settings';
			$menu->link 		= rtrim(ltrim(str_replace(URL.'/', '', $arrPost['link']), '/'), '/');
			$menu->type 		= $arrPost['type'];
			$menu->group 		= isset($arrPost['group']) ? $arrPost['group'] : '';
			if( $menu->type == 'backend' ) {
				$menu->group = '';
			}
			$menu->parent_id 	= !$arrPost['parent_id'] ? 0 : $arrPost['parent_id'];
			$menu->order_no 	= (int)$arrPost['order_no'];
			$menu->active 		= isset($arrPost['active']) && (int)$arrPost['active'] ? 1 : 0;
			$menu->level 		= 1;
			if( $menu->parent_id ) {
				$level = Menu::select('level')
								->where('id', $menu->parent_id)
								->pluck('level');
				$menu->level = ++$level;
			}
			if(  $arrPost['id'] ) {
				$permission = Permission::can($this->layout->admin, "menus{$menu->type}_edit_all");
				$errorMessage = 'You do not have permission to edit menu';
			} else {
				$permission = Permission::can($this->layout->admin, "menus{$menu->type}_create_all");
				$errorMessage = 'You do not have permission to create menu';
			}
			if( $permission ) {
				$pass = $menu->valid();
	        	if($pass->passes()){
	        		$menu->save();

	        		Menu::updateRecursive($menu->id, ['type' => $menu->type, 'group' => $menu->group]);

	            	$message = "<b>$menu->name</b> ".$message;

	            	if( $ajax ) {
	            		$arrReturn = [];

		            	$arrReturn['message'] = $message;
		            	$arrReturn['status'] = 'ok';

		            	$arrMenu = Menu::getCache(['active' => 0]);
				        $arrReturn['menu']  = $arrMenu;

				        $sidebar = Menu::getCache(['sidebar' => true]);
				        $arrReturn['sidebar']  = $sidebar;

						$arrParent = Menu::getCache(['parent' => true]);
				        $arrReturn['parent']  = $arrParent;

				        $response = Response::json($arrReturn);
						$response->header('Content-Type', 'application/json');
						return $response;
	            	}

					return Redirect::to(URL.'/admin/menus')->with(['flash_success'=> $message]);
	        	}
	        	if( $ajax ) {
		       		$response = Response::json(['status' => 'error', 'message' => implode('<br />', $pass->messages()->all() )]);
					$response->header('Content-Type', 'application/json');
					return $response;
		       	}
	        	return Redirect::to(URL.'/admin/menus')->with('flash_error',$pass->messages()->all())->withInput();
			}
	       	if( $ajax ) {
	       		$response = Response::json(['status' => 'error', 'message' => $errorMessage]);
				$response->header('Content-Type', 'application/json');
				return $response;
	       	}
		}
		if( $ajax ) {
	        $response = Response::json(['status' => 'error', 'message' => 'There is something wrong. Please refresh and try again.']);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::to(URL.'/admin/menus');
	}

	public function deleteMenu($id)
	{
		$arrReturn = ['status' => 'error', 'message' => 'There is something wrong. Please refresh and try again.'];
		$menu = Menu::find($id);
		if(!is_null($menu)){
			$name = $menu->name;
			$type = $menu->type;
			if( Permission::can($this->layout->admin, "menus{$type}_delete_all") ) {
				self::deleteRecursiveMenu($menu->id, $menu);
				$arrReturn['status']  = 'success';
				$arrReturn['message'] = "<b>$name</b> menu has been deleted.";
				if( $menu->destroy($menu->id) ) {
					if( $type == 'backend' ) {
						$sidebar = Menu::getCache(['sidebar' => true]);
						$arrReturn['sidebar']  = $sidebar;
					}
				}
			} else {
				$arrReturn['message'] = 'You do not have permission to delete menu.';
			}
		}
        $response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	private static function deleteRecursiveMenu($id, Menu $menu)
	{
		$arrMenu = Menu::select('id')
					->where('parent_id', $id)
					->get();
		if( !is_null($arrMenu) ) {
			foreach($arrMenu as $menu) {
				self::deleteRecursiveMenu($menu->id, $menu);
				$menu::destroy($menu->id);
			}
		}
		return true;
	}
}