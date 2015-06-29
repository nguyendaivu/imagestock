@section('body')
<body class="page-header-fixed page-header-fixed-mobile page-quick-sidebar-over-content page-style-square   pace-done page-sidebar-closed">
@stop
@section('sideMenu')
<ul id="sidebar-menu" class="page-sidebar-menu page-sidebar-menu-closed {{ isset($currentTheme['sidebar']) && $currentTheme['sidebar'] == 'fixed' ? 'page-sidebar-menu-fixed' : 'page-sidebar-menu-default' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
@stop
@section('pageAction')
<div class="btn-group pull-right">
	<button id="add-image" type="button" class="btn btn-fit-height blue" >
	{{ 'Add Image' }}
	</button>
</div>
@stop
<div id="navigation">
	<a href="{{ URL.'/admin/images/?page='.$pageNum.'&_token='.csrf_token() }}"></a>
</div>
<div class="row" >
	<div class="col-md-2" id="filters" >
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" href="#name-div">
				<h4 class="panel-title">
				<a class="accordion-toggle">
				Name / Keywords </a>
				</h4>
			</div>
			<div id="name-div" class="panel-collapse in">
				<div class="panel-body">
					<input type="text" class="form-control" name="name" value="{{ $name }}" placeholder=" name/keywords/description " />
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" href="#categories-div">
				<h4 class="panel-title">
				<a class="accordion-toggle">
				Categories </a>
				</h4>
			</div>
			<div id="categories-div" class="panel-collapse in">
				<div class="panel-body">
					<div class="input-group">
						<div class="icheck-list">
						    @if( isset($categories) )
						    @foreach($categories as $category)
						    @if( $category['value'] )
							<label>
						    <input type="checkbox" class="category-checkbox icheck" @if( in_array($category['value'], $arrCategories) ) checked @endif  name="categories[]" value="{{ $category['value'] }}" />{{ $category['text'] }}
							</label>
						    @endif
						    @endforeach
						    @endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-10" >
		<div id="image-container">
			@foreach($images as $image)
		  	<img class="item" src="{{ $image['path'] }}" data-href="{{ $image['path'] }}" data-thumbnail="{{ $image['path'] }}" title="{{ $image['name'] }}@if( $image['new'] ) <span class='badge badge-danger'>New</span>@endif" data-toggle="tooltip" data-id="{{ $image['id'] }}"/>
			@endforeach
		</div>
	</div>
</div>
<div id="collection-add-popover" style="display: none;">
	<div class="form-group">
		<div class="editable-input" style="position: relative;">
			<input type="text" name="collection_name" class="input-medium" style="padding-right: 24px;">
			<span class="editable-clear-x">
			</span>
		</div>
		<div class="editable-buttons">
			<a class="btn blue editable-submit">
				<i class="fa fa-check"></i>
			</a>
			<a class="btn default editable-cancel">
				<i class="fa fa-times"></i>
			</a></div>
		</div>
		<div class="editable-error-block help-block" style="display: none;"></div>
	</div>
