@if (Auth::user()->check())

        @if(isset($arrRecentlySearchImages) && count($arrRecentlySearchImages)>0)
            @foreach($arrRecentlySearchImages as $recentlySearchImages)
            	@if (isset($recentlySearchImages['path'])) 
				<div style="display:inline-block" style="text-align:center">

                    <div class="text-center" style="  overflow: hidden;  position: relative;  width: 115px;  height: 115px; margin:auto;">
                        <a rel="recently-search-group" href="{{ $recentlySearchImages['query'] }}" title="{{ $recentlySearchImages['keyword'] }}">
                            <img alt="" src="{{URL}}{{ $recentlySearchImages['path'] }}" style="{{$recentlySearchImages['width']>$recentlySearchImages['height']?'height:100%':'width:100%'}}" />
                        </a>
                    </div>

                    <div class="text-center" id="div-lightbox-search" style=' margin:auto;'><a href="{{ $recentlySearchImages['query'] }}">{{ $recentlySearchImages['keyword'] }}</a></div>


				</div>
                @endif
            @endforeach            	
        @else
        	There are no recently searched.
        @endif

@endif          
