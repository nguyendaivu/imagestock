<?php


class RecentlyViewImages extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'recently_view_images';
	
	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('user_id', 'image_id', 'created_by', 'updated_by');
	

}
