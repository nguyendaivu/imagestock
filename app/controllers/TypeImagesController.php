<?php
use Illuminate\Support\Facades\Auth;
class TypeImagesController extends BaseController {


	public function index()
	{

		$arrReturn = array();

		$typeObj = Type::where('short_name', Request::path())
						->first();
		$type_id = '1';
		// pr($typeObj);die;
		if( is_object($typeObj) ) {
			$arrReturn['typeObj'] = $typeObj;
			$type_id = $typeObj->id;
		}

		$arrReturn['htmlPopularSearches'] = $this->loadPopularSearchImages();
		$arrReturn['htmlFeaturedCollections'] = $this->loadFeaturedCollections($type_id);

		$this->layout->content = View::make('frontend.types.index')->with(
			$arrReturn
		);
	}

	//load popular image searches
	public function loadPopularSearchImages()
	{
		$query = PopularSearchImages::select('popular_search_images.keyword', 
												'popular_search_images.query', 
												'images.id', 
												'images.short_name', 
												'image_details.ratio', 
												DB::raw('COUNT(keyword) as total_searched')
											)
										->leftJoin('images', 'images.id', '=', 'popular_search_images.image_id')
										->leftJoin('image_details', function($join){
											$join->on('image_details.image_id', '=', 'popular_search_images.image_id')
													->where('image_details.type', '=', 'main');
										})
										->groupBy('keyword')
										->orderBy('total_searched', 'desc')
										->take(16)
										->get();
		$arrReturn = [
					'arrKeywords' 			 => [],
					'arrPopularSearchImages' => []
				];
		if( !$query->isempty() ) {
			$query = $query->toArray();
			$arrReturn['arrKeywords'] = $query;
			$dataKeywords = array_slice($arrReturn['arrKeywords'], 0, 8);
			foreach($dataKeywords as $keyword) {
				if( $keyword['ratio'] > 1 ) {
					$width = 450;
	    			$height = $width / $keyword['ratio'];
				} else {
					$height = 450;
	    			$width = $height * $keyword['ratio'];
				}
				$arrReturn['arrPopularSearchImages'][] = [
															'path' => '/pic/crop/'.$keyword['short_name'].'-'.$keyword['id'].'.jpg',
															'width' => $width,
															'height' => $height,
															'keyword' => $keyword['keyword'],
															'query' => $keyword['query']
														];
			}
		}

		$html = View::make('frontend.types.popular-search-images')
			->with($arrReturn)->render();
		return $html;

	}

	public function loadFeaturedCollections($type_id){
		$data = Collection::getFrontend($type_id);
		$arrFeaturedCollection = array();
		foreach($data as $value) {
			$width = $height = 0;
			$path = '/assets/images/noimage/315x165.gif';
			if( !empty($value['image']) ) {
				if( $value['image']['ratio'] > 1 ) {
					$width = 450;
	    			$height = $width / $value['image']['ratio'];
				} else {
					$height = 450;
	    			$width = $height * $value['image']['ratio'];
				}
				$path = '/pic/newcrop/'.$value['image']['short_name'].'-'.$value['image']['id'].'.jpg';
			}
			$arrFeaturedCollection[] = [
										'collection_id' => $value['id'],
										'collection_name' => $value['name'],
										'collection_short_name' => $value['short_name'],
										'width' 	=> $width,
										'height'	=> $height,
										'path'		=> $path
									];
		}


		if( Request::ajax() ) {
			$html = View::make('frontend.types.featured-collections')->with('arrFeaturedCollection', $arrFeaturedCollection)->render();
			$arrReturn = ['status' => 'ok', 'message' => '', 'html'=>$html];

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}

		return View::make('frontend.types.featured-collections')->with('arrFeaturedCollection', $arrFeaturedCollection)->render();
	}

	//Add to popular_search_images table
	public function addToPopularSearchImages($arrData) {

		//$query = Request::server('REQUEST_URI');
		$query = isset($arrData['query']) ? $arrData['query'] : "";		
		$request_url = (Request::server('REQUEST_URI') != "" && Request::server('REQUEST_URI') != "/") ? Request::server('REQUEST_URI') : $query;
		
		return PopularSearchImages::create(array(
				'keyword' 	=> trim($arrData['keyword']),
				'image_id' 	=> $arrData['image_id'],
				'query' 	=> $request_url
		));
						
	}	

}