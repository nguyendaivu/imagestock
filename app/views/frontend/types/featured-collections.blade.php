
<div id="featured-collections">
    <h2 class="hc1 abel" style="margin-bottom:20px;">Featured Photo Collections</h2>
    @for($i=0; $i<8; $i++)
    	@if (isset($arrFeaturedCollection[$i]['path']))
			<div style="display:inline-block; padding:7px 7px 7px 7px;">
                <div>
                    <a href="{{ URL.'/collections/'.$arrFeaturedCollection[$i]['collection_id'].'-'.$arrFeaturedCollection[$i]['collection_short_name'].'.html' }}" title="{{ $arrFeaturedCollection[$i]['collection_name'] }}">
                        <img alt="" src="{{URL}}/{{ $arrFeaturedCollection[$i]['path'] }}" class="img-rounded" style="width:315px" height="165px" />
                    </a>
                </div>
				<div class="collection-link">
                    <a href="{{ URL.'/collections/'.$arrFeaturedCollection[$i]['collection_id'].'-'.$arrFeaturedCollection[$i]['collection_short_name'].'.html' }}" title="{{ $arrFeaturedCollection[$i]['collection_name'] }}">{{ $arrFeaturedCollection[$i]['collection_name'] }} </a>
                </div>
			</div>
        @else
            <div style="display:inline-block; padding:7px 7px 7px 7px;">
            	<div>
                    <a href="#">
                    <img class="img-rounded" alt="120x120" src="{{URL}}/assets/images/noimage/315x165.gif" style="width: 315px; height: 165px;">
                	</a>
                </div>
                <div class="collection-link">No collections</div>
            </div>
        @endif
    @endfor

</div>
