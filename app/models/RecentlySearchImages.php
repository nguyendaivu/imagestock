<?php


class RecentlySearchImages extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'recently_search_images';
	
	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('user_id', 'keyword', 'image_id', 'query', 'created_by', 'updated_by');
	

}