</div>
<div id="info-editor" class="modal" style="z-index: 1000000;">
	<div class="modal-content" style="top: 12%; width: 80%; left: 10%; position: absolute; z-index: 1000000;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Image Info</h4>
		</div>
		<div class="modal-body form">
			<form method="POST" action="javascript:void(0)" accept-charset="UTF-8" id="image-form" class="form-horizontal form-row-seperated" enctype="multipart/form-data" novalidate="novalidate">
				<div class="alert alert-danger display-hide">
				    <button class="close" data-close="alert"></button>
				    <div id="content-message">
				    	<i class="fa-lg fa fa-warning"></i>
				        You have some form errors. Please check below.
				    </div>
				</div>
				<div class="tabbable">
					<ul class="nav nav-tabs">
						<li class="active">
							<a href="#general" data-toggle="tab">
							General </a>
						</li>
						<li>
							<a href="#other" data-toggle="tab">
							Other </a>
						</li>
					</ul>
					<div class="tab-content no-space" style="min-height: 310px;">
						<div class="tab-pane active" id="general">
							<div class="form-group">
								<input type="hidden" name="id" value="0" />
								<label class="col-md-2 control-label">Name</label>
								<div class="col-md-10">
									<input type="text" name="name" value="" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Description</label>
								<div class="col-md-10">
									<textarea type="text" name="description" value="" class="form-control"/>
									</textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-md-6" id="img-tab">
										<label class="col-md-4 control-label">Image</label>
										<div class="col-md-8">
			                                <div class="fileinput fileinput-new" data-provides="fileinput">
			                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
			                                        <img id="preview-img" data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}"/>
			                                    </div>
			                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;">
			                                    </div>
			                                    <div>
			                                        <span class="btn default btn-file">
			                                            <span class="fileinput-new">
			                                            	Select Image
			                                        	</span>
			                                            <span class="fileinput-exists">
			                                            	Change
			                                        	</span>
			                                            <input name="image" id="file" accept="image/*" type="file">
			                                            <input name="choose_image" type="hidden" value="" />
			                                            <input name="choose_name" type="hidden" value="" />
			                                        </span>
		                                        	<a href="javascript:void(0)" class="btn green fileinput-new" id="choose-image"  data-toggle="popover">Choose</a>
			                                        <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
			                                        Remove </a>
			                                    </div>
			                                </div>
										</div>
									</div>
									<div class="col-md-6">
										<label class="col-md-2 control-label">Keywords</label>
										<div class="col-md-10">
											<input type="text" name="keywords" value="" class="form-control tags"/>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Category</label>
								<div class="col-md-10">
									<select class="form-control" id="categories" multiple name="category_id[]">
										@foreach($categories as $category)
						   			 	@if( $category['value'] )
										<option value="{{ $category['value'] }}">{{ $category['text'] }}</option>
										@endif
										@endforeach
									</select>
								</div>
							</div>
						</div>
						<div class="tab-pane" id="other">
							<div class="form-group">
								<label class="col-md-2 control-label">Collection</label>
								<div class="col-md-10">
									<div class="col-md-8">
										<select class="form-control" id="collections" multiple name="collection_id[]">
											@foreach($collections as $collection)
							   			 	@if( $collection['value'] )
											<option value="{{ $collection['value'] }}">{{ $collection['text'] }}</option>
											@endif
											@endforeach
										</select>
									</div>
									<a class="btn btn-primary col-md-2" href="javascript:void(0)" data-toggle="popover" id="add-collection" >Add Collection</a>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Artist</label>
								<div class="col-md-10">
									<input type="text" name="artist" value="" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">Model</label>
								<div class="col-md-10">
									<input type="text" name="model" value="" class="form-control tags"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label">With human</label>
								<div class="col-md-10">
									<input type="checkbox" id="with-human" class="form-control"/>
								</div>
							</div>
							<div class="form-group" id="with-human-div" style="display: none;">
								<div class="row">
									<div class="col-md-6">
										<label class="col-md-4 control-label">Gender</label>
										<div class="col-md-8">
											<select name="gender" class="form-control">
												<option value="any">Any</option>
												<option value="men">Men</option>
												<option value="women">Women</option>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<label class="col-md-2 control-label">No of people</label>
										<div class="col-md-10">
												<input type="number" name="number_people" value="" class="form-control "/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<label class="col-md-4 control-label">Age from</label>
										<div class="col-md-8">
												<input type="number" name="age_from" value="" class="form-control "/>
										</div>
									</div>
									<div class="col-md-6">
										<label class="col-md-2 control-label">Age to</label>
										<div class="col-md-10">
												<input type="number" name="age_to" value="" class="form-control "/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="submit" style="display: none;" />
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default btn-close">Close</button>
			<button type="button" id="info-submit" class="btn btn-primary"><i class="fa fa-check"></i>Save change</button>
		</div>
	</div>
