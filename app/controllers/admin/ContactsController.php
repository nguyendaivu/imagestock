<?php

class ContactsController extends AdminController {

	public static $table = 'contacts';

	public function index()
	{
		$this->layout->title = 'User feedback';
		$this->layout->content = View::make('admin.contacts-all');

	}

	public function listContact()
	{
		if( !Request::ajax() ) {
		            return App::abort(404);
		        }
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$contacts = Contact::select('id', 'contact_name', 'contact_phone',  'contact_email', 'contact_message', 'read', 'created_at')->orderBy('read')->orderBy('created_at');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'read') {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
	        				$contacts->where($key, $value);
	        	} else {
	                $value = ltrim(rtrim($value));
	        		$contacts->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$contacts->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
        $count = $contacts->count();
        if($length > 0) {
			$contacts = $contacts->skip($start)->take($length);
		}
		$arrcontacts = $contacts->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => Page::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrcontacts)){
			foreach($arrcontacts as $contact){
				$image = '';
				if( !empty($contact['images']) ) {
					$image = reset($contact['images']);
					$image = $image['path'];
				}
				$arrReturn['data'][] = array(
	                              ++$start,
	                              $contact['id'],
	                              $contact['contact_name'],
	                              $contact['contact_phone'],
	                              $contact['contact_email'],
	                              htmlentities($contact['contact_message']),
	                              $contact['read'],
	                              $contact['created_at'],
	                              htmlentities(nl2br($contact['contact_message']))
	                              );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}




	public function updateContact()
	{
		if( Input::has('pk') ) {
   			if( !Request::ajax() ) {
	   			return App::abort(404);
	   		}
	   		return self::updateQuickEdit();
		}
	}

	public function updateQuickEdit()
	{
   		$arrReturn = ['status' => 'error'];
   		$id = (int)Input::get('pk');
   		$name = (string)Input::get('name');
   		$value = Input::get('value');
   		try {
   			$layout = Contact::findorFail($id);
   			$layout->$name = $value;
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $pass = $layout->valid();
	        if($pass->passes()) {
	        	$layout->save();
	   			$arrReturn = ['status' => 'ok'];
	        	$arrReturn['message'] = $layout->name.'Update has been saved';
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

	public function deleteContact($id)
	{
		if( Request::ajax() ) {
   			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
   			try {
	   			$contact = Contact::findorFail($id);
		    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
		        return App::abort(404);
		    }
		    $name = $contact->contact_name;
   		    if( $contact->delete() )
   		        $arrReturn = ['status' => 'ok', 'message' => "<b>Contact of {$name}</b> has been deleted."];
   		    $response = Response::json($arrReturn);
   		    $response->header('Content-Type', 'application/json');
   		    return $response;
   		}
   		return App::abort(404);
	}

}