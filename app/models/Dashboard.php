<?php

class Dashboard {


	public static function getOrders($arrData)
	{
		$arrReturn = ['status' => 'ok', 'data' => []];

		$arrData['fromDate'] = date('Y-m-d', strtotime($arrData['fromDate'])).' 00:00:00';
		$arrData['toDate'] = date('Y-m-d', strtotime($arrData['toDate'])).' 23:59:59';
		$orders = Order::select(DB::raw('DATE(created_at) as date, id, status, sum_amount'))
						->whereBetween('created_at', [$arrData['fromDate'], $arrData['toDate']]);

		if( !empty($arrData['status']) ) {
			$orders->where('status', $arrData['status']);
		}

		$orders = $orders->orderBy('id', 'asc')
							->get();
		$data = [];
		if( $arrData['groupBy'] == 'day' ) {
			$dateRange  = new DatePeriod(
			     new DateTime($arrData['fromDate']),
			     new DateInterval('P1D'),
			     new DateTime($arrData['toDate'])
			);
			foreach($dateRange as $date) {
				$data[$date->format('m-d')] = [$date->format('M d'), 0, ''];
			}

		} else if ( $arrData['groupBy'] == 'month' ) {
			$dateRange  = new DatePeriod(
			     new DateTime($arrData['fromDate']),
			     new DateInterval('P1M'),
			     new DateTime($arrData['toDate'])
			);
			foreach($dateRange as $date) {
				$data[$date->format('Y-m')] = [$date->format('M Y'), 0, ''];
			}
		} else {
			$dateRange  = new DatePeriod(
			     new DateTime($arrData['fromDate']),
			     new DateInterval('P1Y'),
			     new DateTime($arrData['toDate'])
			);
			foreach($dateRange as $date) {
				$data[$date->format('Y')] = [$date->format('Y'), 0, ''];
			}
		}
		if( !$orders->isEmpty() ) {
			$label = [
			        'New' => 'label-default',
			        'Submitted' => 'label-info',
			        'In production' => 'label-primary',
			        'Partly shipped' => 'label-warning',
			        'Completed' => 'label-success',
			        'Cancelled' => 'label-danger'
			];
			foreach($orders as $order) {
				list($year, $m, $day) = explode('-', $order->date);
				$month = date('M', strtotime($order->date));
				if( $arrData['groupBy'] == 'day' ) {
					$originKey = $m.'-'.$day;
					$key = $month.' '.$day;
				} else if( $arrData['groupBy'] == 'month' ) {
					$originKey = $year.'-'.$m;
					$key = $month.' '.$year;
				} else {
					$originKey = $year;
					$key = $year;
				}
				if( !empty($arrData['category']) ) {
					$categoryId = $arrData['category'];
					$order->order_details = OrderDetail::select('sum_amount')
								->where('order_id', $order->id)
								->whereRaw('(SELECT COUNT(*)
											FROM `categories` INNER JOIN `products_categories`
												ON `categories`.`id` = `products_categories`.`category_id`
											WHERE `products_categories`.`product_id` = `order_details`.`product_id`
											AND `categories`.`id` = '.$categoryId.') >= 1')
								->get();
					$amount = 0;
					if( isset($order->order_details) ) {
						foreach($order->order_details as $detail) {
							$amount += $detail->sum_amount;
						}
					}
					if( !$amount ) {
						continue;
					}
				} else {
					$amount = $order->sum_amount;
				}

				$order->status = '<span class="label '. $label[$order->status] .'">'. $order->status .'</span>';

				if( !isset($data[$originKey]) ) {
					$data[$originKey] = [$key, $amount, 'Order #'. $order->id.' - '. $order->status .' $ '.number_format($amount, 2) ];
				} else {
					$data[$originKey][1] += $amount;
					$data[$originKey][2] .= '<br />Order #'. $order->id.' - '. $order->status .' $ '.number_format($amount, 2);
				}
			}
		}
		ksort($data);
		$arrReturn['data'] = array_values($data);
		return $arrReturn;
	}
}