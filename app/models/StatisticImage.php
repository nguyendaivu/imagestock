<?php

class StatisticImage extends BaseModel {

	protected $table = 'statistic_image';
	protected $rules = [
			'image_id' => 'required|numeric'
	];

	public function scopeIncreaseView($query,$image_id){
		 return $query->update('UPDATE statistic_image SET view = view + 1 WHERE id = ?',array($image_id));
	}

	public function scopeIncreaseDownload($query,$image_id){
		 return $query->update('UPDATE statistic_image SET download = download + 1 WHERE id = ?',array($image_id));
	}
}