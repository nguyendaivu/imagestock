<?php
class AdminController extends Controller {
    protected $layout = 'admin.layout.default';

    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
            $this->layout->admin = Auth::admin()->get();
            if( !Request::ajax() ) {
                $this->layout->currentTheme = Cookie::has('theme') ? Cookie::get('theme') : [];
                $this->layout->sideMenu = Menu::getCache(['sidebar' => true]);
            }
        }
    }

    public function synchronize()
    {
        BackgroundProcess::sync();
        return Response::json(1);
    }

    public function lock()
    {
        $prevURL = URL::previous();
        if( Request::ajax() ) {
            $admin = Auth::admin()->get();
            if( !Input::has('password') ) {
                $message = 'You must enter password to re-login.';
            } else {
                if( Hash::check( Input::get('password'), $admin->password ) ) {
                    Session::forget('lock');
                    Session::flash('flash_success', 'Welcome back.<br />You has been login successful!');
                    return ['status' => 'ok'];
                }
                $message = 'Your password is not correct.';
            }
            return ['status' => 'error', 'message' => $message];
        } else if( Request::isMethod('get') ) {
            Session::put('lock', true);
        }
        if( empty($prevURL) || strpos($prevURL, '/admin/lock') !== false ) {
            $prevURL = URL.'/admin';
        }
        return Redirect::to($prevURL);
    }

    public static function errors($code = 404, $title = 'Oops! You\'re lost.', $message = '')
    {
        $ajax = Request::ajax();
        if( $code == 404 ) {
            $title = 'Oops! You\'re lost.';
            $message = 'We can not find the page you\'re looking for.';
            if( !$ajax ) {
                $message .= '<br/><a href="'.URL.'/admin">Return home </a>';
            }
        } else if( $code == 403 ){
            $title = 'Oops! You are not allowed to go to this page.';
            $message = 'Please check your permission.';
            if( !$ajax ) {
                $message .= '<a href="'.URL.'/admin">
                        Return home </a>';
            }
        } else if( !$code || $code == 500 ) {
            $code = 500;
            if( empty($title) ) {
                $title = 'Internal Server Error';
            }
            if( empty($message) ) {
                $message = 'We got problems over here. Please try again later!';
            }
        }
        if($ajax)
            return Response::json([
                'error' => [
                    'title'     => $title,
                    'message'   => $message
                    ]
            ],$code);
        return View::make('admin.errors.error')->with(['title' => $title, 'code' => $code, 'message' => $message, 'admin' => Auth::admin()->get(), 'sideMenu' => Menu::getCache(['sidebar' => true]), 'currentTheme' => Cookie::has('theme') ? Cookie::get('theme') : 'default']);
    }

    public function viewChat()
    {
        $arrReturn = [];
        if( Input::has('chatter_id') ){
            $chatterId = Input::get('chatter_id');
            if( strlen($chatterId) == 24 ) {
                return Response::json(Chat::getChat($chatterId));
            }
        }
        return $arrReturn;
    }

    public function updateRead()
    {
        if( Input::has('chatter_id') ){
            $chatterId = Input::get('chatter_id');
            Chat::updateRead($chatterId);
            return Response::json(Chat::countNewMessage());
        }
    }
}
