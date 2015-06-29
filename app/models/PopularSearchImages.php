<?php


class PopularSearchImages extends BaseModel{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'popular_search_images';
	
	/* Alowing Eloquent to insert data into our database */
	protected $fillable = array('keyword', 'image_id', 'query', 'created_by', 'updated_by');
	

}
