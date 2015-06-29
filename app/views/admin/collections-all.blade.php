@section('body')
<body class="page-header-fixed page-header-fixed-mobile page-quick-sidebar-over-content page-style-square page-sidebar-closed">
@stop
@section('sideMenu')
<ul id="sidebar-menu" class="page-sidebar-menu page-sidebar-menu-closed {{ isset($currentTheme['sidebar']) && $currentTheme['sidebar'] == 'fixed' ? 'page-sidebar-menu-fixed' : 'page-sidebar-menu-default' }}" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
@stop
<div id="collection-list-context-menu">
  	<ul class="dropdown-menu" role="menu">
     	<li><a class="select" tabindex="-1"><i class="fa fa-crosshairs font-blue"></i>Select</a></li>
     	<li><a class="on_screen" tabindex="-1"><i class="fa fa-circle-o font-yellow"></i>Show/Hide on Frontend</a></li>
       	<li><a class="delete" tabindex="-1"><i class="fa fa-times font-red"></i>Delete</a></li>
  	</ul>
</div>
<div id="collection-image-context-menu">
  	<ul class="dropdown-menu" role="menu">
     	<li><a class="main" tabindex="-1"><i class="fa fa-circle-o font-yellow"></i>Set main Photo</a></li>
       	<li><a class="delete" tabindex="-1"><i class="fa fa-times font-red"></i>Remove</a></li>
  	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN TODO SIDEBAR -->
			<div id="collection-list" class="col-md-3">
				<div class="portlet light">
					<div class="portlet-title" style="padding-bottom: 7px;">
						<div class="caption">
							<span class="caption-subject font-green-sharp bold uppercase" data-toggle="tooltip" title="Right click to select or delete">Collections </span>
						</div>
						<div class="actions">
							<a id="add-collection" class="btn green-haze btn-circle btn-sm" data-toggle="popover" title="Add collection">
								<i data-toggle="popover" class="fa fa-plus"></i>
							</a>
						</div>
					</div>
					<div class="portlet-body todo-project-list-content scroller" style="height: {{ $maxHeight }}px; overflow: auto;">
						<div class="todo-project-list">
							<ul class="nav nav-pills nav-stacked">
								@foreach( $collections as $collection )
								<li data-id="{{ $collection['id'] }}">
									<a href="javascript:void(0)">
									 <span @if(!$collection['image_total']) style="display: none" @endif class="badge badge-success"> {{ $collection['image_total'] }} </span>
									 <span class="collection-name">{{ $collection['name'] }} </span>
									 <span class="label label-danger on-screen @if( !$collection['on_screen'] ) hide @endif " data-toggle="tooltip" title="On frontend"><i class="fa fa-desktop"></i></span>
									</a>
								</li>
								@endforeach
							</ul>
						</div>
					</div>
				</div>
			</div>
			<!-- END TODO SIDEBAR -->
			<!-- BEGIN TODO CONTENT -->
			<div class="col-md-9">
				<div id="collection-content" class="todo-content col-md-6">
					<div class="portlet light col-md-12">
						<!-- PROJECT HEAD -->
						<div class="portlet-title">
							<div class="caption col-md-8" id="collection-info">
								<input id="collection-id" name="id" type="hidden" value="0" />
								<div class=" col-md-6">
									<input id="collection-name" name="name" data-toggle="tooltip" title="Change for edit" class="form-control caption-subject font-green-sharp bold " value="" placeholder="Collection name" />
								</div>
								<div class="col-md-6">
									<select id="collection-type_id" name="type_id" data-toggle="tooltip" title="Change for edit" class="form-control">
										@foreach($types as $type)
										<option value="{{ $type['value'] }}">{{ $type['text'] }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="actions">
								<a onclick="addImage()" class="btn green-haze btn-circle btn-sm" data-toggle="tooltip" title="Import image">
									<i class="fa fa-plus"></i>
								</a>
							</div>
						</div>
						<!-- end PROJECT HEAD -->
						<div class="portlet-body scroller" style="height: {{ $maxHeight }}px; overflow: auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
						</div>
					</div>
				</div>
				<div id="image-all" class="col-md-6">
					<div class="portlet light col-md-12 " style="float: left;">
						<!-- PROJECT HEAD -->
						<div class="portlet-title">
							<div class="caption">
								<span class="caption-subject font-green-sharp bold">Images</span>
								<a href="javascript:void(0)" data-toggle="tooltip" title="Filter panel" id="filters">
									 <i id="filters" class="fa fa-filter"></i>
								</a>
							</div>
							<div class="pull-right">
								<div id="pagination-nav" class="inline"></div>
								<a style="  margin-top: -50px; margin-left: 10px;" onclick="hideImage()" class="btn red-haze btn-circle btn-sm" data-toggle="tooltip" title="Close image panel">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<!-- end PROJECT HEAD -->
						<div class="portlet-body scroller col-md-12 " style="height: {{ $maxHeight }}px; float: left; overflow: auto;">
						</div>
					</div>
				</div>
			</div>
			<!-- END TODO CONTENT -->
	</div>
	<!-- END PAGE CONTENT-->
</div>

@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/admin/pages/css/todo.css') }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
<style type="text/css">
.page-container .page-content {
  	background: #f1f3fa;
}
.todo-sidebar {
   	margin-right: 0;
}
#collection-content .portlet-body:before,
#collection-content .portlet-body:after,
#image-all .portlet-body:before,
#image-all .portlet-body:after {
	width: 98%;
}
#collection-content .portlet-body:after,
#image-all .portlet-body:after {
    clear: both;
}
.item {
  float: left;
  margin-bottom: 10px;
}
.item.main {
	border: 2px solid red;
}
.item img {
  max-width: 100%;
  max-height: 100%;
  vertical-align: bottom;
}
.first-item {
  clear: both;
}
.last-row, .last-row ~ .item {
  margin-bottom: 0;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/rowgrid/row-grid.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-contextmenu/bootstrap-contextmenu.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript">
var filterData = {};
var collectionContent = $('#collection-content .portlet-body');
var imgContent = $('#image-all .portlet-body');
var options = {minMargin: 5, maxMargin: 15, itemSelector: ".item", firstItemClass: "first-item"};
$('[data-toggle="tooltip"]').tooltip({
	container: 'body'
});

$('.scroller').slimScroll({
    color: '#dae3e7',
    alwaysVisible: false
});

$('#filters').popover({
	container: 'body',
	content: '<div class="form-group row">' +
				'<label for="" class="col-md-4 text-right">Name:</label>' +
				'<div class="col-md-8">' +
					'<input type="text" class="form-control" name="name" value="" placeholder=" name/keywords/description " />' +
				'</div>' +
			'</div>' +
			'<div class="form-group row">' +
				'<label for="" class="col-md-4 text-right">Categories:</label>' +
				'<div class="col-md-8">' +
					'<select class="form-control" name="categories" multiple >' +
					@if( isset($categories) )
					@foreach($categories as $category)
					@if( $category['value'] )
					'<option value="{{ $category['value'] }}">{{ $category['text'] }}</option>' +
					@endif
					@endforeach
					@endif
					'</select>' +
				'</div>' +
			'</div>' +
			'<div class="form-group row text-right" style="margin-right: 5px;">' +
				'<a onclick="filterSubmit()" class="btn btn-primary">Filter</a>' +
				'<a onclick="filterCancel()" class="btn btn-danger">Cancel</a>' +
			'</div>',
	html: true,
	placement: 'bottom',
	template: '<div class="popover" role="tooltip" style="min-width: 375px;"><div class="arrow"></div><h3 class="popover-title"></h3><div id="filter-panel" class="popover-content"></div></div>',
}).on('shown.bs.popover', function(){
	$('#filter-panel select').selectpicker({
		iconBase: 'fa',
		tickIcon: 'fa-check'
	});
	for( var i in filterData ) {
		$('#filter-panel [name='+ i +']').val(filterData[i]);
	}
	$('#filter-panel select').selectpicker('refresh');
});

$('#add-collection').popover({
	content: '<div class="form-group">' +
				'<div class="editable-input" style="position: relative;">' +
					'<input type="text" name="name" class="input-medium" style="padding-right: 24px;">' +
					'<span class="editable-clear-x">' +
					'</span>' +
				'</div>' +
				'<div class="editable-buttons">' +
					'<a class="btn blue editable-submit">' +
						'<i class="fa fa-check"></i>' +
					'</a>' +
					'<a class="btn default editable-cancel">' +
						'<i class="fa fa-times"></i>' +
					'</a></div>' +
				'</div>' +
				'<div class="editable-error-block help-block" style="display: none;"></div>' +
			'</div>',
	html: true,
	placement: 'bottom',
	template: '<div class="popover editable-container editable-popup" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
	trigger: 'click'
}).on('shown.bs.popover', function(){
	$('.editable-container input[type=text]').focus();
}).tooltip({
	content: 'Add collection'
});


$('#collection-list').on('click', '.editable-cancel', function(){
	$('#collection-list input[name=name]').val('');
	$('#collection-list .editable-error-block').html('').hide();
    $('#add-collection').popover('hide');
}).on('click', '.editable-clear-x', function(){
	$('#collection-list input[name=name]').val('');
	$('#collection-list .editable-error-block').html('').hide();
}).on('click', '.editable-submit', function(){
	var name = $('#collection-list [name=name]').val();
	if( name == '' ) {
		$('#collection-list .editable-error-block').html('Name cannot be empty.').show();
		$('#collection-list input[name=name]').focus();
	} else {
		$.ajax({
			url: '{{ URL.'/admin/collections/update-collection' }}',
			type: 'POST',
			data: {
				'name': name
			},
			success: function(result) {
				if( result.status == 'ok' ) {
					$('ul', '#collection-list').append('<li data-id="'+ result.data.id +'">' +
															'<a href="#collection-content">' +
															 	'<span style="display: none" class="badge badge-success"> 0 </span>' +
									 							'<span class="collection-name">' +
															 		result.data.name +
															 	'</span>' +
									 							'<span class="label label-danger on-screen hide" data-toggle="tooltip" title="On frontend"><i class="fa fa-desktop"></i></span>'+
															'</a>' +
														'</li>');
					$('#collection-list .scroller').slimScroll({
						'scrollTo': $('#collection-list li:last').position().top
					});
					contextInit('li', ':last');
					$('#collection-list li:last').trigger('click');
					addImage();
					$('#collection-list input[name=name]').val('');
					$('#collection-list .editable-error-block').html('').hide();
        			$('#add-collection').popover('hide');
        			toastr.success(result.message, 'Message');
				} else {
					$('#collection-list .editable-error-block').html(result.message).show();
				}
			}
		});
	}
});

$('body').on('click', function (e) {
    if ( $(e.target).data('toggle') !== 'popover'
        && $(e.target).parents('.popover.in').length === 0) {
        $('#add-collection').popover('hide');
    }
});

$('#collection-list').on('click', 'li', function(){
 	$('#collection-list li').removeClass('active');
 	$('#collection-list li .badge').removeClass('badge-active');
 	$(this).addClass('active');
 	$('.badge', this).addClass('badge-active');
 	var id = $(this).data('id');
 	loadCollection(id);
});

$('#collection-list li:first').trigger('click');

$('#collection-info select').selectpicker({
    iconBase: 'fa',
    tickIcon: 'fa-check'
});

$('input,select', '#collection-info').change(function(){
	if( $('#collection-info [name=id]').val() == 0 ) {
		toastr.warning('Collection must be exist first.', 'Message');
		$('input[name=name]', '#collection-info').val('');
		$('select', '#collection-info').val(0).selectpicker('refresh');
		return false;
	}
	$.ajax({
		url: '{{ URL }}/admin/collections/update-collection',
		type: 'POST',
		data: $('input,select', '#collection-info').serialize(),
		success: function(result){
			if( result.status == 'ok' ) {
				$('#collection-list li.active a span.collection-name').text($('#collection-info input[name=name]').val());
        		toastr.success(result.message, 'Message');
			} else {
        		toastr.error(result.message, 'Message');
			}
		}
	});
});
contextInit('li');
function contextInit(type, str)
{
	if( str == undefined ) {
		str = '';
	}
	if( type == 'li' ) {
		$('#collection-list li'+ str).contextmenu({
		   	target: '#collection-list-context-menu',
		   	before: function (e) {
		       e.preventDefault();
		       return true;
		   	},
		   	onItem: function(context, e) {
		   		console.log(e.target.className);
		   		contextMenu('CollectionList', e.target.className, context);
		  	}
		});
	} else {
		$('#collection-content img'+ str).contextmenu({
		   	target: '#collection-image-context-menu',
		   	before: function (e) {
		       e.preventDefault();
		       return true;
		   	},
		   	onItem: function(context, e) {
		   		contextMenu('CollectionImage', e.target.className, context);
		  	}
		});
	}
}

function contextMenu(type, action, target)
{
	if( type == 'CollectionList' ) {
		if( action == 'select' ) {
			$(target).trigger('click');
		} else if( action == 'delete' ) {
            bootbox.confirm('Are you sure you want to delete this collection?', function(result) {
            	if( result ) {
            		var id = $(target).data('id');
            		$.ajax({
            			url: "{{ URL }}/admin/collections/delete-collection/" + id,
            			success: function(result) {
            				if( result.status == 'ok' ) {
            					if( $(target).hasClass('active') ) {
            						var index = $(target).index('#collection-list li');
            						if( index == 0 ) {
            							index++;
            						} else {
            							index--;
            						}
            						var other = $('#collection-list li:eq('+ index +')');
            						if( other.length ) {
            							$('#collection-list .scroller').slimScroll({
            								'scrollTo': other.position().top
            							});
            							other.trigger('click');
            						} else {
            							collectionContent.html('');
            							$('input[name=name]', '#collection-info').val('');
            							$('select, [name=id]', '#collection-info').val(0);
            							$('select', '#collection-info').selectpicker('refresh');
            						}
            					}
            					$(target).remove();
            					toastr.success(result.message, 'Message');
            				} else {
            					toastr.error(result.message, 'Error');
            				}
            			}
            		});
            	}
            });
		} else if( action == 'on_screen' ) {
            var id = $(target).data('id');
            var data = {
            	id : id,
            	on_screen: $('.on-screen', target).hasClass('hide') ? 1 : 0
            };
            $.ajax({
            	url: "{{ URL }}/admin/collections/update-collection",
            	data:  data,
            	type:  'post',
            	success: function(result) {
            		if( result.status == 'ok' ) {
            			if( data.on_screen ) {
            				$('.on-screen', target).removeClass('hide');
            			} else {
            				$('.on-screen', target).addClass('hide');
            			}
            			toastr.success(result.message, 'Message');
            		} else {
            			toastr.error(result.message, 'Error');
            		}
            	}
            });
		}
	} else if( type == 'CollectionImage' ) {
		if( action == 'delete' ) {
            bootbox.confirm('Are you sure you want to remove this image?', function(result) {
            	if( result ) {
        		    var data = {
        		    	type: 'delete',
        				id: $('#collection-info [name=id]').val(),
        		    	image_id: $(target).data('id'),
        		    	short_name: $(target).data('short_name'),
        		    	name: $(target).data('name'),
        		    	path: $(target).attr('src'),
        		    	ratio: $(target).data('ratio'),
        		    	height: $(target).attr('height'),
        		    	width: $(target).attr('width'),
        		    };
        			updateImage(data);
            	}
			});
		} else if( action == 'main' ) {
        	updateImage({
        		type: 'main',
        		id: $('#collection-info [name=id]').val(),
        		image_id: $(target).data('id'),
        		name: $(target).data('name'),
        		main: $(target).parent().hasClass('main') ? 0 : 1
        	});
		}
	}
}

function loadCollection(id)
{
	$('input,select', '#collection-info').prop('disabled', true);
	Metronic.blockUI({
        target: collectionContent,
    });
	$.ajax({
		url: '{{ URL.'/admin/collections/get-collection-images' }}',
		type: 'POST',
		data: {
			id: id
		},
		success: function(result) {
			var html = '';
			var data = {
				name : '',
				type_id : 0,
				id   : 0,
			};
			if( result ) {
				data.name = result.name;
				data.type_id = result.type_id;
				data.id = result.id;
				for( var i in result.images ) {
					html += '<div class="item '+ (result.images[i].main ? 'main' : '') +'">' +
								'<img draggable="false" src="' + result.images[i].path +'" title="'+ result.images[i].name + ( result.images[i].main ? " <span class='badge badge-danger' >Main Photo</span>" : '')+'" data-id="'+ result.images[i].id +'"  data-name="'+ result.images[i].name +'" data-short_name="'+ result.images[i].short_name +'" height="'+ result.images[i].height +'" width="'+ result.images[i].width +'"  data-ratio="'+ result.images[i].ratio +'" />'+
							'</div>';
				}
			}
			for( var i in data ) {
				$('#collection-' + i).val(data[i]);
			}
			collectionContent.html(html);
  			collectionContent.rowGrid(options);
  			contextInit('img');
			$('img', collectionContent).tooltip({
				container: '#collection-content',
				html: true
			});
			$('input,select', '#collection-info').prop('disabled', false);
			$('#collection-info select').selectpicker('refresh');
			Metronic.unblockUI(collectionContent);
			getImages();
		}
	});
}
function addImage()
{
	$('#collection-content').removeClass('col-md-12').addClass('col-md-6');
	$('#image-all').show();
  	collectionContent.rowGrid(options);
}
function hideImage()
{
	$('#image-all').hide();
	$('#collection-content').removeClass('col-md-6').addClass('col-md-12');
  	collectionContent.rowGrid(options);
}
function getImages(page)
{
	var data = {};
	data['id'] = $('#collection-id').val();
	if( filterData == undefined ) {
		filterData = {};
	}
	if( page == undefined ) {
		page = 1;
	}
	data = $.extend(data, filterData);
	data = $.extend(data, {page: parseInt(page)});
	Metronic.blockUI({
        target: imgContent,
    });
	$.ajax({
		url: '{{ URL.'/admin/collections/get-images' }}',
		type: 'POST',
		data: data,
		success: function(result) {
			var html = '';
			if( result.data != undefined ) {
				var data = result.data;
				for( var i in data ) {
					html += '<div class="item">' +
								'<img src="' + data[i].path +'" title="'+ data[i].name +'" height="'+ data[i].height +'" width="'+ data[i].width +'" data-id="'+ data[i].id +'" data-name="'+ data[i].name +'"  data-short_name="'+ data[i].short_name +'" data-name="'+ data[i].name +'" data-ratio="'+ data[i].ratio +'" draggable="true" ondragstart="drag(event)" />'+
							'</div>';
				}
			}
			createPaginationNav({ currentPage: result.page, totalPage: result.total_page });
			imgContent.html(html);
			imgContent.rowGrid(options);
			$('img', imgContent).tooltip({
				container: '#image-all'
			});
			Metronic.unblockUI(imgContent);
		}
	})
}
function allowDrop(e) {
    e.preventDefault();
}

function drag(e)
{
    e.dataTransfer.setData("id", $(e.target).data('id'));
    e.dataTransfer.setData("short_name", $(e.target).data('short_name'));
    e.dataTransfer.setData("name", $(e.target).data('name'));
    e.dataTransfer.setData("path", $(e.target).attr('src'));
    e.dataTransfer.setData("ratio", $(e.target).data('ratio'));
    e.dataTransfer.setData("height", $(e.target).attr('height'));
    e.dataTransfer.setData("width", $(e.target).attr('width'));
}

function drop(e)
{
	if( $('#collection-info [name=id]').val() == 0 ) {
		toastr.warning('Collection must be exist first.', 'Message');
		return false;
	}
    e.preventDefault();
    var data = {
        type: 'append',
        id: $('#collection-info [name=id]').val(),
    	image_id: e.dataTransfer.getData("id"),
    	short_name: e.dataTransfer.getData("short_name"),
    	name: e.dataTransfer.getData("name"),
    	path: e.dataTransfer.getData("path"),
    	height: e.dataTransfer.getData("height"),
    	width: e.dataTransfer.getData("width"),
    	ratio: e.dataTransfer.getData("ratio"),
    };
	updateImage(data);
}

function updateImage(data)
{
	$.ajax({
		url: "{{ URL }}/admin/collections/update-image",
		type: "POST",
		data: data,
		success: function(result) {
			var counter = $('#collection-list li.active .badge-active');
			toastr.clear();
			if( data.type == 'append' ) {
				if( result.status == 'ok' ) {
  					$('[role="tooltip"]', collectionContent).remove();
					collectionContent.prepend('<div class="item">' +
												'<img draggable="false" src="{{ URL }}/pic/thumb/'+ data.short_name +'-'+ data.image_id +'.jpg" title="'+ data.name +'" data-id="'+ data.image_id +'" data-short_name="'+ data.short_name +'" data-name="'+ data.name +'" width="'+ data.width +'" height="'+ data.height +'" data-ratio="'+ data.ratio +'">' +
											'</div>')
										.rowGrid(options)
										.slimScroll({
											scrollTo: 0
										});
  					contextInit('img', ':first');
  					$('[role="tooltip"]', imgContent).remove();
					$('[data-id='+ data.image_id +']',imgContent).parent().remove();
					counter.text( parseInt(counter.text()) + 1 ).show();
					$(imgContent).rowGrid(options);
					toastr.success(result.message, 'Message');
				}
			} else if( data.type == 'delete' ) {
				if( result.status == 'ok' ) {
  					$('[role="tooltip"]', imgContent).remove();
					imgContent.prepend('<div class="item">' +
											'<img src="{{ URL }}/pic/thumb/'+ data.short_name +'-'+ data.image_id +'.jpg" title="'+ data.name +'" height="'+ data.height +'" width="'+ data.width +'" data-id="'+ data.image_id +'" data-short_name="'+ data.short_name +'" data-name="'+ data.name +'" data-ratio="'+ data.ratio +'" draggable="true" ondragstart="drag(event)" />'+
										'</div>')
										.rowGrid(options)
										.slimScroll({
											scrollTo: 0
										});
  					$('[role="tooltip"]', collectionContent).remove();
					$('[data-id='+ data.image_id +']', collectionContent).parent().remove();
					$(collectionContent).rowGrid(options);
					counter.text( parseInt(counter.text()) - 1 );
					toastr.success(result.message, 'Message');
				}
			} else if( data.type == 'main' ) {
				if( result.status == 'ok' ) {
					$('.item.main > img', collectionContent).attr('data-original-title', $('.item.main > img', collectionContent).attr('data-name'));
					$('.item.main', collectionContent).removeClass('main');
					if( data.main ) {
						$('[data-id='+ data.image_id +']', collectionContent).parent().addClass('main');
						$('[data-id='+ data.image_id +']', collectionContent).attr('data-original-title', $('.item.main > img', collectionContent).attr('data-name') +" <span class='badge badge-danger' >Main Photo</span>");
					}
					toastr.success(result.message, 'Message');
				}
			}
			if( data.status == 'error' ) {
				toastr.error(result.message, 'Error');
			}
		}
	});
}
function filterSubmit()
{
	filterData = {};
	$('input, select', '#filter-panel').each(function(){
		filterData[ $(this).attr('name') ] = $(this).val();
	});
	getImages();
}
function filterCancel()
{
	$('#filters').popover('hide');
}
function createPaginationNav(data)
{
	var totalPage = parseInt(data.totalPage);
	var currentPage = parseInt(data.currentPage);
	var html = '';
	var offset = 2;
	if( totalPage ) {
		var prev = currentPage - 1 > 0 ? currentPage - 1 : 1;
		var next = currentPage + 1 <= totalPage ? currentPage + 1 : totalPage;
		html = '<ul class="pagination pagination-sm">' +
					'<li '+( currentPage == prev ? 'class="active"' : '' )+'>' +
						'<a onclick="'+ ( currentPage == prev ? 'return false;' : 'getImages('+ prev +')' )+'">' +
							'<i class="fa fa-angle-left"></i>' +
						'</a>' +
					'</li>';
		var from = currentPage - offset > 0 ? currentPage - offset : 1;
		var to = currentPage + offset <= totalPage ? currentPage + offset : totalPage;
		while( to - from < offset*2 && to < totalPage ) {
			to++;
		}
		while( to - from < offset*2 && from > 1 ) {
			from--;
		}
		for( var i = from; i <= to; i++ ) {
			if( i == currentPage ) {
				html += '<li class="active">' +
							'<a onclick="return false;">' +
							i +
							'</a>' +
						'</li>';
			} else {
				html += '<li>' +
							'<a onclick="getImages('+ i +')">' +
								i +
							'</a>' +
						'</li>';
			}
		}
		html += '<li '+( currentPage == next ? 'class="active"' : '' )+'>' +
					'<a onclick="'+ ( currentPage == next ? 'return false;"' : 'getImages('+ next +')' )+'">' +
						'<i class="fa fa-angle-right"></i>' +
					'</a>' +
				'</li>' +
			'</ul>';
	}
	$('#pagination-nav').html(html);
}
</script>
@stop