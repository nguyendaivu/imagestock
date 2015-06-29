<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

	public static function checkOwner($controller, $id)
	{
	    if( !class_exists($controller) ) {
	        return false;
	    }
	    $class = new $controller;
	    if( !isset($class::$table) ) {
	        return false;
	    }
	    return DB::table($class::$table)
	        ->selectRaw('count(id) as record')
	        ->where('id', $id)
	        ->where('created_by', Auth::admin()->id)
	        ->pluck('record');
	}

	public static function checkPermission($controller, $method, $params)
	{
	    $add    = false;
	    $update = false;
	    $delete = false;
	    $admin = Auth::admin()->get();

	    $controller =  strtolower(str_replace(['Controller','\\'], '', $controller));
	    if( !$admin->can('admin_view_all') )
	        return false;
	    if( $method == 'index'
	        || strpos($method, 'view') !== false ){

	        if( !$admin->can("{$controller}_view_all") )
	            return false;

	    } else if( strpos($method, 'update') !== false ) {

	        if( Input::has('id') ){
	            $update = true;
	        } else {
	            $add = true;
	        }

	    } else if( strpos($method, 'create') !== false
	        || strpos($method, 'add') !== false  ) {

	        $add = true;

	    } else if( strpos($method, 'edit') !== false
	    	|| strpos($method, 'reorder') !== false ) {

	        $update = true;

	    } else if( strpos($method, 'delete') !== false
	        || strpos($method, 'remove') !== false  ) {

	        $delete = true;

	    }

	    if( $add ) {
	        if( !$admin->can("{$controller}_create_owner") )
	            return false;
	    } else if( $update ) {
	        $all = $admin->can("{$controller}_edit_all");
	        $owner = $admin->can("{$controller}_edit_owner");
	        if( !$all ) {
	            if ( $owner && !self::checkOwner($controller, $params[0]) ) {
	                return false;
	            }else if( !$owner ) {
	                return false;
	            }
	        }
	    } else if ( $delete ) {
	        $all = $admin->can("{$controller}_delete_all");
	        $owner = $admin->can("{$controller}_delete_owner");
	        if( !$all ) {
	            if ( $owner && !self::checkOwner($controller, $params[0]) ) {
	                return false;
	            }else if( !$owner ) {
	                return false;
	            }
	        }
	    }
	    return true;
	}

	public static function generatePermission()
	{
		$arrController = Admin::getController();
		foreach($arrController as $controller) {
			$controller = str_replace(' ', '', $controller);
			foreach(['view','create', 'edit', 'delete'] as $action) {
				if($controller == 'admin' && $action != 'view') continue;
				foreach(['all', 'owner'] as $type) {
					if( $controller == 'admin' && $type != 'all' ) continue;
					if( $action == 'create' && $type != 'owner' ) continue;
					$permission = self::where('name', "{$controller}_{$action}_{$type}")->pluck('id');
					if( is_null($permission) ) {
						$permission = new Permission;
						$permission->name = "{$controller}_{$action}_{$type}";
						$permission->display_name = ucfirst($action).' '.ucfirst($type).' '.ucfirst($controller);
						$permission->save();
					}
				}
			}
		}
		foreach(['menusfrontend', 'menusbackend'] as $extraPermission) {
			foreach(['view', 'create', 'edit', 'delete'] as $action) {
				$permission = self::where('name', "{$extraPermission}_{$action}_all")->pluck('id');
				if( is_null($permission) ) {
					$permission = new Permission;
					$permission->name = "{$extraPermission}_{$action}_all";
					$permission->display_name = ucfirst($action).' All '.ucfirst($extraPermission);
					$permission->save();
				}
			}
		}
		return true;
	}

	public static function can($admin, $permission)
	{
		return $admin->can($permission);
	}
}