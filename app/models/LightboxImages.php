<?php


class LightboxImages extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'lightbox_images';
	
	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('lightbox_id', 'image_id', 'created_by', 'updated_by');
	

}
