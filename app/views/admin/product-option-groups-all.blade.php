<div id="option-group-add-div" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Option Group</h4>
            </div>
            <div class="modal-body form">
                <form id="option-group-add-form" action="javascript:void(0)" method="POST" class="form-horizontal form-row-seperated">
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
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-file-text-o"></i>
                                </span>
                                <input type="text" id="name" name="name" value="" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Key</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-key"></i>
                                </span>
                                <input type="text" id="key" name="key" value="" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group last">
                        <label class="col-sm-4 control-label">Description</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-info"></i>
                                </span>
                                <textarea id="description" name="description" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="option-group-add-submit" class="btn btn-primary"><i class="fa fa-check"></i>Save change</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa icon-notebook"></i>{{ 'Product Option Listing' }}
                </div>
                <div class="actions">
                    <a href="#option-group-add-div" class="btn default yellow-stripe" data-toggle="modal">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">{{ 'New Product Option' }}</span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-product-option-groups">
                        <thead>
                            <tr role="row" class="heading">
                                <th>#</th>
                                <td>Id</td>
                                <th>Name</th>
                                <th>Key</th>
                                <th>Description</th>
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
                                    <input type="text" class="form-control form-filter input-sm" name="search[key]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[description]">
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
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js' ) }}"></script>
<script type="text/javascript">
var columnDefs = [
        {
            "targets": 2,
            "name"  : "name",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="name" data-type="text" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/product-option-groups/update-product-option-group' }}">'+row[2]+'</a>';
            }
        },
        {
            "targets": 3,
            "name"  : "key",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="key" data-type="text" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/product-option-groups/update-product-option-group' }}">'+row[3]+'</a>';
            }
        },
        {
            "targets": 4,
            "name"  : "description",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="description" data-type="textarea" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/product-option-groups/update-product-option-group' }}">'+row[4]+'</a>';
            }
        },
    ];
listRecord({
    url: "{{ URL.'/admin/product-option-groups/list-product-option-group' }}",
    delete_url: "{{ URL.'/admin/product-option-groups/delete-product-option-group' }}",
    delete_message: "Delete this group will also delete all of options belong to it.<br />Are you sure to do this?",
    table_id: "#list-product-option-groups",
    columnDefs: columnDefs,
    pageLength: 20,
    fnDrawCallback: function(){
        $("a.xeditable-input","#list-product-option-groups").editable({
            success: function(response, newValue){
                if( response.status == "ok" ) {
                    toastr.success(response.message, 'Message');
                } else {
                    return response.message;
                }
            }
        });
    },
});
$("#option-group-add-submit").click(function(){
    $("#content-message","#option-group-add-form").html("You have some form errors. Please check below.");
    $("#option-group-add-form").submit();
});
$("#option-group-add-form").validate({
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
        name: {
            required: true,
            minlength: 6
        },
        key: {
            required: true,
            minlength: 4
        },
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#option-group-add-form").show();
        Metronic.scrollTo($(".alert-danger","#option-group-add-form"), -200);
    },
    errorPlacement: function(error, element) {
        element.parent().parent().append(error);
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
        $(".alert-danger","#option-group-add-form").hide();
        $.ajax({
            url: "{{ URL.'/admin/product-option-groups/update-product-option-group' }}",
            type: "POST",
            data: $("input,textarea", "#option-group-add-form").serialize(),
            success: function(result){
                if( result.status == "error" ) {
                    $("#content-message","#option-group-add-form").html(result.message);
                    $(".alert-danger","#option-group-add-form").show();
                } else {
                    $("#option-group-add-div").modal("hide");
                    $("input, textarea","#option-group-add-form").val("");
                    toastr.success(result.message, 'Message');
                    $("#cancel-button").trigger("click");
                }
            }
        });
    }
});
</script>
@stop