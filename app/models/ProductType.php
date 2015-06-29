<?php

class ProductType extends BaseModel {

	protected $table = 'types';

	protected $rules = [
			'name' => 'required|min:6|unique:types',
	];

	public function valid()
    {
        $arr = $this->toArray();
        if(isset($arr['id'])) {
            $this->rules['name'] .= ',name,'.$arr['id'];
        }
        return Validator::make(
            $arr,
            $this->rules
        );
    }

	public function products()
    {
        return $this->hasMany('Product', 'product_type_id');
    }

	public static function getSource($toJson = false)
	{
		$arrReturn = [];
		$arrReturn[] = ['value' => 0, 'text' => ''];
		$arrData = self::select('id', 'name')->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				$arrReturn[] = ['value' => $data->id, 'text' => $data->name];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

    public function beforeDelete($type)
	{
		$type->products()->update(['product_type_id' => 0]);
	}
}