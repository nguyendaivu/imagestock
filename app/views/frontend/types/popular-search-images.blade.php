<div id="popular-search-images">
    @for($i=0; $i<8; $i++)
    	@if (isset($arrPopularSearchImages[$i]['path'])) 
			<div class="thumb-box-collection-4">
                  <a href="{{URL}}{{ $arrPopularSearchImages[$i]['query'] }}">
                      <!-- <img src="{{URL}}/assets/upload/images/96/8aa5fb8747a64d24f0719be05914a5d7.jpg" alt="{{ $arrPopularSearchImages[$i]['keyword']}}" /> -->
                      <img src="{{URL}}{{ $arrPopularSearchImages[$i]['path']}}" alt="{{ $arrPopularSearchImages[$i]['keyword']}}" />
                      <div class="box-overlay">
                        <span>
                            <span class="glyphicon glyphicon-search"></span>
                            {{ ucfirst($arrPopularSearchImages[$i]['keyword']) }}
                        </span>
                      </div>
                  </a>
			</div>
        @else
            <div class="pdf-thumb-box">
                <div>
                    <a href="#">
                        <img alt="120x120" src="{{URL}}/assets/images/noimage/no_image.gif" style="width: 215px; height: 215px;">          
                    </a>
                </div>
            </div>
        @endif
    @endfor            	
</div>

<div class="panel-body" style="display:table; width:100%">
	<div class="col-xs-4 col-md-4 text-left">
        <h2 class="abel hc1" style="margin-top: 0;  margin-left: 3%;">Popular Photo Searches</h2>
    </div>
    <div class="col-xs-8 col-md-8 category-list">
    <div>
		<?php 
            $per_col= round(count($arrKeywords)/4);
			if($per_col==0) $per_col=1;
        ?>
        @foreach($arrKeywords as $key => $keyword)
            @if($key%$per_col==0)
            <ul class="col-md-3 col-xs-6 list-unstyled">
            @endif
                <li style="padding-bottom:5px" class="text-left">{{ $key+1 }}. <a href="{{ URL }}{{ $keyword['query'] }}" title="{{ $keyword['keyword'] }}">{{ $keyword['keyword'] }}</a> </li>
            @if($key%$per_col==$per_col -1)
            </ul>
            @endif
        @endforeach
    </div>
    </div>
</div>

