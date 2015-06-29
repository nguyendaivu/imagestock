<?php

class JTProvince extends JT {

	protected $collection = 'tb_province';

	public static function getName($provinceKey)
	{
		return self::where('deleted', false)
					->where('key', $provinceKey)
					->pluck('name');
	}

}