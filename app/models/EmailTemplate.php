<?php

class EmailTemplate extends BaseModel {

	protected $table = 'email_templates';

	protected $rules = array(
			'name' 		=> 'required',
			'type' 		=> 'required',
		);
}