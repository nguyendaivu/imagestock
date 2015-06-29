<?php
class RolesController extends AdminController{

    public static $table = 'roles';

	public function index()
	{
		$this->layout->title 	= 'Roles';
		$this->layout->content 	= View::make('admin.roles-all');
	}

	public function listRole()
    {
    	if( !Request::ajax() ) {
            return App::abort(404);
        }
        $start = Input::has('start') ? (int)Input::get('start') : 0;
        $length = Input::has('length') ? Input::get('length') : 10;
        $search = Input::has('search') ? Input::get('search') : [];
        $roles = Role::select('id', 'name');
        if(!empty($search)){
            foreach($search as $key => $value){
                if(empty($value)) continue;
                $value = ltrim(rtrim($value));
                $roles->where($key,'like', '%'.$value.'%');
            }
        }
        $order = Input::has('order') ? Input::get('order') : [];
        if(!empty($order)){
            $columns = Input::has('columns') ? Input::get('columns') : [];
            foreach($order as $value){
                $column = $value['column'];
                if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
                $roles->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
            }
        }
        $count = $roles->count();
        if($length > 0) {
            $roles = $roles->skip($start)->take($length);
        }
        $arrRoles = $roles->get()->toArray();
        $arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Role::count(),'recordsFiltered' => $count, 'data' => []];
        if(!empty($arrRoles)){
            foreach($arrRoles as $role){
                $arrReturn['data'][] = array(
                                  ++$start,
                                  $role['id'],
                                  $role['name'],
                                  );
            }
        }
        $response = Response::json($arrReturn);
        $response->header('Content-Type', 'application/json');
        return $response;
    }

	public function addRole()
	{
		$this->layout->title 	= 'Add Role';
		$this->layout->content 	= View::make('admin.roles-one')->with(['arrController' => Admin::getController()]);
	}

	public function editRole($id)
	{
        try {
            $role = Role::findorFail($id);
        } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return App::abort(404);
        }
		$arrAssignedPermission = DB::table('permission_role')
			->select('permissions.name')
			->leftJoin('permissions', 'permission_role.permission_id', '=', 'permissions.id')
			->where('role_id', $id)
			->get();
		$arrPermission = [];
		if( !is_null($arrAssignedPermission) ){
			foreach($arrAssignedPermission as $permission) {
				$arrPermission[$permission->name] = 1;
			}
		}
		$this->layout->title 	= 'Edit Role';
		$this->layout->content 	= View::make('admin.roles-one')->with([
                                                                        'role' => $role,
                                                                        'arrController' => Admin::getController(),
                                                                        'arrPermission' => $arrPermission
                                                                    ]);
	}

	public function updateRole()
	{
        $prevURL = Request::header('referer');
        if( !Request::isMethod('post') ) {
            return App::abort(404);
        }
        if( Input::has('id') ){
            try {
                $role = Role::findorFail( (int)Input::get('id') );
            } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return App::abort(404);
            }
            $create = false;
        	$message = 'has been updated successful';
        } else {
            $create = true;
        	$role = new Role;
        	$message = 'has been added successful';
        }
        $role->name = Input::has('name') ? Input::get('name') : '';
        $pass = $role->valid();
        if( $pass->passes() ){
            Permission::generatePermission();
         	$role->save();
        	if( Input::has('permission') ) {
        		$arrAssignedPermission = [];
        		$arrPermission = Input::get('permission');
        		foreach($arrPermission as $controller => $permission) {
        			foreach($permission as $action => $type){
        				$currentPerrmission = Permission::select('id')
                                                            ->where('name', 'like', "%{$controller}_{$action}_%")
    														->where('name', '<>', "{$controller}_{$action}_{$type}")
    														->get();
    					if( !$currentPerrmission->isEmpty() ){
    						$arrId = [];
    						foreach($currentPerrmission as $id){
    							$arrId[] = $id->id;
    						}
    						DB::table('permission_role')
    							->where('role_id', $role->id)
    							->whereIn('permission_id', $arrId)
    							->delete();
    						unset($currentPerrmission, $arrId);
    					}
        				if($type != 'none'){
        					$permission_id = Permission::where('name', "{$controller}_{$action}_$type")->pluck('id');
        					if( is_null($permission_id) ) continue;
        					$arrAssignedPermission[] = $permission_id;
        				}
        			}
        		}
        		if( !empty($arrAssignedPermission) ) {
                    $role->perms()->sync($arrAssignedPermission);
                }
                Cache::tags('menu', 'frontend')->flush();
                Cache::tags('menu', 'backend')->flush();
        	}
            if( Input::has('continue') ) {
                if( $create ) {
                    $prevURL = URL.'/admin/roles/edit-role/'.$role->id;
                }
                return Redirect::to($prevURL)->with('flash_success',"<b>{$role->name}</b> {$message}.");
            }
        	return Redirect::to(URL.'/admin/roles')->with(['flash_success' => "{$role->name} {$message}."]);
        }
        return Redirect::to($prevURL)->with(['flash_error' => $pass->messages()->all()])->withInput();
	}

	public function deleteRole($id)
    {
        if( Request::ajax() ) {
            $arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
            try {
                $role = Role::findorFail($id);
            } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return App::abort(404);
            }
            $name = $role->name;
            if( $role->delete() )
                $arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
            $response = Response::json($arrReturn);
            $response->header('Content-Type', 'application/json');
            return $response;
        }
        return App::abort(404);
    }

    public function generatePermissions()
    {
        Permission::generatePermission();
        return 'done';
    }
}