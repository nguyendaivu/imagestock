<?php
use Illuminate\Support\Facades\Auth;
class LightboxController extends BaseController {


	public function index()
	{
		if(Auth::user()->check()){
			$lightboxes = Lightbox::where('user_id', '=', Auth::user()->get()->id)
							->orderBy('id','desc')
							->get()->toArray();
			if(count($lightboxes) > 0)
			{
				foreach ($lightboxes as $key => $value)
				{
					$imgdetail = LightboxImages::select('lightbox_images.lightbox_id',
												'images.short_name',
												'lightbox_images.image_id',
												'lightbox_images.created_at',
												'lightbox_images.updated_at'

						);
					$imgdetail->leftJoin('images', 'images.id', '=', 'lightbox_images.image_id');
					$imgdetail->leftJoin('image_details', 'lightbox_images.image_id', '=', 'image_details.image_id');
					$imgdetail->where('lightbox_images.lightbox_id', '=', $value['id']);
					$imgdetail->where('image_details.type', '=', 'main');
					$imgdetail->orderBy('updated_at','desc');
					$imgdetail->orderBy('created_at','desc');
					$imageDetail = $imgdetail->first();
					if(is_object($imageDetail))
					{
						$lightboxes[$key]['path'] = '/pic/thumb/'.$imageDetail->short_name.'-'.$imageDetail->image_id.'.jpg';
					}else{
						unset($lightboxes[$key]);
					}
				}
			}
			$this->layout->content = View::make('frontend.lightbox.index')->with([
														'lightboxes'=>$lightboxes
														]);
		}else{
			return Redirect::to(URL.'/account/sign-in');
		}
	}

