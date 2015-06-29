@for($i=0; $i < 10; $i++)
	@if(isset($arrFeaturedLightbox[$i]['path'])) 
		<div style="display:inline-block" style="text-align:center">
			<div class="text-center" style="  overflow: hidden;  position: relative;  width: 115px;  height: 115px; margin:auto;">
				<a href="{{ URL.'/collections/'.$arrFeaturedLightbox[$i]['collection_id'].'-'.$arrFeaturedLightbox[$i]['collection_short_name'].'.html' }}" title="{{ $arrFeaturedLightbox[$i]['collection_name'] }}">
					<img alt="" src="{{URL}}{{ $arrFeaturedLightbox[$i]['path'] }}" style="{{$arrFeaturedLightbox[$i]['width']>$arrFeaturedLightbox[$i]['height']?'height:100%':'width:100%'}}" />
				</a>
			</div>
			<div class="text-center" id="div-lightbox-search" style=' margin:auto;'><a href="{{ URL.'/collections/'.$arrFeaturedLightbox[$i]['collection_id'].'-'.$arrFeaturedLightbox[$i]['collection_short_name'].'.html' }}">{{ $arrFeaturedLightbox[$i]['collection_name'] }}</a></div>
		</div>

	@else		
		<div style="display:inline-block" style="text-align:center">
			<div class="text-center" style="  overflow: hidden;  position: relative;  width: 115px;  height: 115px; margin:auto;">
				<a href="#" title="">
					<img data-src="holder.js/120x120" class="" alt="120x120" src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjxkZWZzLz48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQ1LjUiIHk9IjcwIiBzdHlsZT0iZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQ7ZG9taW5hbnQtYmFzZWxpbmU6Y2VudHJhbCI+MTQweDE0MDwvdGV4dD48L2c+PC9zdmc+" data-holder-rendered="true" style="width: 100%; height: 100%;"> 
				</a>
			</div>
			<div class="text-center" id="div-lightbox-search" style=' margin:auto;'><a href="#">&nbsp;</a></div>
		</div>

	@endif
@endfor
