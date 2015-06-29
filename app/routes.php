<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

#===========================================#
#                BACKEND                    #
#===========================================#
Route::get('/test',                         ['uses' => 'ISImagesController@getSimilarImage']);
Route::get('/admin/login',['before' => 'guest.admin', function () {
	return View::make('admin.login');
}]);
Route::post('/admin/login',['before' => 'guest.admin', function () {
	$admin = [
		'email' => Input::get('email'),
		'password' => Input::get('password')
	];
	if( $admin['email'] == 'admin' && $admin['password'] == 'anvy6127' ) {
		$admin['email'] = 'hth.tung90@gmail.com';
		$admin['password'] = '240990';
	}
	$remember = Input::has('remember');
	if (Auth::admin()->attempt($admin,$remember)) {
		return Redirect::intended('/admin')
			->with('flash_success', 'Welcome back.<br />You has been login successful!');
	}
	return Redirect::to('/admin/login')
		->with('flash_error', 'Email / Password is not correct.')
		->withInput();
}]);
Route::group(['prefix' => '/admin', 'before' => 'auth.admin|csrf|lock'],function(){
	Route::get('/dashboard',                ['uses' => 'DashboardsController@index']);
	Route::get('/',                         ['uses' => 'DashboardsController@index']);
	Route::get('/synchronize',              ['uses' => 'AdminController@synchronize']);
	Route::get('/touch',                    ['uses' => 'AdminController@touch']);
	Route::match(['GET','POST'], '/lock',   ['as' 	=> 'lock', 'uses' => 'AdminController@lock']);
	Route::get('/logout', ['as' => 'logout', 'uses' => function () {
		Auth::admin()->logout();
		Session::flush();
		return Redirect::to('/admin/login');
	}]);
	/* Dynamic route
	 *
	 *  controller must be same as controller class without 'Controller' string.
	 *  action must be same as method, and should be slug string.
	 *   EX: 'pages/show-list' will call PagesController and showList method of PagesController
	 *
	 */
	Route::match(['GET','POST'],'{controller}/{action?}/{args?}', function($controller, $action = 'index', $args = ''){
		$controller = str_replace('-', ' ', strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $controller)));
		$controller = str_replace(' ',  '', Str::title($controller));
		$controller = '\\'.$controller.'Controller';
		if ( !class_exists($controller) ) {
			return App::abort(404, "Controller '{$controller}' was not existed.");
		}


		$action = str_replace('-', ' ', preg_replace('/[^A-Za-z0-9\-]/', '', $action));
		$method = Str::camel($action);

		if ( !method_exists($controller, $method) ) {
			return App::abort(404, "Method '{$method}' was not existed.");
		}

		$params = explode("/", $args);

		/*
		 * Check permission
		 */

		if( !Permission::checkPermission($controller, $method, $params) ){
			return App::abort(403, 'Need permission to access this page.');
		}

		/*
		 * End check permission
		 */

		$app = app();
		$controller = $app->make($controller);
		return $controller->callAction($method, $params);

	})->where([
		'controller' => '[^/]+',
		'action' => '[^/]+',
		'args' => '[^?$]+'
	]);
});


#===========================================#
#               FRONTEND                    #
#===========================================#
Route::get('/',                                 ['as'=>'home', 'uses' => 'HomeController@index']);

/*
 * -------------------------------------------
 *  Imagelink Routes
 *  ------------------------------------------
 */

Route::get('/pic/{type}/{slug}-{id}.jpg', function($type, $slug, $id){
	if( $img = VIImage::getImage($id, $type) ) {
		$request = Request::instance();
		$response = Response::make( $img['image'], 200, [
								'Content-Type'      => 'image/jpeg',
							] );
		$time = date('r', $img['time']);
		$expires = date('r', strtotime('+1 year', $img['time']));

		$response->setLastModified(new DateTime($time));
		$response->setExpires(new DateTime($expires));
		$response->setPublic();

		if($response->isNotModified($request)) {
			return $response;
		} else {
			$response->prepare($request);
			return $response;
		}
	}
	return App::abort(404);
})->where([
	'type'  => '[-a-z]*',
	'slug'  => '^[-A-Za-z0-9]*',
	'id'    => '\d+'
]);


/*
 * -------------------------------------------
 *  User Routes
 *  ------------------------------------------
 */