	public function addLightbox($image_id) {

		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{

				$validator = Validator::make(Input::all(),
						array(
								'name'		=> 'required|max:20|min:3'
						)
				);

				if($validator->fails() || empty($image_id)) {

					return Response::json(['result'=>'failed', 'message'=>'Validation failed.']);

				} else {
					// create an lightbox
					$name 		= Input::get('name');

					// record
					$dataLightBox = Lightbox::create(array(
							'name' 	=> $name,
							'user_id' 	=> Auth::user()->get()->id
					));

					if($dataLightBox) {

						//Add to Lightbox-Images table
						$data = LightboxImages::create(array(
								'lightbox_id' 	=> $dataLightBox->id,
								'image_id' 	=> $image_id
						));

						if($data)
						{
							return Response::json(['result'=>'success', 'message'=>'Added to your lightbox successfully.', 'data' => ['name' => $dataLightBox->name, 'id' => $dataLightBox->id ]]);
						}
						else
						{
							return Response::json(['result'=>'failed', 'message'=>'Sory, could not add to your lightbox at this time.']);
						}

					}
					else
					{
						return Response::json(['result'=>'failed', 'message'=>'Could not add to your lightbox.']);
					}
				}
			}
			else
			{
				return Response::json(['result'=>'failed', 'message'=>'Please login first.']);
			}
		}
		return Redirect::route('home');
	}

	public function addToLightbox($image_id, $lightbox_id) {

		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$lightbox_images = LightboxImages::where('lightbox_id','=',$lightbox_id)->where('image_id','=',$image_id)->get()->toArray();
				if(count($lightbox_images)==0)
				{
					//Add to Lightbox-Images table
					$data = LightboxImages::create(array(
							'lightbox_id' 	=> $lightbox_id,
							'image_id' 	=> $image_id
					));
				}else{
					$data = true;
				}

				if($data)
				{
					return Response::json(['result'=>'success', 'message'=>'Added to your lightbox successfully.']);
				}
				else
				{
					return Response::json(['result'=>'failed', 'message'=>'Sory, could not add to your lightbox.']);
				}
			}
			else
			{
				return Response::json(['result'=>'failed', 'message'=>'Please login first.']);
			}
		}
		return Redirect::route('home');
	}

	public function addToLightboxByName($image_id,$name_lightbox){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$lightbox = Lightbox::where('name','=',$name_lightbox)->where('user_id','=',Auth::user()->get()->id)->get()->toArray();
				if(count($lightbox)==0)
				{
					//Add to Lightbox-Images table
					$lightbox = new Lightbox;
					$lightbox->user_id = Auth::user()->get()->id;
					$lightbox->name = $name_lightbox;
					$lightbox->save();
					$lightbox_id = $lightbox->id;
				}
				else{
					$lightbox_id = $lightbox['id'];
				}


				$lightbox_images = LightboxImages::where('lightbox_id','=',$lightbox_id)->where('image_id','=',$image_id)->get()->toArray();
				$count = count($lightbox_images);
				if($count==0)
				{
					//Add to Lightbox-Images table
					$data = LightboxImages::create(array(
							'lightbox_id' 	=> $lightbox_id,
							'image_id' 	=> $image_id
					));

				}else{
					$data = true;
				}

				if($data)
				{
					return Response::json(['result'=>'success', 'message'=>'Added to your lightbox successfully.', 'count'=>$count]);
				}
				else
				{
					return Response::json(['result'=>'failed', 'message'=>'Sory, could not add to your lightbox.']);
				}
			}
			else
			{
				//Not Login, add by ip address
				$client_ip = Request::server('REMOTE_ADDR');

				$lightbox = Lightbox::where('name','=',$client_ip)->first();
				if(!$lightbox)
				{
				//Add to Lightbox table
					$lightbox = new Lightbox;
					$lightbox->user_id = 0;
					$lightbox->name = $client_ip;
					$lightbox->save();
					
				}
				$lightbox_id = $lightbox->id;
	
				$count = Lightbox::select('lightbox.name')
											->join('lightbox_images', 'lightbox_images.lightbox_id', '=', 'lightbox.id')
											->where('lightbox.name','=',$client_ip)
											->where('lightbox_images.image_id','=',$image_id)
											->get()->count();
				if($count == 0)
				{
					//Add to Lightbox-Images table
					$data = LightboxImages::create(array(
							'lightbox_id' 	=> $lightbox_id,
							'image_id' 	=> $image_id
					));
				}
				return Response::json(['result'=>'success', 'case'=>'favorites', 'count'=>$count]);				
				//return Response::json(['result'=>'failed', 'message'=>'Please login first.']);
			}
		}
		return Redirect::route('home');
	}

	public function showLightboxs($flag = false)
	{
		if(Auth::user()->check())
		{
			$query = Lightbox::where('user_id', '=', Auth::user()->get()->id);
			$query->orderBy('id', 'desc');
			$data = $query->get();

			$arrlightbox = array();
			if($data->count() > 0)
			{
				$i = 0;
				foreach ($data as $key => $value)
				{
					$arrlightbox[$i]['id'] = $value->id;
					$arrlightbox[$i]['name'] = $value->name;

					$imgdetail = LightboxImages::select('lightbox_images.lightbox_id',
												'images.short_name',
												'lightbox_images.image_id',
												'image_details.width',
												'image_details.height'


						);
					$imgdetail->leftJoin('images', 'images.id', '=', 'lightbox_images.image_id');
					$imgdetail->leftJoin('image_details', 'lightbox_images.image_id', '=', 'image_details.image_id');
					$imgdetail->where('lightbox_images.lightbox_id', '=', $value->id);
					$imgdetail->where('image_details.type', '=', 'main');

					$imageDetail = $imgdetail->first();
					if(is_object($imageDetail))
					{
						$arrlightbox[$i]['path'] = '/pic/thumb/'.$imageDetail->short_name.'-'.$imageDetail->image_id.'.jpg';
						$arrlightbox[$i]['width'] = $imageDetail->width;
						$arrlightbox[$i]['height'] = $imageDetail->height;
					}

					$i++;
				}
			}

			if( Request::ajax() ) {

				$referrer = Request::server('HTTP_REFERER');
				// if(substr($referrer, -13, 13) != "lightbox/show")
				// {
				// 	if(count($arrlightbox) > 5)
				// 	{
				// 		$arrlightbox = array_slice($arrlightbox, 0, 5);
				// 	}
				// }

				$html = View::make('frontend.lightbox.list-lightboxs')->with('arrlightbox', $arrlightbox)->render();
				if($flag)
				{
					return $html;
				}

				$arrReturn = ['status' => 'ok', 'message' => !empty($arrlightbox), 'html'=>$html];

				$response = Response::json($arrReturn);
				$response->header('Content-Type', 'application/json');
				return $response;

			}

			$this->layout->content = View::make('frontend.lightbox.show-lightboxs')
			->with('arrlightbox', $arrlightbox);
			return;

		}
		return Redirect::route('account-sign-in');
		//return App::abort(404);
	}

	public function showLightboxNames()
	{
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$query = Lightbox::where('user_id', '=', Auth::user()->get()->id);
				$data = $query->get();

				$html = "";
				if($data->count() > 0)
				{
					foreach ($data as $key => $value)
					{
						$html .= "<div style='display:inline-block; padding-right:10px; padding-bottom:5px;'><a style='color:blue;' href='#' onclick='addToLightbox(event, \"".$value->id."\")'>".$value->name."</a></div>";
					}
				}
				$arrReturn = ['status' => 'ok', 'message' => "", 'html'=>$html];
				$response = Response::json($arrReturn);
				$response->header('Content-Type', 'application/json');
				return $response;
			}
		}
		return App::abort(404);
	}

	public function deleteLightboxImage($id)
	{
		if( Request::ajax() ) {

			$arrReturn = ['status' => 'error', 'message' => 'Please refresh and try again.'];

			$lightboxImages = LightboxImages::findorFail($id);
			$lightbox_id = $lightboxImages->lightbox_id;

			if($lightboxImages->delete())
			{
				$query = LightboxImages::where('lightbox_id', '=', $lightbox_id);
				$data = $query->get();
				if($data->count() <= 0)
				{
					$lightbox = Lightbox::findorFail($lightbox_id);
					$lightbox->delete();

					$html = $this->showLightboxs(true);
					$arrReturn = ['status' => 'ok', 'message' => "Your lightbox's image has been deleted.", 'html'=>$html];
				}
				else
				{
					return $this->lightboxDetail($lightbox_id);
				}
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return App::abort(404);
	}

	public function lightboxDetail($id)
	{
		if( Request::ajax() )
		{
			$lightboxName = "";
			$lightbox = Lightbox::findorFail($id);
			if($lightbox)
			{
				$lightboxName = $lightbox->name;
			}

			$query = LightboxImages::where('lightbox_id', '=', $id);
			$data = $query->get();

			$arrlightboxImages = array();
			if($data->count() > 0)
			{
				$i = 0;
				foreach ($data as $key => $value)
				{
					$arrlightboxImages[$i]['id'] = $value->id;

					$imgdetail = VIImageDetail::select('image_details.image_id',
														'images.short_name',
														'images.name'
					);

					$imgdetail->leftJoin('images', 'images.id', '=', 'image_details.image_id');
					$imgdetail->where('image_details.image_id', '=', $value->image_id);
					$imgdetail->where('image_details.type', '=', 'main');

					$imageDetail = $imgdetail->first();
					if(is_object($imageDetail))
					{
						$arrlightboxImages[$i]['image_id'] = $imageDetail->image_id;
						$arrlightboxImages[$i]['short_name'] = $imageDetail->short_name;
						$arrlightboxImages[$i]['name'] = $imageDetail->name;
						$arrlightboxImages[$i]['path'] = '/pic/thumb/'.$imageDetail->short_name.'-'.$imageDetail->image_id.'.jpg';
					}

					$i++;
				}
			}

			$html = View::make('frontend.lightbox.show-lightbox-images')->with(['arrlightboxImages'=>$arrlightboxImages, 'lightboxName'=>$lightboxName])->render();
			$arrReturn = ['status' => 'ok', 'message' => '', 'html'=>$html];

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;

		}
		return App::abort(404);
	}

	//load featured lightboxs
	public function loadFeaturedLightbox()
	{
		$collections = Collection::select('id',
						'name as collection_name',
						'short_name as collection_short_name',
						'order_no'
						)
					->rightJoin('collections_images', 'collections_images.collection_id','=','collections.id')
					->orderBy('order_no','desc')
					->groupBy('collections.id')
					->distinct()
					->take(10)
					->get()->toArray();

		foreach ($collections as $key => $value) {
			$image = CollectionImage::where('collection_id','=',$value['id'])
							->where('collections_images.type','=','main')
							->leftJoin('images', 'collections_images.image_id','=','images.id')
							->leftJoin('image_details','image_details.image_id','=','collections_images.image_id')
							->groupBy('collection_id')
							->get()->toArray();
			if(count($image)==0){
				$image = CollectionImage::where('collection_id','=',$value['id'])
							->leftJoin('images', 'collections_images.image_id','=','images.id')
							->leftJoin('image_details','image_details.image_id','=','collections_images.image_id')
							->groupBy('collection_id')
							->get()->toArray();
			}
			$collections[$key]['image'] = count($image)>0?$image[0]:array();
		}
		$arrFeaturedLightbox = array();
		if(count($collections))
		{
			$i = 0;
			foreach ($collections as $value)
			{
				$arrFeaturedLightbox[$i]['collection_id'] = $value['id'];
				$arrFeaturedLightbox[$i]['collection_short_name'] = $value['collection_short_name'];
				$arrFeaturedLightbox[$i]['collection_name'] = $value['collection_name'];
				$arrFeaturedLightbox[$i]['path'] = '/pic/thumb/'.$value['image']['short_name'].'-'.$value['image']['image_id'].'.jpg';
				$arrFeaturedLightbox[$i]['width'] = $value['image']['width'];
				$arrFeaturedLightbox[$i]['height']  = $value['image']['height'];
				$i++;
			}
		}

		if( Request::ajax() ) {
			$html = View::make('frontend.lightbox.featured-lightboxs')->with('arrFeaturedLightbox', $arrFeaturedLightbox)->render();
			$arrReturn = ['status' => 'ok', 'message' => '', 'html'=>$html];

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}

		return View::make('frontend.types.featured-collections')->with('arrFeaturedCollection', $arrFeaturedLightbox)->render();
	}


	public function getLightBoxByUser(){
		if( Request::ajax() )
		{
			$arr_lightbox = Lightbox::select('id','name')->where('user_id','=',Auth::user()->get()->id)->get()->toArray();
			foreach ($arr_lightbox as $key => $value) {
				$arr_lightbox[$key]['total'] = LightboxImages::where('lightbox_id','=',$value['id'])->count();
			}
			$arrReturn = array('result'=>'success', 'lightboxes'=>$arr_lightbox);

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');

	}

	public function getLightbox($id_lightbox){

		$lightbox = Lightbox::findorFail($id_lightbox);
		$image_lightbox = LightboxImages::where('lightbox_id', '=', $id_lightbox)->get();
		$images = array();
		if($image_lightbox->count() > 0)
		{
			$i = 0;
			foreach ($image_lightbox as $key => $value)
			{
				$images[$i]['id'] = $value->id;

				$imgdetail = VIImageDetail::select('image_details.image_id',
													'images.short_name',
													'images.name'
				);

				$imgdetail->leftJoin('images', 'images.id', '=', 'image_details.image_id');
				$imgdetail->where('image_details.image_id', '=', $value->image_id);
				$imgdetail->where('image_details.type', '=', 'main');

				$imageDetail = $imgdetail->first();
				if(is_object($imageDetail))
				{
					$images[$i]['image_id'] = $imageDetail->image_id;
					$images[$i]['short_name'] = $imageDetail->short_name;
					$images[$i]['name'] = $imageDetail->name;
					$images[$i]['path'] = '/pic/thumb/'.$imageDetail->short_name.'-'.$imageDetail->image_id.'.jpg';
				}

				$i++;
			}
		}
		if( Request::ajax() )
		{
			$response = Response::json(array('images'=>$images,'lightbox'=>$lightbox));
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		$list_lightbox = Lightbox::where('user_id','=',Auth::user()->get()->id)
						->where('id','<>',$id_lightbox)
						->orderBy('name')
						->get()->toArray();
		$this->layout->content = View::make('frontend.lightbox.lightbox-detail')->with([
													'images'=>$images,
													'lightbox'=>$lightbox,
													'list_lightbox'=>$list_lightbox
												]);
	}

	public function renameLightBox(){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				if(Input::has('name') && Input::get('name')!= ''){
					$name =  Input::get('name');
					$check = Lightbox::where('name','=',$name)
								->where('user_id','=',Auth::user()->get()->id)
								->count();
					if($check){
						$arrReturn = array('result'=>'failed', 'message'=>'Lightbox with name '.$name.' existed. Please enter different name');
					}else{
						$id = Input::has('id')?Input::get('id'):0;
						$check = Lightbox::where('id','=',$id)
								->where('user_id','=',Auth::user()->get()->id)
								->count();
						if($check){
							$lightbox = Lightbox::findorFail($id);
							$lightbox->name = $name;
							$lightbox->save();
							$arrReturn = array('result'=>'success');
						}else{
							$arrReturn = array('result'=>'failed', 'message'=>'You do not have permission to edit this lightbox.');
						}
					}
				}else{
					$arrReturn = array('result'=>'failed', 'message'=>'Please enter new name.');
				}
			}
			else
			{
				$arrReturn = array('result'=>'failed', 'message'=>'Please login first.');
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');
	}

	public function deleteImageLightBox(){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$id = Input::has('id')?Input::get('id'):0;
				$check = Lightbox::where('id','=',$id)
						->where('user_id','=',Auth::user()->get()->id)
						->count();
				if($check){
					$list_image = Input::has('list_image')?Input::get('list_image'):array();
					$delete = LightboxImages::whereIn('image_id',$list_image)
									->where('lightbox_id','=',$id)->delete();
					$arrReturn = array('result'=>'success' , 'message'=>$delete);
				}else{
					$arrReturn = array('result'=>'failed', 'message'=>'You do not have permission to edit this lightbox.');
				}

			}
			else
			{
				$arrReturn = array('result'=>'failed', 'message'=>'Please login first.');
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');
	}

	public function deleteLightBox(){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$id = Input::has('id')?Input::get('id'):0;
				$check = Lightbox::where('id','=',$id)
						->where('user_id','=',Auth::user()->get()->id)
						->count();
				if($check){
					$delete = Lightbox::where('id',$id)->delete();
					$arrReturn = array('result'=>'success' , 'message'=>$delete);
				}else{
					$arrReturn = array('result'=>'failed', 'message'=>'You do not have permission to delete this lightbox.');
				}

			}
			else
			{
				$arrReturn = array('result'=>'failed', 'message'=>'Please login first.');
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');
	}


	public function copyImageLightBox(){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$id = Input::has('id')?Input::get('id'):0;
				$check = Lightbox::where('id','=',$id)
						->where('user_id','=',Auth::user()->get()->id)
						->count();
				if($check){
					$list_image = Input::has('list_image')?Input::get('list_image'):array();
					foreach ($list_image as $key => $image) {
						$check = LightboxImages::where('image_id','=',$image)
							->where('lightbox_id','=',$id)
							->count();
						if($check==0){
							$lightbox_image = new LightboxImages;
							$lightbox_image->lightbox_id = $id;
							$lightbox_image->image_id = $image;
							$lightbox_image->save();
						}

					}
					$arrReturn = array('result'=>'success');
				}else{
					$arrReturn = array('result'=>'failed', 'message'=>'You do not have permission to edit this lightbox.');
				}

			}
			else
			{
				$arrReturn = array('result'=>'failed', 'message'=>'Please login first.');
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');
	}

	public function moveImageLightBox(){
		if( Request::ajax() )
		{
			if(Auth::user()->check())
			{
				$id = Input::has('id')?Input::get('id'):0;

				$old_id = Input::has('old_id')?Input::get('old_id'):0;
				$check = Lightbox::where('id','=',$id)
						->where('user_id','=',Auth::user()->get()->id)
						->count();
				if($check){
					$list_image = Input::has('list_image')?Input::get('list_image'):array();
					foreach ($list_image as $key => $image) {
						$check = LightboxImages::where('image_id','=',$image)
							->where('lightbox_id','=',$id)
							->count();
						if($check==0){
							LightboxImages::where('image_id','=',$image)
									->where('lightbox_id','=',$old_id)
									->update(array('lightbox_id' => $id));
						}else{
							LightboxImages::where('image_id','=',$image)
									->where('lightbox_id','=',$id)
									->delete();
						}
					}
					$arrReturn = array('result'=>'success');
				}else{
					$arrReturn = array('result'=>'failed', 'message'=>'You do not have permission to edit this lightbox.');
				}

			}
			else
			{
				$arrReturn = array('result'=>'failed', 'message'=>'Please login first.');
			}

			$response = Response::json($arrReturn);
			$response->header('Content-Type', 'application/json');
			return $response;
		}
		return Redirect::route('home');
	}
}
