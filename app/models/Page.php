<?php

class Page extends BaseModel {

	protected $table = 'pages';

	protected $rules = [
					'name' => 'required'
	];

	public function menu()
	{
		return $this->belongTo('Menu', 'menu_id');
	}

	public function beforeDelete($page)
    {
		$page->menu()->delete();
    }
}