@if (Auth::user()->check())

    @if(isset($arrRecentlyViewImages) && count($arrRecentlyViewImages)>0)
        @foreach($arrRecentlyViewImages as $recentlyViews)
            @if (isset($recentlyViews['path'])) 
            <div style="display:inline-block" style="text-align:center">
                    <div class="text-center" style="  overflow: hidden;  position: relative;  width: 115px;  height: 115px; margin:auto;">
                        <a href="{{URL}}/pic-{{ $recentlyViews['image_id'] }}/{{ $recentlyViews['short_name'] }}.html" title="{{ $recentlyViews['name'] }}">
                            <img alt="" src="{{URL}}{{ $recentlyViews['path'] }}" style="{{$recentlyViews['width']>$recentlyViews['height']?'height:100%':'width:100%'}}" />
                        </a>
                    </div>
            </div>
            @endif
        @endforeach            	
    @else
        There are no recently viewed.
    @endif

@endif          
