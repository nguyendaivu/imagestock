<div class="container">
	@if(count($lightboxes)>0)
	<h3 class="container" >Lightboxes ({{count($lightboxes)}})</h3>
	<div class="container" id="list_lightbox">
		@foreach($lightboxes as $lightbox)
			<a href="{{URL}}/lightbox/{{$lightbox['id']}}">
				<div class="item_lightbox">
					<img src="{{URL.$lightbox['path']}}" alt="{{$lightbox['name']}}">
				</div>
				<div class="text-center name_lightbox">
					{{$lightbox['name']}}
				</div>
			</a>
		@endforeach
	</div>
	@else
	<div class="text-center" style="height:300px;vertical-align: bottom;padding-top: 150px;">
		<h4>Lightboxes allow you to categorize groups of photos and send them to your friends or colleagues.</h4>
		Create your first Lightbox by finding an image and clicking the <strong>"Add to Lightbox"</strong> icon beneath it.
	</div>
	@endif
</div>
@section('pageCSS')
	<style type="text/css" media="screen">
		#list_lightbox a{
			width: 150px;
			height:auto;
			float: left;
			margin: 10px;
		}
		.item_lightbox{
			width:150px;
			line-height: 150px;
			vertical-align: middle;
			display: table-cell;
			text-align: center;
		}
		.name_lightbox{
			width:150px;
		}
	</style>
@stop
@section('pageJS')
@stop