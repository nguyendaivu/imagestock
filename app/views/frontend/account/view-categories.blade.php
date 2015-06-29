@if(count($categories)>0)
	  
			<?php
				$per_col = round(count($categories)/4);
			?>
			@foreach($categories as $key => $category)
			@if($key%$per_col==0)
			<ul class="col-md-3  col-sm-6  col-xs-6 list-unstyled">
			@endif
			<li><a href="{{ URL }}/cat-{{ $category['short_name'] }}-{{ $category['id'] }}.html" title="{{ $category['name'] }}">{{ $category['name'] }}</a> </li>
			@if($key%$per_col==$per_col -1)
			</ul>
			@endif
			@endforeach
@endif