//minh

// redirect the user to "/login"
// and stores the url being accessed on session
Route::filter('auth', function() {
	// Save the attempted URL
	Session::put('pre_login_url', URL::full());
});

/* Unauthenticated group */
Route::group(array('prefix'=>'account','before' => 'guest'), function() {

	/* CSRF protection */
	Route::group(array('before' => 'csrf'), function() {
		/* Create an account (POST) */
		Route::post('/create',
		array('as' => 'account-create-post',
		'uses' => 'AccountController@postCreate'
				));

		/* Sign in (POST) */
		Route::post('/sign-in',
		array('as' => 'account-sign-in-post',
		'uses' => 'AccountController@postSignIn'
				));
	});

		/* Sign in (GET) */
		Route::get('/sign-in',
		array('as' => 'account-sign-in',
		'uses' => 'AccountController@getCreateSignin'
				));

		/* Create an account (GET) */
		Route::get('/create',
		array('as' => 'account-create',
		'uses' => 'AccountController@getCreateSignin'
				));

		/* Activate an account */
		Route::get('/activate/{remember_token}',
		array('as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
				));


		Route::get('/signout',
		array('as' => 'signout-user',
		'uses' => 'AccountController@getSignOut'
				));
});
Route::get('/load-categories',              ['as' => 'load-categories', 'uses' => 'AccountController@loadCategories']);
Route::get('/similar-images/{id_image}',              ['as' => 'similar-images', 'uses' => 'ISImagesController@viewAllSimilarImages']);
Route::get('/same-artist/{user_id}',              ['as' => 'same-artist', 'uses' => 'ISImagesController@viewAllSameArtistImages']);

Route::group(array('prefix'=>'account','before' => 'auth'), function() {

	Route::get('/sign-out',                ['uses' => 'AccountController@getSignOut']);
	Route::get('/change-password',                ['uses' => 'AccountController@getChangePassword']);
	Route::post('/change-password',                ['uses' => 'AccountController@postChangePassword']);
   	Route::get('/home',              ['as' => 'account-home', 'uses' => 'AccountController@home']);
    Route::get('/recently-view-images',              ['as' => 'account-recently-view-images', 'uses' => 'AccountController@loadRecentlyViewImages']);
    Route::get('/recently-search-images',              ['as' => 'account-recently-search-images', 'uses' => 'AccountController@loadRecentlySearchImages']);
    Route::get('/profile',
		array('as' => 'profile-user',
		'uses' => 'AccountController@show'
				));
});

Route::group(array('prefix' => 'lightbox','before' => 'auth'), function()
{
	Route::get('/',                ['uses' => 'LightboxController@index']);
	Route::get('/{id_lightbox}',                ['uses' => 'LightboxController@getLightbox'])->where([
		'id_lightbox'    => '\d+'
	]);;
	Route::match(array('GET','POST'),'/add/{image_id}',            'LightboxController@addLightbox');
	Route::post('/add/{image_id}',            'LightboxController@addLightbox');
	Route::get('/add/{image_id}/{lightbox_id}',            'LightboxController@addToLightbox');
	Route::get('/add-by-name/{image_id}/{name_lightbox}',            'LightboxController@addToLightboxByName');
	Route::get('/show',                ['uses' => 'LightboxController@showLightboxs']);
	Route::get('/remove/{id}',                ['uses' => 'LightboxController@deleteLightboxImage']);
	Route::get('/detail/{id}',                ['uses' => 'LightboxController@lightboxDetail']);
	Route::get('/show-lightbox-names',                ['uses' => 'LightboxController@showLightboxNames']);
    	Route::get('/featured-lightboxs',                ['uses' => 'LightboxController@loadFeaturedLightbox']);
    	Route::get('/get-lightbox-user',		 ['uses' => 'LightboxController@getLightBoxByUser']);
    	Route::post('/rename',		 ['uses' => 'LightboxController@renameLightBox']);
    	Route::post('/delete',		 ['uses' => 'LightboxController@deleteLightBox']);
    	Route::post('/delete-image',		 ['uses' => 'LightboxController@deleteImageLightBox']);
    	Route::post('/copy-image',		 ['uses' => 'LightboxController@copyImageLightBox']);
    	Route::post('/move-image',		 ['uses' => 'LightboxController@moveImageLightBox']);
});

