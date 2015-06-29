<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
    protected $layout = 'frontend.layout.default';

	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
            $this->layout = View::make($this->layout);
            $this->layout->metaInfo = Home::getMetaInfo();
            $this->layout->types = Home::getTypes();
            $this->layout->categories = Home::getCategories();
            $this->layout->headerMenu = Menu::getCache(['header' => true]);
            $this->layout->footerMenu = Menu::getCache(['footer' => true]);
		}
	}

	public static function errors($code = 404, $title = '', $message = '')
    {
        $ajax = Request::ajax();
        if( !$code ) {
            $code = 500;
            $title = 'Internal Server Error';
            $message = 'We got problems over here. Please try again later!';
        } else if( $code == 404 ) {
            $title = 'Oops! You\'re lost.';
            $message = 'We can not find the page you\'re looking for.';
        }
        if( Request::ajax() ) {
            return Response::json([
                'error' => [
                    'message' => $message
                    ]
            ],$code);
        }
        $arrData = [];
        $arrData['content'] = View::make('frontend.errors.error')->with(['title' => $title, 'code' => $code, 'message' => $message]);
        $arrData['metaInfo'] = Home::getMetaInfo();
        $arrData['metaInfo']['meta_title'] = $title;
        $arrData['types'] = Home::getTypes();
        $arrData['categories'] = Home::getCategories();
        $arrData['headerMenu'] = Menu::getCache(['header' => true]);
        return View::make('frontend.layout.default')->with($arrData);
    }

    public function searchColorFromArray($color, $images) {

        $arr_images = $images;
        if($color != '')
        {
            $arr_images = array();
            foreach($images as $value)
            {
                if($value['main_color'] != null && $value['main_color'] != '')
                {
                    $cols = explode(",", $value['main_color']);
                    $flag = false;
                    foreach($cols as $col)
                    {
                        $compare_result = $this->compareColors($color, $col);
                        if($compare_result)
                        {
                            $flag = true;
                            break;
                        }                       
                    }
                    if($flag)
                    {
                        $arr_images[] = $value;
                    }
                }   
            }
        }

        return $arr_images;
    }
    public function compareColors($col1, $col2, $tolerance=65) {

        $col1 = substr($col1, 1);
        $col2 = substr($col2, 1);
        $col1Rgb = array(
            "r" => hexdec(substr($col1, 0, 2)),
            "g" => hexdec(substr($col1, 2, 2)),
            "b" => hexdec(substr($col1, 4, 2))
        );
        $col2Rgb = array(
            "r" => hexdec(substr($col2, 0, 2)),
            "g" => hexdec(substr($col2, 2, 2)),
            "b" => hexdec(substr($col2, 4, 2))
        );
      
        return ($col1Rgb['r'] >= $col2Rgb['r'] - $tolerance && $col1Rgb['r'] <= $col2Rgb['r'] + $tolerance) && ($col1Rgb['g'] >= $col2Rgb['g'] - $tolerance && $col1Rgb['g'] <= $col2Rgb['g'] + $tolerance) && ($col1Rgb['b'] >= $col2Rgb['b'] - $tolerance && $col1Rgb['b'] <= $col2Rgb['b'] + $tolerance);
    }    

}
