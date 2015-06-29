<?php

class DashboardsController extends AdminController {

    public function index()
    {
        $min_date = '01/01/2015';
        $max_date = date('m/d/Y');

        $data = ['admin_id' => Auth::admin()->get()->id];

        $arrData = [];
        $arrData['notifications'] = [
                                    'users'         => Notification::getNew( 'User', $data ),
                                    'images'      => Notification::getNew( 'Image', $data ),
                                    'orders'        => Notification::getNew( 'Order', $data ),
                                ];
        $arrData['date'] = [
                            'min_date'      => $min_date,
                            'max_date'      => $max_date,
                            'current_date'  => new DateTime(),
                            'start_date'    => new DateTime('7 days ago')
                        ];

        $this->layout->title = 'Dashboard';
        $this->layout->content = View::make('admin.dashboard')->with( $arrData );
    }

    public function getOrderStatistic()
    {
        if( !Request::ajax() ) {
            return App::abort(404);
        }
        $fromDate = Input::has('date_start') ? Input::get('date_start') : date('m/d/Y');
        $toDate = Input::has('date_end') ? Input::get('date_end') : date('m/d/Y');
        $status = Input::has('order_status') ? Input::get('order_status') : '';
        $category = Input::has('product_category') ? Input::get('product_category') : '';
        $groupBy = Input::has('range_filter') ? Input::get('range_filter') : 'day';

        $arrData = Dashboard::getOrders([
                                'fromDate'  => $fromDate,
                                'toDate'    => $toDate,
                                'status'    => $status,
                                'category'  => $category,
                                'groupBy'   => $groupBy,
                            ]);

        $response = Response::json($arrData);
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}
