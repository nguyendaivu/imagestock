<div id="image-div" class="modal " role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" style="overflow-y: auto !important;">
			<div class="modal-body">
				<div class="fileinput fileinput-new" data-provides="fileinput">
					<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
						<img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}"/>
					</div>
					<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;">
					</div>
					<div>
						<span class="btn default btn-file">
							<span class="fileinput-new">
								Select image
							</span>
							<span class="fileinput-exists">
								Change
							</span>
							<input name="file" id="file" accept="image/*" type="file">
							<input type="hidden" name="choose" value="0" />
							<input type="hidden" name="id" value="0" />
						</span>
						<a href="javascript:void(0)" class="btn green fileinput-new" onclick="openImage(this)">Choose</a>
						<a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
						Remove </a>
					</div>
				</div>
				<div class="editable-buttons"><button type="submit" class="btn blue editable-submit"><i class="fa fa-check"></i></button><button type="button" class="btn default editable-cancel"><i class="fa fa-times"></i></button></div>
			</div>
		</div>
	</div>
</div>
<div id="category-add-div" class="modal fade" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Add Category</h4>
			</div>
			<div class="modal-body form">
				<form id="category-add-form" action="javascript:void(0)" method="POST" class="form-horizontal form-row-seperated">
					<div class="alert alert-danger display-hide">
						<button class="close" data-close="alert"></button>
						<div id="content-message">
							You have some form errors. Please check below.
						</div>
					</div>
					{{ Form::token(); }}
					<div class="form-group">
						<label class="col-sm-4 control-label">Name</label>
						<div class="col-sm-8">
							<input type="text" name="name" value="" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Description</label>
						<div class="col-sm-8">
							<textarea type="text" name="description" value="" class="form-control"/>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Parent Category</label>
						<div class="col-sm-8">
							<select  class="form-control form-filter input-sm" name="parent_id">
										<option value="0">No Parent</option>
								@if(isset($categories))
									@foreach($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								@endif
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Order no</label>
						<div class="col-sm-8" id="spinner-content">
							<div class="input-group">
								<input type="text" name="order_no" value="" readonly class="spinner-input form-control"/>
								<div class="spinner-buttons input-group-btn btn-group-vertical">
									<button type="button" class="btn spinner-up btn-xs red">
									<i class="fa fa-angle-up"></i>
									</button>
									<button type="button" class="btn spinner-down btn-xs red">
									<i class="fa fa-angle-down"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Active</label>
						<div class="col-sm-8">
							<input type="checkbox" name="active" checked class="form-control"/>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" id="category-add-submit" class="btn btn-primary"><i class="fa fa-check"></i>Save change</button>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-credit-card"></i>{{ 'Category Listing' }}
				</div>
				<div class="actions">
					<a href="#category-add-div" data-toggle="modal" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">{{ 'New Category' }}</span>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-hover table-bordered" id="list-category">
						<thead>
							<tr role="row" class="heading">
								<th>
									#
								</th>
								<th>
									Id
								</th>
								<th>
									 {{'Name'}}
								</th>
								<th>
									 {{'Description'}}
								</th>
								<th>
									 {{'Order No'}}
								</th>
								<th>
									 {{'Category Parent'}}
								</th>
								<th>
									 {{'Active'}}
								</th>
								<th class="text-center" width="18%">
									 {{'Tools'}}
								</th>
							</tr>
							<tr role="row" class="filter">
								<td></td>
								<td></td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="search[name]">
								</td>
								<td>
									<input type="text" class="form-control form-filter input-sm" name="search[description]">
								</td>
								<td>
									
								</td>
								<td>
										<select name="search[parent_id]" class="form-control form-filter input-sm">
											<option value="">Select...</option>
											<option value="0">No parent</option>
											@if(isset($categories))
												@foreach($categories as $category)
														<option value="{{ $category->id }}">{{ $category->name }}</option>
												@endforeach
											@endif
										</select>
								</td>
								<td>
									<select name="search[active]" class="form-control form-filter input-sm">
										<option value="">{{ 'Select' }}...</option>
										<option value="yes">{{ 'Yes' }}</option>
										<option value="no">{{ 'No' }}</option>
									</select>
								</td>
								<td class="text-center">
									<button id="search-button" class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i>{{ 'Search' }}</button>
									<button id="cancel-button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i>{{ 'Reset' }}</button>
								</td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}" />
<style type="text/css">
#image-div{
	width: 25%;
	margin-left: -10%;
	overflow-y: auto;
}
#image-div .modal-dialog, #category-add-div .modal-dialog{
	width: 50%;
	margin: 0;
	margin-left: 25%;
	margin-top: 5%;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/fuelux/js/spinner.js' ) }}"></script>
