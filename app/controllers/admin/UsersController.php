<?php

class UsersController extends AdminController {

	public static $table = 'users';

	public function index()
	{
		$this->layout->title = 'Users';
		$this->layout->content = View::make('admin.users-all');
	}

	public function listUser()
	{
		if( !Request::ajax() ) {
            return App::abort(404);
        }
		$admin_id = Auth::admin()->get()->id;

		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$users = User::select(DB::raw('id, first_name, last_name, email, image, active, image,
											(SELECT COUNT(*)
												FROM notifications
									         	WHERE notifications.item_id = users.id
									         		AND notifications.item_type = "User"
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
	        		$users->where($key, $value);
				} else {
	                $value = ltrim(rtrim($value));
	        		$users->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$users->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $users->count();
        if($length > 0) {
			$users = $users->skip($start)->take($length);
		}
		$arrUsers = $users->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => User::count(),'recordsFiltered' => $count, 'data' => []];
		$arrRemoveNew = [];
		if(!empty($arrUsers)){
			foreach($arrUsers as $user){
				$firstName = $user['first_name'];
				if ( $user['new'] ) {
					$firstName .= '| <span class="badge badge-danger">new</span>';
					$arrRemoveNew[] = $user['id'];
				}

				$arrReturn['data'][] = array(
	                              ++$start,
	                              $user['id'],
	                              $firstName,
	                              $user['last_name'],
	                              $user['email'],
	                              $user['image'],
	                              $user['active'],
	                              );
			}
		}
		if( !empty($arrRemoveNew) ) {
			Notification::whereIn('item_id', $arrRemoveNew)
						->where('item_type', 'User')
						->where('admin_id', $admin_id)
						->update(['read' => 1]);
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function addUser()
	{
   		$this->layout->title = 'Add User';
		$this->layout->content = View::make('admin.users-one');
	}

	public function editUser($userId)
	{
   		try {
   			$user = User::findorFail($userId);
	    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	        return App::abort(404);
	    }
   		$user = $user->toArray();
   		$this->layout->title = 'Edit User';
		$this->layout->content = View::make('admin.users-one')->with([
																	'user' 		=> $user,
																]);
	}

	public function updateUser()
    {
        if( Request::ajax() && Input::has('pk') ) {
            $arrPost = Input::all();
            if( $arrPost['name'] == 'active' ) {
            	$arrPost['value'] = (int)$arrPost['value'];
            }
            User::where('id', $arrPost['pk'])
            		->update([$arrPost['name'] => $arrPost['value']]);
            return Response::json(['status' => 'ok']);
        }

        $prevURL = Request::header('referer');
        if( !Request::isMethod('post') ) {
   			return App::abort(404);
   		}
   		if( Input::has('id') ) {
   			$create = false;
   			try {
   				$user = User::findorFail( (int)Input::get('id') );
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
   				return App::abort(404);
		    }
            $message = 'has been updated successful';

            unset( $user->password );

            if( Input::has('password') ) {
                $password = Input::get('password');
                if( Input::has('password') && Input::has('password_confirmation') ) {
                	$password = Input::get('password');
                    $user->password = Input::get('password');
                    $user->password_confirmation = Input::get('password_confirmation');
                }
            }
   		} else {
   			$create = true;
   			$user = new User;
            $message = 'has been created successful';

            $password = Input::get('password');
            $user->password = $password;
            $user->password_confirmation = Input::get('password_confirmation');
   		}

   		$user->email 		= Input::get('email');
   		$user->first_name 	= Input::get('first_name');
   		$user->last_name 	= Input::get('last_name');
   		$user->active 		= Input::has('active') ? 1 : 0;
   		if (Input::hasFile('image')) {
			$oldPath = $user->image;
			$path = VIImage::upload(Input::file('image'), public_path('assets'.DS.'images'.DS.'admins'), 110, false);
			$path = str_replace(public_path().DS, '', $path);
			$user->image = str_replace(DS, '/', $path);
			if( $oldPath == $user->image ) {
				unset($oldPath);
			}
		}

   		$pass = $user->valid();

   		if( $pass->passes() ) {
   			if( isset($user->password_confirmation) ) {
   				unset($user->password_confirmation);
   			}
   			if( isset($password) ) {
   				$user->password = Hash::make($password);
   			}

   			$user->save();

   			if( isset($oldPath) && File::exists(public_path($oldPath)) ) {
   				File::delete(  public_path($oldPath) );
			}

			if( Input::has('continue') ) {
				if( $create ) {
					$prevURL = URL.'/admin/users/edit-user/'.$user->id;
				}
            	return Redirect::to($prevURL)->with('flash_success',"<b>{$user->first_name} {$user->last_name}</b> {$message}.");
			}
            return Redirect::to(URL.'/admin/users')->with('flash_success',"<b>{$user->first_name} {$user->last_name}</b> {$message}.");
   		}

   		return Redirect::to($prevURL)->with('flash_error',$pass->messages()->all())->withInput();
    }

    public function deleteUser($id)
   	{
   		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$user = User::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $user->first_name.' '.$user->last_name;
   		    if( $user->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "<b>{$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
   	}
}