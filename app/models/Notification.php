<?php
class Notification extends BaseModel {

	protected $table = 'notifications';

	public static function getNew($type, $data)
	{
		if( !isset($data['admin_id']) ) {
			$data['admin_id'] = Auth::admin()->get()->id;
		}
		if( isset($data['get_id']) ) {
			$users = self::select('item_id')
							->where('admin_id', $data['admin_id'])
							->where('read', 0)
							->where('item_type', $type)
							->get();
			$count = $users->count();
			$arrReturn = ['count' => $count, 'id' => []];
			foreach($users as $user) {
				$arrReturn['id'][] = $user->item_id;
			}
			return $arrReturn;
		}
		return self::where('admin_id', $data['admin_id'])
					->where('read', 0)
					->where('item_type', $type)
					->count();
	}

	public static function sendSocket($arrData, $fromCLI = false)
	{
		if( !isset($arrData['message']) ) {
			$arrData['message'] = 'Everything is ok!';
		}
		if( !isset($arrData['status']) ) {
			$arrData['status'] = 'success';
		}

		if( $fromCLI ) {
			if( !isset($arrData['event']) ) {
				$arrData['event'] = 'notification';
			}
			Pusherer::trigger('notification', $arrData['event'], $arrData);
		} else {
			$url = URL.'/'.md5(md5('send-message'));
			$curl = curl_init();
			curl_setopt ($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_HEADER, 0);
	        curl_setopt($curl, CURLOPT_PORT, 80);
	        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
	        curl_setopt($curl, CURLOPT_POST, true);
	        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($arrData));
			curl_exec($curl);
		}
	}

	public static function add($itemId, $itemType)
	{
		$admins = Admin::select('id')->get();
		if( !$admins->isEmpty() ) {
			$arrInserts = [];
			foreach($admins as $admin) {
				$arrInserts[] = [
									'item_id' 	=> $itemId,
									'item_type' => $itemType,
									'admin_id'	=> $admin->id
								];
			}
			self::insert($arrInserts);
		}
	}
}