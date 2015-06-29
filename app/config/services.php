<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/

	'mailgun' => array(
		'domain' => '',
		'secret' => '',
	),

	'mandrill' => array(
		'secret' => '',
	),

	'stripe' => array(
		'model'  => 'User',
		'secret' => '',
	),

	//account on www.dropbox.com
	//Email: imagestock15@gmail.com
	//Password: imgstock
	'dropbox' => array(
		'token'  => 'I6P908FYjYAAAAAAAAAABurK00rlMjIyDduLi6uE2PTnkp08FlUlV9iFMAsmVY-p',
		'appName' => 'imagestock15',
	),

	//account on www.stripe.com
	//Email: imagestock15@gmail.com
	//Password: imgstock
	'stripe' => array(
		'secret_key' => 'sk_test_orBZIohKZXLrcGnCB6J4qjZt',
		'publishable_key' => 'pk_test_7aQTfW3gRkuKgPknD9AaXj6X'
	),

);
