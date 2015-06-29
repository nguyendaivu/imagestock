<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

//Use App::error() instead
/*App::missing(function($exception)
{
	if( php_sapi_name() !== 'cli'
			&& !Config::get('app.debug') ) {
		if( strpos(Request::path(), 'admin/') !== false )
	        return AdminController::errors();
	    return HomeController::errors();
	}
});*/

App::error(function($exception){
	if( php_sapi_name() !== 'cli'
			&& !Config::get('app.debug') ) {
		$class = get_class($exception);
		Log::error($exception);
		$isAdmin = false;
		if( strpos(Request::path(), 'admin/') !== false ) {
			$isAdmin = true;
		}
		$code = 500;
		$title = $message = '';
		if( strpos($class, 'Symfony\\Component\\HttpKernel') !== false ) {
			$code = $exception->getStatusCode();
			$title = $message = $exception->getMessage();
		}else if( Config::get('app.debug') ) {
			$title = $exception->getFile().' LINE:'.$exception->getLine();
			$message = $exception->getMessage();
		}
		if( $isAdmin ) {
		    return AdminController::errors($code, $title, $message);
		}
		return HomeController::errors($code, $title, $message);
	}
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('login');
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});


Route::filter('auth.admin', function()
{
	if (Auth::admin()->guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('/admin/login');
	}
});


Route::filter('auth.user', function()
{
	if (Auth::user()->guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		return Redirect::guest('/user/login');
	}
});
/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

Route::filter('guest.admin', function()
{
	if (Auth::admin()->check()) return Redirect::to('/admin');
});

Route::filter('guest.user', function()
{
	if (Auth::user()->check()) return Redirect::to('/user/addresses');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	$token = Request::ajax() ? Request::header('X-CSRF-Token') : Input::get('_token');
	if ( (Request::ajax() || Request::isMethod('post')) && Session::token() !== $token)
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('lock', function()
{
	$routeName = Route::currentRouteName();
	$lock = false;
	if( Session::has('lock') && $routeName != 'logout' ) {
		$lock = true;
	}
	if( Request::ajax() && $routeName == 'lock' ) {
		$lock = false;
	}
	if( $lock ) {
		return View::make('admin.lockscreen')->with([
		                            'admin' => Auth::admin()->get()
		    ]);
	}
});

Event::listen('auth.login', function($admin)
{
	// if( $admin instanceof Admin ) {

	// 	$admin->previous_login = $admin->last_login;
	// 	$admin->last_login = new DateTime;
	// 	$admin->save();

	// }
});