</div>
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-use-bootstrap-modal="false" data-hide-page-scrollbars="false" data-thumbnail-indicators="true" data-toggle-slideshow-on-space="false">
    <div class="slides"></div>
    <div class="infomation" contenteditable="false">
    	<div class="icon">
    		<span class="glyphicon glyphicon-info-sign"></span>
    	</div>
    	<div class="content_info">
        	<p>
    			<span class="label">ID:</span>
    			<span class="content id">1</span>
    		</p>
    		<p>
    			<span class="label">Author:</span>
    			<span class="content author">Author name</span>
    		</p>
    		<p>
    			<span class="label">Dimension:</span>
    			<span class="content dimension">400x400</span>
    		</p>
    		<p>
    			<span class="label">Description:</span>
    			<span class="content description">Dolorem ut porro vel beatae sint et omnis. Et vel</span>
    		</p>
    		<p>
    			<span class="label">Keyword:</span>
    			<span class="content keywords">nihil, sunt, nemo, reprehenderit, eius</span>
    		</p>
    		<p>
    			{{-- <span class="label">Main Color:</span>
    			<span class="content color"></span> --}}
    		</p>
    	</div>
    </div>
    <div class="icon-edit" contenteditable="false">
    		<span class="glyphicon glyphicon-cog"></span>
    	</div>
    <h3 class="title"></h3>
    <p class="description"></p>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/icheck/skins/all.css' ) }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-image-gallery/bootstrap-image-gallery.min.css' ) }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-image-gallery/blueimp-gallery.min.css' ) }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/jquery-tags-input/jquery.tagsinput.css' ) }}">
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}" />
<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >

<style type="text/css">
#categories-div label {
	font-size: 12px !important;
}
#image-container {
	width: 99%;
}
#image-container > .item {
	width: 15.5%;
	margin: 0.15%;
}
#blueimp-gallery .slide .info {
	display: none;
	top: 5%;
	left: 30%;
	width: 40%;
  	background: none !important;
}
.blueimp-gallery>.infomation{
	position: absolute;
	top: 45px;
	left: 15px;
	margin: 0 40px 0 0;
	line-height: 30px;
	color: #fff;
	text-shadow: 0 0 2px #000;
	opacity: .8;
	width:20%;
	height: 30%;
}
.blueimp-gallery>.infomation .icon{
	cursor: pointer;
	position: absolute;
	top: 100%;

}
.blueimp-gallery>.icon-edit{
	position: absolute;
	top: 50%;
	left: 15px;
	margin: 0 40px 0 0;
	line-height: 30px;
	color: #fff;
	text-shadow: 0 0 2px #000;
	opacity: .8;
	cursor: pointer;
}
.blueimp-gallery>.infomation .icon span,
.blueimp-gallery>.icon-edit span{
	font-size: 2em !important;
}
.blueimp-gallery>.infomation .content_info{
	display: none;
	-webkit-animation-duration: 1s;
	animation-duration: 1s;
	-webkit-animation-fill-mode: both;
	animation-fill-mode: both;
}
.blueimp-gallery>.infomation .content_info .label{
	font-weight: 600;
	padding: 3px 3px 3px 0;
}
.blueimp-gallery>.infomation .content_info .color{
	width: 20px;
	height: 13px;
	display: inline-block;
	background: #f00;
}
@-webkit-keyframes fadeOutLeft {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}

@keyframes fadeOutLeft {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }
}
.fadeOutLeft{
	-webkit-animation-name: fadeOutLeft;
	animation-name: fadeOutLeft;
}
@-webkit-keyframes fadeInLeft {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }

  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}

@keyframes fadeInLeft {
  0% {
    opacity: 0;
    -webkit-transform: translate3d(-100%, 0, 0);
    transform: translate3d(-100%, 0, 0);
  }

  100% {
    opacity: 1;
    -webkit-transform: none;
    transform: none;
  }
}
.fadeInLeft{
	-webkit-animation-name: fadeInLeft;
	animation-name: fadeInLeft;
}
.select2-drop {
	z-index: 1000000;
}

.list-image {
	overflow-y: scroll;
	overflow-x: hidden;
	border: 1px solid #ddd;
	height: 350px;
}

.list-image .block-img {
  	display: table-cell;
	width: 12%;
	text-align: center;
	vertical-align: middle;
	float: left;
	overflow: hidden;
}

.list-image .block-img img {
	text-align: center;
	cursor: pointer;
	max-height: 130px;
	max-width: 100%;
	min-width: 50%;
	margin: 2px;
}

.list-image .block-img .block-name {
	background: #33e;
	height: 130px;
	color: #fff;
	margin: 2px;
	font-weight: bold;
	cursor: pointer;
	padding-top: 45px;
}

.list-image .block-img .block-number {
	opacity: 0.1;
	font-size: 5em;
	margin-top: -45%;
}

