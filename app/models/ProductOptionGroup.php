<?php

class ProductOptionGroup extends BaseModel {

	protected $table = 'option_groups';

	protected $rules = [
			'name' => 'required|min:6',
			'key' => 'required|min:5|unique:option_groups',
	];

	public function valid()
    {
        $arr = $this->toArray();
        if(isset($arr['id'])) {
            $this->rules['key'] .= ',key,'.$arr['id'];
        }
        return Validator::make(
            $arr,
            $this->rules
        );
    }

	public function options()
    {
        return $this->hasMany('ProductOption', 'option_group_id')
        				->orderBy('options.name', 'asc');
    }

	public function products()
	{
		return $this->morphedByMany('ProductOptionGroup', 'optionable', 'optionables', 'optionable_id')
        				->orderBy('products.name', 'asc');
	}

	public static function getSource($toJson = false, $getOptions = false)
	{
		$arrReturn = [];
		if( !$getOptions ) {
			$arrReturn[] = ['value' => 0, 'text' => ''];
		}
		$arrData = self::select('id', 'name')->orderBy('name', 'asc')->get();
		if( !$arrData->isEmpty() ) {
			foreach($arrData as $data) {
				$optionsData = [];
				if( $getOptions ) {
					$options = $data->options()->get();
					if( !$options->isEmpty() ) {
						foreach($options as $value) {
							$optionsData[] = ['value' => $value->id, 'text' => $value->name];
						}
					}
				}
				$arrReturn[] = ['value' => $data->id, 'text' => $data->name, 'options' => $optionsData];
			}
		}
		if( $toJson ) {
			$arrReturn = json_encode($arrReturn);
		}
		return $arrReturn;
	}

    public function beforeDelete($optionGroup)
	{
		$options = $optionGroup->options();
		$optionsData = $options->get();
		if( !$optionsData->isEmpty() ) {
			foreach($optionsData as $opt) {
				$opt->products()->detach();
			}
		}
		$options->delete();
		$optionGroup->products()->detach();
	}
}