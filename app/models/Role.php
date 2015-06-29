<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public static $rules = array(
        'name' => 'required|between:4,128|unique:roles'
    );

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

    public function valid()
    {
        $arr = $this->toArray();
        $rules = self::$rules;
        if(isset($arr['id'])) {
            $rules['name'] = 'required|between:4,128|unique:roles,name,'.$arr['id'];
        }
        return Validator::make(
            $arr,
            $rules
        );
    }
}