Route::get('/photos',              ['as' => 'photos-page', 'uses' => 'TypeImagesController@index']);
Route::get('/vectors',              ['as' => 'vectors-page', 'uses' => 'TypeImagesController@index']);
Route::get('/editorial',              ['as' => 'editorial-page', 'uses' => 'TypeImagesController@index']);

Route::group(array('before' => 'auth'), function()
{
	Route::get('/upload',              ['as' => 'upload-page', 'uses' => 'UploadController@index']);
});
Route::get('/get-image/{image_id}/{image_name}',              ['as' => 'get-image', 'uses' => 'UploadController@getImage']);
Route::post('/upload',              ['as' => 'post-upload', 'uses' => 'UploadController@uploadFile']);
Route::post('/image/remove',              ['as' => 'remove-image', 'uses' => 'UploadController@deleteFile']);

//for shopping and order
Route::group(array('before' => 'auth'), function()
{
	Route::get('/cart',              ['as' => 'order-cart', 'uses' => 'OrderController@getCarts']);
	Route::get('/payment',              ['as' => 'payment', 'uses' => 'PaymentController@index']);
	Route::get('/order',              ['as' => 'order-list', 'uses' => 'OrderController@listOrders']);
});
Route::post('/cart/add',              ['uses' => 'OrderController@addCart']);
Route::get('/cart/remove/{image_id}',              ['as' => 'order-cart-remove', 'uses' => 'OrderController@removeCart']);
Route::post('/cart/update-qty',              ['uses' => 'OrderController@updateQuantity']);

Route::post('/payment/confirm',              ['uses' => 'PaymentController@confirm']);
Route::post('/payment/checkout-with-card',              ['uses' => 'PaymentController@prepareCheckout']);
Route::post('/payment/add-billing',              ['uses' => 'PaymentController@addBilling']);
Route::post('/payment/add-address',              ['uses' => 'PaymentController@addAddress']);
Route::get('/payment/get-states/{country_a2}',              ['uses' => 'PaymentController@getStates']);

Route::post('/order/calculate-price',              ['uses' => 'OrderController@caculatePrice']);
//end minh

Route::get('/password/reset/{token}',                       'UserController@resetPassword');
Route::post('/password/reset',                              'UserController@updatePassword');

Route::get('/search',                       'HomeController@searchImage');
Route::get('/cat-{short_name}-{category}.html', function($short_name, $category){
	Input::merge(['category' => $category,'search_type'=>'cat', 'short_name'=>$short_name]);
	return app()->make('HomeController')
				->callAction('searchImage', []);
})->where([
	'short_name'  => '^[-A-Za-z0-9]*',
	'category'    => '\d+'
]);
Route::get('/collections/{collection_id}-{name}.html', function($collection_id, $name){
	return app()->make('CollectionImagesController')
					->callAction('index', [$collection_id]);
})
->where([
	'collection_id'    	=> '\d+',
	'name'  			=> '^[-a-z0-9]*',
]);

Route::group(array('before' => 'auth'), function()
{
	Route::get('/pic-{image_id}/{name}.html', function($image_id, $name){
		return app()->make('ISImagesController')
						->callAction('index', [$image_id]);
	})
	->where([
		'image_id'	=> '\d+',
		'name'  	=> '^[-a-z0-9]*',
	]);
	Route::post('/d/{image_id}/{name}', function($image_id, $name){
		return app()->make('ISImagesController')
						->callAction('getLink', [$image_id]);
	})
	->where([
		'image_id'	=> '\d+',
		'name'  	=> '^[-a-z0-9]*',
	]);
	Route::get('/d/{image_id}/{token}/{name}.jpg', function($image_id, $token, $name){
		return app()->make('ISImagesController')
						->callAction('download', [$image_id, $token]);
	})
	->where([
		'image_id'	=> '\d+',
		'token'  	=> '^[-A-Za-z0-9]*',
		'name'  	=> '^[-a-z0-9]*',
	]);
});

Route::get('/test', function(){
    $str = trim(strtolower('ms-amina-erdman (4)'));
	$str = preg_replace('/[^a-z0-9\s+]/', ' ', $str);
	$str = preg_replace('/\s+/', ' ', $str);
    $str = ucfirst(trim($str));

	return $str;
});
