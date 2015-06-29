<!-- BEGIN PAGE HEADER-->
<h3 class="page-title">
{{ $title or '' }}
</h3>
@if( !isset($pageBar) || $pageBar  )
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<i class="fa fa-home"></i>
			<a href="{{ URL.'/admin' }}">{{ 'Home' }}</a>
		</li>
		<?php
			$segments = Request::segments();
			$count = count($segments);
		?>
		@if($count > 1)
			@for($i = 1; $i < $count; $i++)
			<?php if(is_numeric($segments[$i])) continue; ?>
		<li>
			<i class="fa fa-angle-right"></i>
			<a href="{{ $i == $count - 1 || (isset($segments[($i + 1)]) && is_numeric($segments[($i + 1)]) ) ? '' : URL.'/admin/'.$segments[$i] }}">{{ ucfirst(str_replace('-',' ',$segments[$i])) }}</a>
		</li>
			@endfor
		@endif
	</ul>
	<div class="page-toolbar">
	@yield('pageAction')
	</div>
</div>
@endif
<!-- END PAGE HEADER-->