<script type="text/javascript">
$("#spinner-content").spinner({ value : 1, min: 1 });
$("#category-add-submit").click(function(){
	$("#content-message","#category-add-form").html("You have some form errors. Please check below.");
	$("#category-add-form").submit();
});
$("#category-add-form").validate({
	errorElement: 'span',
	errorClass: 'help-block help-block-error',
	focusInvalid: false,
	messages: {
		select_multi: {
			maxlength: $.validator.format("'Max {0} items allowed for selection"),
			minlength: $.validator.format("'At least {0} items must be selected")
		}
	},
	rules: {
		
	},
	invalidHandler: function (event, validator) {
		$(".alert-danger","#category-add-form").show();
		Metronic.scrollTo($(".alert-danger","#category-add-form"), -200);
	},
	errorPlacement: function(error, element) {
		element.parent().append(error);
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
		var form = $("#category-add-form");
		$(".alert-danger", form).hide();
		var name        = $("[name=name]", form).val();
		var description        = $("[name=description]", form).val();
		var parent_id        = $("[name=parent_id]", form).val();
		var order_no    = $("[name=order_no]", form).val();
		var active    = $("[name=active]", form).is(":checked");
		var ajaxConfig  = {
							url : "{{ URL }}/admin/categories/update-category",
							type: "POST",
							success: function(result) {
								if( result.status == "error" ) {
									$("#content-message", form).html(result.message);
									$(".alert-danger", form).show();
								} else {
									$("#category-add-div").modal("hide");
									$("[name=name]", form).val("");
									$("[name=description]", form).val("");
									$("[name=parent_id] option[value=0]", form).prop("selected",true);
									$("[name=active]", form).prop("checked", true);
									$("#spinner-content", form).spinner({ value : 1});
									toastr.success(result.message, 'Message');
									$("#cancel-button").trigger("click");
								}
							}
						};
		var data = {};
		data.name = name;
		data.description = description;
		data.parent_id = parent_id;
		data.order_no = order_no;
		data.active = active;
		ajaxConfig["data"] = data;
		$.ajax(ajaxConfig);
	}
});

var columnDefs = [
		{
			"targets": 2,
			"name"  : "name",
			"data" : function(row, type, val, meta) {
				return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="name" data-type="textarea" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/categories/update-category' }}" data-title="Name">'+row[2]+'</a>';
			}
		},
		{
		 "targets": 3,
			"name"  : "description",
			"data" : function(row, type, val, meta) {
				return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="description" data-type="textarea" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/categories/update-category' }}" data-title="Description">'+row[3]+'</a>';
			}
		},
		{
		 "targets": 4,
			"name"  : "order_no",
			"className" : "text-center",
			"data" : function(row, type, val, meta) {
				return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="order_no" data-type="number" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/categories/update-category' }}" data-title="Order">'+ row[4] +'</a>';
			}
		},
		{
			"targets":5,
			"name"  : "parent_name",
			"data" : function(row, type, val, meta) {
				return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="parent_id" data-type="select" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/categories/update-category' }}" data-title="Category Parent">'+ row[5] +'</a>';
			}
		},
		{
			"targets": 6,
			"className" : "text-center",
			"name"  : "active",
			"data" : function(row, type, val, meta) {
				var html = '';
				if( row[6] ) {
					html = '<span class="label label-sm label-success">Yes</span>';
				} else {
					html = '<span class="label label-sm label-danger">No</span>';
				}
				return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[6]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/categories/update-category' }}" data-title="Active">'+ html +'</a>';
			}
		},
	];
listRecord({
	url: "{{ URL.'/admin/categories/list-category' }}",
	delete_url : "{{ URL.'/admin/categories/delete-category' }}",
	table_id: "#list-category",
	columnDefs: columnDefs,
	fnDrawCallback: function(){
		$(".xeditable-input","#list-category").editable();
		$(".xeditable-textarea","#list-category").editable();
		$("[ data-name=active]","#list-category").editable({
			source: [{value: 1, text: "Yes"},{value: 0, text: "No"}]
		});
		<?php
			$arr_category = array(array('value'=>0,'text'=>'No Parent'));

			foreach ($categories as $key => $category) {
				$arr_tmp['value']=$category->id;
				$arr_tmp['text']=$category->name;
				$arr_category[]=$arr_tmp;
			}
		?>
		$("[ data-name=parent_id]","#list-category").editable({
			source: {{ json_encode($arr_category) }}
		});
	},
});


</script>
@stop

