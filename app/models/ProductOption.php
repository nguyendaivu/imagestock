<?php

class ProductOption extends BaseModel {

	protected $table = 'options';

    protected $rules = [
            'name'              => 'required|min:6',
            'key'               => 'required|min:5|unique:option_groups',
            'option_group_id'   => 'numeric',
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

	public function products()
    {
        return $this->morphedByMany('ProductOption', 'optionable', 'optionables', 'optionable_id');
    }

    public function optionGroup()
    {
        return $this->belongsTo('ProductOptionGroup');
    }

    public function beforeDelete($option)
	{
		$option->products()->detach();
	}
}