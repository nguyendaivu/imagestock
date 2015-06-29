@if (Auth::user()->check())
			@if(isset($arrlightbox) && count($arrlightbox)>0)
				@foreach($arrlightbox as $lightbox)
					@if (isset($lightbox['path'])) 
					<div style="display:inline-block" style="text-align:center">

				                    <div class="text-center" style="  overflow: hidden;  position: relative;  width: 115px;  height: 115px; margin:auto;">
				                        <a rel="recently-search-group" href="{{ URL }}/lightbox/{{ $lightbox['id'] }}" title="{{ $lightbox['name'] }}">
				                            <img alt="" src="{{URL}}{{ $lightbox['path'] }}" style="{{$lightbox['width']>$lightbox['height']?'height:100%':'width:100%'}}" />
				                        </a>
				                    </div>
				                    <div class="text-center" id="div-lightbox-search" style=' margin:auto;'>
				                    	<a href="{{ URL }}/lightbox/{{ $lightbox['id'] }}" title="{{ $lightbox['name'] }}">
				                   			 {{ $lightbox['name'] }}
				                   		</a>
				                   	</div>
					</div>
					@endif
				@endforeach            	
			@else
				There are no items in your lightbox.
			@endif
@endif          
