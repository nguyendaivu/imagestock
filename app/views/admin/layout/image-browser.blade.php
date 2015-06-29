<div id="image-modal" class="modal fade" tabindex="-1">
	<div class="navigation">
		<a href="{{ URL.'/admin/'.$controller.'/image-browser/1/?_token='.csrf_token() }}"></a>
	</div>
	<div id="image-content"></div>
	<div class="loading-message"></div>
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css' ) }}" />
<style type="text/css">
.bootbox-confirm{
	background: none !important;
	box-shadow:  none !important;
	border: none !important;
	width: auto !important;
}
#image-modal {
	height: 465px !important;
	overflow-y: hidden !important;
}
#image-modal #image-content {
	position: absolute;
	width: 100%;
	margin-top: 25px;
	padding-bottom: 25px;
	overflow-y: scroll;
	height: 400px !important;
}
#image-modal .loading-message {
	z-index: 99999;
	position: fixed;
	background-color: #fff;
	-moz-border-radius: 4px !important;
	-webkit-border-radius: 4px !important;
	border-radius: 4px !important;
}
#image-modal li {
	background-color: #ffffff;
	-moz-border-radius: 4px !important;
	-webkit-border-radius: 4px !important;
	border-radius: 4px !important;
	padding: 5px;
	border: 1px solid #dedede;
	list-style-type: none;
}
</style>
@append
@section('pageJS')
<script src="{{ URL::asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/bootstrap-modal/js/bootstrap-modal.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-wookmark/jquery.wookmark.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/plugins/jquery-infinitescroll/jquery.infinitescroll.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">

$("input[type=file]", "{{ $holder }}").change(function(){
    restoreImageState(this);
});
$("a[data-dismiss=fileinput]", "{{ $holder }}").change(function(){
    restoreImageState(this);
});

$.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner =
  '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
    '<div class="progress progress-striped active">' +
      '<div class="progress-bar" style="width: 100%;"></div>' +
    '</div>' +
  '</div>';

$.fn.modalmanager.defaults.resize = true;

var modal = $("#image-modal");
var currentObject;
var imagePath = "{{ $imagePath or URL.'/assets/images/' }}";

function imageAppend(result, page)
{
	var html, i;
	modal.attr("data-page", page++);
	html = "";
	for( i in result ) {
		html += [
			"<li>",
				'<a data-id="'+i+'" href="javascript:void(0)" onclick="chooseImage(this)">',
					'<img src="'+imagePath+'/'+result[i].type+'/'+result[i].f+'" width="'+result[i].w+'" height="'+result[i].h+'" />',
				'</a>',
			"</li>",
		].join("");
	}
	$("#image-content").append(html);
	modal.modal({
		width : "{{ $modalWidth or 70 }}%"
	});
	$("li", "#image-content").wookmark({
		container: $("#image-content"),
		itemWidth: {{ $itemWidth or 210}}
	});
}

function openImage(object)
{
	type = $('[ name="type"]').val();
	switch(type){
		case 'Product': 
			type='products';
			break;
		case 'Banner':
			type='banners';
			break;
		case 'ProductCategory':
			type='product_categories';
			break;
		case 'User':
			type='users';
			break;
		case 'Admin':
			type='admins';
			break;
	}
	currentObject = object;
	$("body").modalmanager("loading");
	var page = 1;
	if(modal.attr("data-type")!=type){
		$('#image-content').data('infinitescroll', null);
		modal.attr("data-type",type);
		modal.attr("data-page",1);
		$("#image-content").html('');
	}
	if( modal.attr("data-page") ) {
		page = parseInt(modal.attr("data-page"));
	}
	if( $("li", "#image-content").length ) {
		modal.modal({
	      			width : "{{ $modalWidth or 70 }}%"
	      		});
	} else {
		@if($controller=='images')
			url = "{{ URL.'/admin/'.$controller.'/image-browser' }}/"+page + "/"+type+"?_token={{ csrf_token() }}"
			path = ["{{ URL.'/admin/'.$controller.'/image-browser/' }}", "/"+type+"?_token={{ csrf_token() }}"],
		@else
			url = "{{ URL.'/admin/'.$controller.'/image-browser' }}/"+page+"?_token={{ csrf_token() }}"
			path = ["{{ URL.'/admin/'.$controller.'/image-browser/' }}", "?_token={{ csrf_token() }}"]
		@endif
		$.ajax({
			url: url,
			success: function(result) {
				imageAppend(result, page);
				$("#image-content ").infinitescroll({
					binder: $("#image-content"),
					dataType: 'json',
					appendCallback: false,
					debug: false,
					pixelsFromNavToBottom: $("#image-content").height(),
					navSelector : "#image-modal  .navigation",
					nextSelector: "#image-modal  .navigation > a:first",
					extraScrollPx: 10,
					path: path,
					loading: {
						msgText: "<em>Loading the next set of images...</em>",
    					finishedMsg: "<em>All images were loaded.</em>",
						selector: "#image-modal .loading-message"
					}
				}, function(result, opts) {
					var page = opts.state.currPage;
					imageAppend(result, page);
				});
			}

		})
	}
}
</script>
@append