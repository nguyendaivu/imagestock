<h1 class="frank light">
	{{ $collection['name'] }} <span>Collection</span>
</h1>
<div class="container" id="grid-image">
	@foreach($collection['images'] as $image)
	<div class="item inline">
		<a href="{{ URL.'/pic-'.$image['id'].'/'.$image['short_name'].'.html' }}" title="{{ $image['name'] }}">
			<img title="{{ $image['name'] }}" alt="{{ $image['name'] }}" src="{{ $image['path'] }}" height="{{ $image['height'] }}" width="{{ $image['width'] }}"/>
		</a>
	</div>
	@endforeach
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{URL}}/assets/css/style.css">
@stop
@section('pageJS')
<script src="{{URL}}/assets/global/plugins/rowgrid/row-grid.js" type="text/javascript" charset="utf-8" ></script>
<script type="text/javascript">
var options = {minMargin: 10, maxMargin: 15, itemSelector: ".item"};
$("#grid-image").rowGrid(options);
</script>
@stop