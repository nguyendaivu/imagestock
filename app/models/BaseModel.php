<?php

class BaseModel extends \Eloquent {

    protected $guarded = array('id');

    protected $rules = array();

	public static function boot()
    {
        parent::boot();
        self::creating(function($model) {
            if( method_exists((new Auth), 'admin') ) {
                $model->created_by = Auth::admin()->get()->id;
                $model->updated_by = Auth::admin()->get()->id;
            }
        });
        self::created(function($model) {
            $model->afterCreate($model);
        });
        self::updating(function($model) {
            if( method_exists((new Auth), 'admin') ) {
                $model->updated_by = Auth::admin()->get()->id;
            }
        });
        self::deleting(function($model){
            $model->beforeDelete($model);
        });
        self::saved(function($model){
            $model->afterSave($model);
        });

    }

    public function valid()
    {
    	return Validator::make(
            $this->toArray(),
            $this->rules
        );
    }

    public function afterCreate($model)
    {
    }

    public function afterSave($model)
    {
    }

    public function beforeDelete($model)
    {
    }
}