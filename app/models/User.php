<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	
	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('first_name', 'last_name', 'email', 'image', 'password', 'subscribe', 'remember_token', 'active', 'created_by', 'updated_by');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array(/*'password', */'remember_token');

	protected $rules = array(
            		'password' 	=> 'required|min:6',
			'email' 	=> 'required|email|unique:users',
		);
	
	//minh
	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}
	
	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}
	
	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}
	
	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}
	
	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}
	
	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}	
	
	//end minh

	public function valid()
    {
        $arr = $this->toArray();
        if(isset($arr['id'])) {
            $this->rules['email'] .= ',email,'.$arr['id'];
            if(!isset($arr['password'])) {
                unset($this->rules['password']);
            } else {
                $this->rules['password'] .= '|confirmed';
                $this->rules['password_confirmation'] = 'required|min:6';
            }
        } else {
            $this->rules['password'] .= '|confirmed';
            $this->rules['password_confirmation'] = 'required|min:6';
        }

        return Validator::make(
            $arr,
            $this->rules
        );
    }

	public function address()
	{
        return $this->hasMany('Address', 'user_id')
        				->orderBy('addresses.id', 'asc');
    }

	public function beforeDelete($user)
	{
		$user->images()->detach();
	}

	public function afterCreate($user)
	{
		Notification::add($user->id, 'User');
	}

	public function orders()
	{
		return $this->hasMany("Order");
	}

}
