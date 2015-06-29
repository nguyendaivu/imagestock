<?php

class HomeController extends BaseController {

	public function index()
	{
		if( Auth::user()->check())
		{
			$this->layout->content = View::make('frontend.account.home')->with([
											]);
			return;
		}

		$types = $this->layout->types;
		$categories = $this->layout->categories;
		$arr_img=array();
		foreach ($types as $key => $type){
			$arr_img[$key] = VIImage::select('short_name', 'id', 'name','artist')->where('type_id','=',$type['id'])->withType('main')->orderBy('created_at')->take(6)->get();
		}
		$this->layout->content = View::make('frontend.index')->with([
										'types' => $types,
										'arr_img'=>$arr_img,
										'categories'=>$categories,
										'banner' => Home::getBanners()
											]);
	}

	public function searchImage(){
		$keyword = Input::has('keyword')?Input::get('keyword'):'';

		//for recently searched images
		$keyword_searched = $keyword;
		$short_name = Input::has('short_name')?Input::get('short_name'):'';

		$sort_method=Input::has('sort_method')?Input::get('sort_method'):'new';
		$sort_style=Input::has('sort_style')?Input::get('sort_style'):'mosaic';
		if(trim($keyword) != '')
		{
			$keyword = '*'.trim($keyword).'*';	
		}
		
		$page = Input::has('page')?Input::get('page'):1;
		$take = Input::has('take')?Input::get('take'):30;
		$type = Input::has('type')?intval(Input::get('type')):0;
		$orientation = Input::has('orientation')?Input::get('orientation'):'any';
		$skip = ($page-1)*$take;
		$category = Input::has('category')?intval(Input::get('category')):0;
		$search_type =  Input::has('search_type')?(Input::get('search_type')):'search';

		$exclude_keyword = Input::has('exclude_keyword')?'*'.(Input::get('exclude_keyword')).'*':'';
		$exclude_people = Input::has('exclude_people');
		$include_people = Input::has('include_people');
		$gender = Input::has('gender')?(Input::get('gender')):'any';
		$age = Input::has('age')?(Input::get('age')):'any';
		$ethnicity = Input::has('ethnicity')?(Input::get('ethnicity')):'any';
		$number_people = Input::has('number_people')?(Input::get('number_people')):'any';
		$color = Input::has('color')?(Input::get('color')):'';

		$images = VIImage::select('images.short_name', 
								'images.id', 
								'images.name', 
								'images.main_color', 
								DB::raw('count(lightbox_images.id) as count_favorite')
								)
							->leftJoin('lightbox_images', 'images.id', '=', 'lightbox_images.image_id')
							->groupBy('images.id')->with('downloads');
		switch($sort_method){
			case 'new':				
					$images = $images->with('statistic')
					->orderBy('images.id','desc')
					->withType('main')
					->withOrientation($orientation);				
				break;
			case 'relevant':
					$images = $images->with('statistic')
					->orderBy('images.id','desc')
					->withType('main')
					->withOrientation($orientation);
				break;
			case 'popular':
					$images = $images->join('statistic_image','statistic_image.image_id','=','images.id')
					->with('statistic')
					->orderBy('view','desc')
					->orderBy('download','desc')
					->withType('main')
					->withOrientation($orientation);
				break;
			case 'undiscovered':
					$images = $images->join('statistic_image','statistic_image.image_id','=','images.id')
					->with('statistic')
					->orderBy('view','asc')
					->orderBy('download','asc')
					->withType('main')
					->withOrientation($orientation);
				break;
			default:
					$images = $images->with('statistic')
					->orderBy('images.id','desc')
					->withType('main')
					->withOrientation($orientation);
				break;
		}

		if($search_type=='search' && $keyword != ''){
			$images =$images->search($keyword);
		}
		if($exclude_keyword != ''){
			$images =$images->notSearchKeyWords($exclude_keyword);
		}
		if($exclude_people){
			$images =$images->where('number_people','=',0);
		}
		if($include_people){
			if($gender!='any'){
				$images =$images->where('gender','=',$gender);
			}
			if($age!='any'){
				$age = explode('-',$age);
				$from = intval($age[0]);
				$to = intval($age[1]);
				$images =$images->where('age_from','<=',$to)->where('age_to','>=',$from);
			}
			if($ethnicity != 'any'){
				$images =$images->where('ethnicity','=',$ethnicity);
			}

			if($number_people != 'any'){
				if($number_people <4){
					$images =$images->where('number_people','=',$number_people);
				}else{
					$images =$images->where('number_people','>=',$number_people);
				}
			}
		}

		if(!(Input::has('editorial') && Input::has('non_editorial'))){
			if(Input::has('editorial')){
				$images =$images->where('editorial','=',1);
			}
			if(Input::has('non_editorial')){
				$images =$images->where('editorial','=',0);
			}
		}

		 if($type!=0){
			$images = $images->where('type_id','=',$type);
		 }
		 if($category!=0){
			$images = $images->join('images_categories','images_categories.image_id','=','images.id')
					     ->where('images_categories.category_id','=',$category);
		 }

		 $total_image =$images->count();
		 $images = $images->get()->toArray();

        $images = $this->searchColorFromArray($color, $images);
        $total_image = count($images);


		$images = array_slice($images, $skip, $take);

		//pr(DB::getQueryLog());die;
		$total_page = ceil($total_image/$take);
		
		//for recently searched images
		if((trim($keyword_searched) != '' || $short_name != '') && count($images) > 0)
		{
			if($keyword_searched == '')
			{
				$keyword_searched = str_replace('-',' ',$short_name);
			}
			if(Auth::user()->check())
			{
				BackgroundProcess::actionSearch(['type'=>'recently-search',
												'keyword'=>$keyword_searched,
												'image_id'=>$images[0]['id'],
												'user_id'=>Auth::user()->get()->id,
												'query'=>Request::server('REQUEST_URI')
											]);

			}
			BackgroundProcess::actionSearch(['type'=>'popular-search',
											'keyword'=>$keyword_searched,
											'image_id'=>$images[0]['id'],
											'query'=>Request::server('REQUEST_URI')
										]);
		}

		$lightboxes = array();
		if(Auth::user()->check())
		{
			$lightboxes = Lightbox::where('user_id','=',Auth::user()->get()->id)->get()->toArray();
			foreach ($lightboxes as $key => $lightbox) {
				$lightboxes[$key]['total'] = LightboxImages::where('lightbox_id','=',$lightbox['id'])->count();
			}

		}

		$image_action_title = 'Like this item';
		if(Auth::user()->check())
		{
			$image_action_title = 'Save to lightbox';
		}
		$arr_sort_method = array('new'=>'New','popular'=>'Popular','relevant'=>'Relevant','undiscovered'=>'Undiscovered');
		$arrReturn = array(
			'images' => $images,
			'total_page' => $total_page,
			"total_image"=>$total_image,
			"sort_style"=>$sort_style,
			"search_type"=>$search_type,
			"categories"=>$this->layout->categories,
			"lightboxes"=>$lightboxes,
			"image_action_title"=>$image_action_title,
			"arr_sort_method"=>$arr_sort_method,
			"sort_method"=>$sort_method,
			'mod_download'=>Configure::GetValueConfigByKey('mod_download'),
			'mod_order'=>Configure::GetValueConfigByKey('mod_download')
		);
		if(Request::ajax()){
			return $arrReturn;
		}
		$this->layout->in_search = 1;
		$this->layout->content = View::make('frontend.search')->with($arrReturn);
	}
}