.list-image .block-img .other {
	background: #fff;
	font-weight: normal;
	cursor: default;
	color: #000;
	border: solid 1px #000;
	word-break: break-word;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/icheck/icheck.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/masonry/masonry.pkgd.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/masonry/imagesloaded.pkgd.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-image-gallery/jquery.blueimp-gallery.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-image-gallery/bootstrap-image-gallery.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-infinitescroll/jquery.infinitescroll.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
<script type="text/javascript" src="//js.live.net/v5.0/wl.js"></script>
<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="{{ $apiKey['api_dropbox'] or '' }}"></script>
<script type="text/javascript">
var currPage = {{ $pageNum }};
var container = $('#image-container');
var imgObj = {{ json_encode($images) }};
var socials = {
				g:
					{
						CLIENT_ID: '{{ $apiKey['api_google_drive'] or '' }}',
						SCOPES: 'https://www.googleapis.com/auth/drive https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/drive.appdata',
						id: 'google-drive',
					  	title: 'Google Drive',
					  	logo: '{{ URL }}/assets/images/others/button-googledrive.png',
					  	thumb: 'thumbnailLink',
					  	link: 'webContentLink',
					 	name: 'originalFilename'
					},
				o:
					{
						CLIENT_ID: '{{ $apiKey['api_sky_drive'] or '' }}',
						SCOPES: ["wl.signin","wl.offline_access","onedrive.readonly","onedrive.readwrite"],
						RESPONSE_TYPE: 'token',
						REDIRECT_URI: '{{ URL }}/admin/images',
						id: 'one-drive',
					  	title: 'One Drive',
					  	logo: '{{ URL }}/assets/images/others/button-skydrive.png',
					  	thumb: '@content.downloadUrl',
					  	link: '@content.downloadUrl',
					 	name: 'name'
					},
				d:
					{
						CLIENT_ID: '{{ $apiKey['api_dropbox'] or '' }}',
						id: 'dropbox',
					  	title: 'DropBox',
					  	logo: '{{ URL }}/assets/images/others/button-dropbox.png',
					}

			};
$('img[data-toggle=tooltip]').tooltip({
	html: true,
	container: 'body'
});
$('#add-collection').popover({
	content: $('#collection-add-popover').html(),
	html: true,
	placement: 'top',
	template: '<div class="popover editable-container editable-popup" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
	trigger: 'click'
}).on('shown.bs.popover', function(){
	$('.editable-container input[type=text]').focus();
});

$('body').on('click', function (e) {
    //did not click a popover toggle or popover
    if ($(e.target).data('toggle') !== 'popover'
        && $(e.target).parents('.popover.in').length === 0) {
       $('[data-toggle=popover]').popover('hide');
    }
});

$('#image-form').on('click', '.editable-cancel', function(){
	$('#image-form input[name=collection_name]').val('');
	$('#image-form .editable-error-block').html('').hide();
    $('#add-collection').popover('hide');
}).on('click', '.editable-clear-x', function(){
	$('#image-form input[name=collection_name]').val('');
	$('#image-form .editable-error-block').html('').hide();
}).on('click', '.editable-submit', function(){
	var name = $('#image-form [name=collection_name]').val();
	if( name == '' ) {
		$('#image-form .editable-error-block').html('Name cannot be empty.').show();
		$('#image-form [name=collection_name]').focus();
	} else {
		$.ajax({
			url: '{{ URL.'/admin/collections/update-collection' }}',
			type: 'POST',
			data: {
				'name': name
			},
			success: function(result) {
				if( result.status == 'ok' ) {
					$('#info-editor #collections').append('<option value="'+ result.data.id +'">'+ result.data.name +'</option>');
					$('#info-editor #collections').selectpicker('refresh');
					$('#image-form input[type=text]').val('');
					$('#image-form .editable-error-block').html('').hide();
        			$('#add-collection').popover('hide');
				} else {
					$('#image-form .editable-error-block').html(result.message).show();
				}
			}
		});
	}
});

$('#with-human').change(function(){
	if( $(this).is(':checked') ) {
		$('#with-human-div').show();
		$(this).parent().addClass('checked');
	} else {
		$('#with-human-div').hide();
		$(this).parent().removeClass('checked');
	}
});


$("#image-form").validate({
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: true,
    ignore: "",
    rules: {
        name: {
            minlength: 6,
            required: true
        },
        description: {
            minlength:3,
            required: true
        },
        keywords: {
            required: true
        },
        'category_id[]': {
            required: true
        }
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#image-form").show();
        Metronic.scrollTo($(".alert-danger","#image-form"), -200);
    },
    highlight: function (element) {
        $(element)
            .closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
        $(element)
            .closest('.form-group').removeClass('has-error');
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error');
    },
    submitHandler: function (form) {
        $(".alert-danger", form).hide();
        updateImage();
    }
});

$('input.tags').tagsInput({
    width: 300
});
$('#info-editor select[multiple]').selectpicker({
    iconBase: 'fa',
    tickIcon: 'fa-check'
});
$("#filters input.icheck").iCheck({
	checkboxClass: 'icheckbox_square-blue',
}).on('ifChanged', function() {
	imageReset();
});
$("#filters [name=name]").change(function(){
	imageReset();
});
var msnry = container.masonry({
	"itemSelector": ".item",
});

$(".sidebar-toggler", ".sidebar-toggler-wrapper").click(function(){
	setTimeout(function(){
  		container.masonry();
	}, 200);
});

container.imagesLoaded( function() {
  	container.masonry();
});

setInfiniteScroll();
container.click(function(event){
	var index = $('img', this).index( $(event.target) );
    blueimp.Gallery($("img", container), {
    			toggleSlideshowOnSpace: false,
              	thumbnailIndicators: true,
              	useBootstrapModal: false,
              	index: index,
              	onslide: function(index, slide){
               		var index = $('.indicator li.active').data('index');
               		var id = this.list[index].getAttribute('data-id');
               		var info = ['id', 'description', 'dimension', 'keywords', 'name', 'arrCategories', 'arrCollections', 'path', 'model',
               						'artist', 'gender', 'number_people', 'age_from', 'age_to'];
               		for( var i in info ) {
                		var data = imgObj[id][info[i]];
                		if( data == null ) {
                			data = '';
                		}
                		info[i] = info[i].replace('arr', '').toLowerCase();
                		if(info[i] == 'path' ) {
                			imageInput(data);
                			continue;
                		} else if( $('#info-editor #'+ info[i]).attr('multiple') != undefined ) {
                			$('#info-editor #'+ info[i] +' option').prop('selected', false);
                			$('#info-editor #'+ info[i] +'').val(data)
                										.selectpicker('refresh');
               			} else if( $('#info-editor [name='+ info[i] +']').hasClass('tags') ) {
               				$('#info-editor [name='+ info[i] +']').importTags(data);
               			} else {
                			$('#info-editor [name='+ info[i] +']').val(data);
               			}
                		$('.content_info .'+ info[i]).text(data);
               		}
               		if( imgObj[id]['number_people'] ) {
               			$('#with-human').prop('checked', true);
               		} else {
               			$('#with-human').prop('checked', false);
               		}
               		$('#with-human').trigger('change');
              	}
            });
});

$('#blueimp-gallery').on('dblclick', '.slide-content', function(){
	$('#info-editor .has-error').removeClass('has-error');
	$('#info-editor .help-block-error').remove();
   	$('#image-form .alert-danger').hide();
   	$('#info-editor').modal('show');
});

$('#info-editor .btn-close').click(function(){
   	$('#info-editor').modal('hide');
});

$('#info-editor').on('hidden.bs.modal', function () {
    var index = $('.indicator li.active').data('index');
	$('#blueimp-gallery .slide[data-index='+ index +'] > img').fadeIn();
})

$(".blueimp-gallery .infomation").mouseenter(function(){
	$(".blueimp-gallery .infomation .content_info").removeClass('fadeOutLeft');
	$(".blueimp-gallery .infomation .content_info").addClass('fadeInLeft');
	$(".blueimp-gallery .infomation .icon").hide();
	$(".blueimp-gallery .icon-edit").hide();
	$(".blueimp-gallery .infomation .content_info").show();
}).mouseleave(function(){
	$(".blueimp-gallery .infomation .content_info").removeClass('fadeInLeft');
	$(".blueimp-gallery .infomation .content_info").addClass('fadeOutLeft');
	$(".blueimp-gallery .infomation .icon").show();
	$(".blueimp-gallery  .icon-edit").show();
});

$(".blueimp-gallery .icon-edit").on("click",function(){
	$('#info-editor .has-error').removeClass('has-error');
	$('#info-editor .help-block-error').remove();
   	$('#image-form .alert-danger').hide();
   	$('#info-editor').modal('show');
});

$('#info-submit').click(function(){
	$('#image-form [type="submit"]').trigger('click');
});

$("#add-image").click(function(){
	resetInput();
	$("#info-editor").modal('show');
});

$('#choose-image').popover({
	content: getSocialHTML(),
	title: 'Choose from',
	html: true,
	placement: 'top',
	template: '<div class="popover choose-panel" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
	trigger: 'click'
});

function updateImage()
{
	var data = new FormData();
	var files = $("#file", "#img-tab")[0].files;
	if( $('#img-div [name=id]').val() == 0 ) {
		if( $('[name=choose_image]').val() == '' ) {
			var files = $("#file", "##img-tab")[0].files;
			if( !files || !files.length ) {
				return false;
			}
		}
	}
    data.append("image", files[0]);
	$("input, select, textarea", "#info-editor").each(function(){
		var name = $(this).attr('name');
		var value = $(this).val();
		if( $(this).attr('multiple') != undefined ) {
			value = JSON.stringify(value);
		}
		if( name ) {
			data.append(name, value);
		}
	});
	$.ajax({
		url: "{{ URL.'/admin/images/update-image' }}",
		type: "POST",
		data: data,
		contentType: false,
		processData: false,
		success: function(result) {
			if( result.status == 'ok' ) {
				imgObj[ result.data.id ] = $.extend(imgObj[ result.data.id ], result.data);
				$('img[data-index='+ result.data.id +']', container).attr({
					'data-title': result.data.name,
					'title': result.data.name
				});
				if( result.data.changeImg ) {
					if( result.data.newImg ) {
						var data = getFragment([result.data]);
					    container.prepend( data.fragment )
					    		.masonry( 'prepended', data.elems );
					    imgObj[result.data.id] = result.data;
			    		$('img[data-toggle=tooltip]').tooltip({
			    			html: true,
			    			container: 'body'
			    		});
					} else {
						var img = $('[data-id='+ result.data.id +']', container);
						var src = img.attr('src') + '?' + new Date().getTime();
						img.prop('src', src);
						var index = $('img', container).index(img);
						$('[data-index='+ index +'] > .slide-content', '#blueimp-gallery').prop('src', src);
					}
					container.masonry()
						.imagesLoaded( function() {
						  	container.masonry();
						});
				}
				$('#info-editor .btn-close').trigger("click");
				toastr.success(result.message, 'Message');
			} else {
				toastr.error(result.message, 'Error');
			}
		}
	});
}

function getItemElement(img) {
	var elem = document.createElement('img');
	elem.className = 'item ';
	elem.setAttribute('src', img.path);
	elem.setAttribute('data-href', img.path);
	elem.setAttribute('data-thumbnail', img.path);
	elem.setAttribute('data-toggle', 'tooltip');
	elem.setAttribute('title', img.name +(img['new'] ? " <span class='badge badge-danger'>New</span>" : ''));
	elem.setAttribute('data-id', img.id);
	imgObj[ img.id ] = img;
	return elem;
}
function imageReset()
{
	currPage = 1;
	var url = getURL(currPage);
	$('div#navigation > a:first').attr('href', url);
	container.infinitescroll('destroy');
	container.data('infinitescroll', null);
	setInfiniteScroll();
	$.ajax({
		url : url,
		success: function(result) {
			if( result ) {
				history.pushState('data', '', url);
				var data = getFragment(result);
				container.masonry('destroy')
						.html( data.fragment )
						.masonry()
						.imagesLoaded( function() {
						  	container.masonry();
						});
			}
		}
	});
}
function imageAppend(result, page)
{
	if( result ) {
		var data = getFragment(result);
	    container.append( data.fragment )
	    			.masonry( 'appended', data.elems )
	    			.imagesLoaded( function() {
					  	container.masonry();
					});
		history.pushState('data', '', getURL(page));
		$('div#navigation > a:first').attr('href', getURL(page));
		$('img[data-toggle=tooltip]').tooltip({
			html: true,
			container: 'body'
		});
	}
}
function getFragment(images)
{
	var fragment = document.createDocumentFragment();
	var elems = [];
	var html = '';
	for(var i in images) {
		var elem = getItemElement(images[i]);
  		fragment.appendChild( elem );
		elems.push( elem );
	}
	return {'fragment': fragment, 'elems': elems};
}
function getURL(page)
{
	var categories = $('#filters input[name="categories[]"]').serialize();
	var name = $('#filters input[name="name"]').val();
	var url = '{{ URL }}/admin/images?page=' + page;
	if( categories ) {
		url += '&' + categories;
	}
	if( name ) {
		url += '&name=' + name;
	}
	return url;
}

function setInfiniteScroll()
{
	container.infinitescroll({
		dataType: 'json',
		appendCallback: false,
		debug: false,
		pixelsFromNavToBottom: container.height(),
		navSelector : "div#navigation",
		nextSelector: "div#navigation a:first",
		extraScrollPx: 15,
		pathParse: true,
		state: {
			currPage: currPage,
		},
		path: function(){
			currPage++;
			return getURL(currPage);
		},
		errorCallback: function(status){
			if( status == 'done' ) {
				toastr.success("All images have been loaded.", "Message");
			}
		}
	}, function(result, opts) {
		var page = opts.state.currPage;
		imageAppend(result, page);
	});
}

function imageInput(url)
{
	$('#img-tab [data-dismiss="fileinput"]').trigger('click');
	if( url ) {
		$('#img-tab #preview-img').attr('src', url);
	} else {
		$('#img-tab #preview-img').attr('src', $('#img-tab #preview-img').attr('data-origin-src'));
	}
}

function resetInput()
{
	imageInput();
	$('input, select, textarea', '#info-editor').val('');
    $('#info-editor select[multiple]').val([]).selectpicker('refresh');
    $('#info-editor input.tags').importTags('');
}

function getSocialHTML()
{
	var html = '<ul class="list-inline">';
	for( var i in socials ) {
		html += '<li>' +
		            '<img src="'+ socials[i].logo +'" alt="" style="width:100%;" onclick="importFrom(\''+ i +'\')" title="'+ socials[i].title +'">' +
		        '</li>';
	}
	html += '</ul>';
	return html;
}

function importFrom(from)
{
	$('#choose-image').popover('hide');
	if( $('#'+ socials[from].id).length ) {
		$('#'+ socials[from].id).modal('show');
	} else {
		checkAuth(from);
	}
}
var tryTimes = 0;
function checkAuth(from) {
	if( socials[from].CLIENT_ID == '' ) {
		toastr.error('Missing '+ socials[from].title +' API Key.', 'Error');
		return false;
	}
	if( from == 'g' ) {
		var immediate = true;
		if( tryTimes ) {
			immediate = false;
		}
	  	gapi.auth.authorize(
	      {'client_id': socials[from].CLIENT_ID, 'scope': socials[from].SCOPES, 'immediate': immediate},
	      handleGAuthResult);
	} else if( from == 'o' ) {
		WL.init({
		    client_id: 		socials[from].CLIENT_ID,
		    redirect_uri: 	socials[from].REDIRECT_URI,
		    scope: 			socials[from].SCOPES,
		    response_type: 	socials[from].RESPONSE_TYPE
		});
		handleOAuthResult(from);
	} else if( from == 'd' ) {
		Dropbox.choose({
			success: function(files) {
				var src = files[0].link.replace('dl=0','dl=1');
				var name = files[0].name;
				var thumbnailLink = files[0].thumbnailLink;
				$('#file').val('').trigger('change');
				$('[name=choose_image]').val(src);
				$('[name=choose_name]').val(name);
				$('#preview-img').attr('src', thumbnailLink);
			},
			linkType: "preview",
			multiselect: false,
			extensions: ['.jpeg','.jpg','.png','.bmp','.gif'],
		});
	}
	if( ++tryTimes == 3 ) {
		return false;
	}
}

function handleGAuthResult(authResult) {
  	if (authResult && !authResult.error) {
  	   getGListImages('g');
  	} else {
       checkAuth('g');
  	}
}

function handleOAuthResult(from)
{
	WL.login({
	    scope: ["wl.signin","wl.skydrive"]
	}).then(
	    function(response){
	    	socials.o.TOKEN = response.session.access_token;
	    	getOListItems(from);
    });
}

function createSocialModal(from)
{
	var html = '<div id="'+ socials[from].id +'" class="modal" style="z-index: 1000005;">' +
					'<div class="modal-content" style="top: 12%; width: 80%; left: 10%; position: absolute; z-index: 1000005;">' +
						'<div class="modal-header">' +
							'<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>' +
							'<h4 class="modal-title"><img src="'+ socials[from].logo + '"/> <b>' + socials[from].title +'</b></h4>' +
						'</div>' +
						'<div class="list-image modal-body">' +
						'</div>' +
					'</div>' +
				'</div>';
	$('body').append(  html );
	$('#'+ socials[from].id).modal('show');
	Metronic.blockUI({
		target: $('#'+ socials[from].id +' .list-image')
	});
}

function getOListItems(from)
{
	createSocialModal(from);
	$.ajax({
		url:'https://api.onedrive.com/v1.0/drive/root/children?access_token='+ socials.o.TOKEN,
		data: {
			select: '@odata.context,folder,parentReference,name,file,id,@content.downloadUrl'
		},
		success:function(item){
			var data = getSocialImagesHTML(from, item.value);
			$('#'+ data.id +' .list-image').html(data.html);
    		Metronic.unblockUI({
		    	target: $('#'+ socials[from].id +' .list-image')
		    });
		}
	});
}

function getGListImages(from) {
	createSocialModal(from);
	gapi.client.load('drive', 'v2', function() {
		var request  = gapi.client.drive.files.list({
			q:"mimeType contains 'image'and mimeType != 'image/svg+xml'"
		});
		request.execute(function(images) {
			var images = images.items;
			var data = getSocialImagesHTML('g', images);
			$('#'+ data.id +' .list-image').html(data.html);
			Metronic.unblockUI({
				target: $('#'+ socials[from].id +' .list-image')
			});
		});
	});
}

function getSocialImagesHTML(from, items)
{
	var root = false;
	var html = '';
	if( from == 'g' ) {
		for( var i in items ) {
			if( from == 'g' && !items[i].shared ) continue;
			html += '<div class="block-img">' +
							'<img data-src="'+ items[i][ socials[from].link ] +'" data-name="'+ items[i][ socials[from].name ] +'" src="'+ items[i][ socials[from].thumb ] +'" onClick="chooseImage(this, \''+ from +'\')" />' +
						'</div>';
		}
	} else if( from == 'o' ) {
		for(var i in items){
			item = items[i];
			if( item.parentReference.path == '/drive/root:' ) {
				root = true;
			}
			if(item.folder){
				html += '<div class="block-img" onclick="chooseFolder(\''+ item.parentReference.id +'\', \''+ item.id +'\')"><div class="block-name">'+ item.name +'<div class="block-number">'+ item.folder.childCount +'</div></div></div>';
			}else{
				if(item.file && item.file.mimeType.indexOf("image") != -1 ){
					html += '<div class="block-img"><img data-src="'+ item[socials[from].link] +'"  data-name="'+ item[socials[from].name] +'" src="'+ item.thumbnails[0].medium.url +'" onclick="chooseImage(this, \''+ from +'\')"/></div>';
				} else {
					html += '<div class="block-img"><div class="block-name other">'+ item.name +'</div></div>';
				}
			}
		}
	}
	return {html: html, id: socials[from].id, root: root};
}

function chooseFolder(parentId, id)
{
	$.ajax({
		url:'https://api.onedrive.com/v1.0/drive/items/'+ id +'/children?access_token='+ socials.o.TOKEN,
		data: {
			select: '@odata.context,folder,parentReference,name,file,id,@content.downloadUrl',
			expand: 'thumbnails(select=large)'
		},
		success:function(item){
			var data = getSocialImagesHTML('o', item.value);
			if( !data.root ) {
				if( parentId == '' ) {
					parentId = 'root';
				}
				data.html = '<div class="block-img" onclick="chooseFolder(\'\', \''+ parentId +'\', 1)"><div class="block-name"><i class="fa fa-arrow-left"></i></div></div>' + data.html;
			}
			$('#'+ data.id + ' .list-image').html(data.html);
		}
	});
}

function chooseImage(obj, from)
{
	var src = $(obj).data('src');
	var name = $(obj).data('name');
	$('#file').val('').trigger('change');
	$('[name=choose_image]').val(src);
	$('[name=choose_name]').val(name);
	$('#preview-img').attr('src', $(obj).attr('src'));
	$('#'+ socials[from].id).modal('hide');
}
</script>
@stop