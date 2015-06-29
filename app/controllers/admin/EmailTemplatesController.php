<?php

class EmailTemplatesController extends AdminController {

	public $table = 'email_templates';

	public function index()
	{
		$this->layout->title = 'Email Template';
		$this->layout->content = View::make('admin.email-templates-all')->with([
																				'email' => VIEmail::getConfig()
																			]);
	}

	public function listTemplate()
	{
		if( !Request::ajax() ) {
			return App::abort(404);
		}
		$start = Input::has('start') ? (int)Input::get('start') : 0;
		$length = Input::has('length') ? Input::get('length') : 10;
		$search = Input::has('search') ? Input::get('search') : [];
		$emailTemplates = EmailTemplate::select('id', 'name', 'type', 'active');
		if(!empty($search)){
			foreach($search as $key => $value){
				if(empty($value)) continue;
				if( $key == 'active' ) {
					if( $value == 'yes' ) {
						$value = 1;
					} else {
						$value = 0;
					}
					$emailTemplates->where($key, $value);
				} else {
					$value = ltrim(rtrim($value));
					$emailTemplates->where($key,'like', '%'.$value.'%');
				}
			}
		}
		$order = Input::has('order') ? Input::get('order') : [];
		if(!empty($order)){
			$columns = Input::has('columns') ? Input::get('columns') : [];
			foreach($order as $value){
				$column = $value['column'];
				if( !isset($columns[$column]['name']) || empty($columns[$column]['name']) )continue;
				$emailTemplates->orderBy($columns[$column]['name'], ($value['dir'] == 'asc' ? 'asc' : 'desc'));
			}
		}
		$count = $emailTemplates->count();
		if($length > 0) {
			$emailTemplates = $emailTemplates->skip($start)->take($length);
		}
		$arrTemplates = $emailTemplates->get()->toArray();
		$arrReturn = ['draw' => Input::has('draw') ? Input::get('draw') : 1, 'recordsTotal' => EmailTemplate::count(),'recordsFiltered' => $count, 'data' => []];
		if(!empty($arrTemplates)){
			foreach($arrTemplates as $template){
				$arrReturn['data'][] = array(
								  ++$start,
								  $template['id'],
								  $template['name'],
								  $template['type'],
								  $template['active'],
								  );
			}
		}
		$response = Response::json($arrReturn);
		$response->header('Content-Type', 'application/json');
		return $response;
	}

	public function addTemplate()
	{
		$this->layout->title = 'Add Template';
		$this->layout->content = View::make('admin.email-templates-one');
	}

	public function editTemplate($id)
	{
		try {
			$template = EmailTemplate::findorFail($id);
		} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
			return App::abort(404);
		}
		$template = $template->toArray();
		$this->layout->title = 'Edit Template';
		$this->layout->content = View::make('admin.email-templates-one')->with([
																				'template' => $template
																			]);
	}

	public function updateTemplate()
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
				$template = EmailTemplate::findorFail( (int)Input::get('id') );
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$message = 'has been updated successful';
		} else {
			$create = true;
			$template = new EmailTemplate;
			$message = 'has been created successful';
		}

		$template->name = Input::has('name') ? Input::get('name') : '';
		$template->type = Input::has('type') ? Input::get('type') : '';
		$template->active = (int)Input::has('active');
		$template->content = Input::has('content') ? Input::get('content') : '';

		$pass = $template->valid();

		if( $pass ) {
			$template->save();

			if( Input::has('continue') ) {
				if( $create ) {
					$prevURL = URL.'/admin/email-templates/edit-template/'.$template->id;
				}
				return Redirect::to($prevURL)->with('flash_success',"<b>$template->name</b> {$message}.");
			}
			return Redirect::to(URL.'/admin/email-templates')->with('flash_success',"<b>$template->name</b> {$message}.");
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
   			$template = EmailTemplate::findorFail($id);
   			$template->$name = $value;
	    } catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
	        return App::abort(404);
	    }
	    $pass = $template->valid();
        if($pass->passes()) {
        	$template->save();
   			$arrReturn = ['status' => 'ok'];
        	$arrReturn['message'] = '<b>'.$template->name.'</b> has been saved';
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

	public function updateEmail()
	{
		if( !Request::isMethod('post') ) {
			return App::abort(404);
		}

		$arrPost = Input::all();
		unset($arrPost['_token']);
		foreach($arrPost as $key => $value) {
			$key = 'email_'.$key;
			$configure = Configure::firstOrNew(['ckey'=> $key]);
			$configure->ckey = $key;
			$configure->cname = Str::title(str_replace('email_', ' ', $key));
			$configure->cvalue = $value;
			$configure->save();
		}

		return Redirect::to(URL.'/admin/email-templates')->with('flash_success', 'Email Configure has been saved.');
	}

	public function deleteTemplate($id)
	{
		if( Request::ajax() ) {
			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];
			try {
				$template = EmailTemplate::findorFail($id);
			} catch(Illuminate\Database\Eloquent\ModelNotFoundException $e) {
				return App::abort(404);
			}
			$name = $template->name;
			if( $template->delete() )
				$arrReturn = ['status' => 'ok', 'message' => "Template <b>{$name}</b> has been deleted."];
			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return App::abort(404);
	}
}