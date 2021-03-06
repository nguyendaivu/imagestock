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
                        <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
                        Remove </a>
                    </div>
                </div>
                <div class="editable-buttons"><button type="submit" class="btn blue editable-submit"><i class="fa fa-check"></i></button><button type="button" class="btn default editable-cancel"><i class="fa fa-times"></i></button></div>
            </div>
        </div>
    </div>
</div>
<div id="banner-add-div" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Banner</h4>
            </div>
            <div class="modal-body form">
                <form id="banner-add-form" action="javascript:void(0)" method="POST" class="form-horizontal form-row-seperated">
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
                    <div class="form-group last">
                        <label class="col-sm-4 control-label">Image</label>
                        <div class="col-sm-8">
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
                                        <input name="image" accept="image/*" type="file">
                                        <input type="hidden" name="choose" value="0" />
                                    </span>
                                    <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
                                    Remove </a>
                                </div>
                            </div>
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
                <button type="button" id="banner-add-submit" class="btn btn-primary"><i class="fa fa-check"></i>Save change</button>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-credit-card"></i>{{ 'Banner Listing' }}
                </div>
                <div class="actions">
                    <a href="#banner-add-div" data-toggle="modal" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">{{ 'New Banner' }}</span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-banner">
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
                                     Image
                                </th>
                                <th>
                                     Order
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
                                </td>
                                <td>
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
    margin-left: 40%;
    margin-top: 15%;
    overflow-y: auto;
}
#image-div .modal-dialog, #banner-add-div .modal-dialog{
    width: 100%;
    margin: 0;
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
$("#banner-add-submit").click(function(){
    $("#content-message","#banner-add-form").html("You have some form errors. Please check below.");
    $("#banner-add-form").submit();
});
$("#banner-add-form").validate({
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
            minlength: 6
        },
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#banner-add-form").show();
        Metronic.scrollTo($(".alert-danger","#banner-add-form"), -200);
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
        var form = $("#banner-add-form");
        $(".alert-danger", form).hide();
        var name        = $("[name=name]", form).val();
        var order_no    = $("[name=order_no]", form).val();
        var active    = $("[name=active]", form).is(":checked");
        var ajaxConfig  = {
                            url : "{{ URL }}/admin/banners/update-banner",
                            type: "POST",
                            success: function(result) {
                                if( result.status == "error" ) {
                                    $("#content-message", form).html(result.message);
                                    $(".alert-danger", form).show();
                                } else {
                                    $("#banner-add-div").modal("hide");
                                    $("[name=name]", form).val("");
                                    $("img", form).attr("src", $("img", form).attr("data-origin-src"));
                                    $("[name=image]", form).val("");
                                    $("[name=active]", form).prop("checked", true);
                                    $("#spinner-content", form).spinner({ value : 1});
                                    toastr.success(result.message, 'Message');
                                    $("#cancel-button").trigger("click");
                                }
                            }
                        };
        var files = $("[name=image]", "#banner-add-form")[0].files;
        var process = false;
        if( files && files.length ) {
            var data = new FormData();
            data.append("image", files[0]);
            data.append("name", name);
            data.append("order_no", order_no);
            if( active ) {
                data.append("active", 1);
            }
            ajaxConfig["contentType"] = false;
            ajaxConfig["processData"] = false;
            process      = true;
        }
        if( process ) {
            ajaxConfig["data"] = data;
            $.ajax(ajaxConfig);
        } else {
            toastr.warning("Please upload image to continue.", "Warning");
        }
    }
});
$(".editable-submit", "#image-div").click(function(){
    var id          = parseInt($("[name=id]", "#image-div").val());
    var ajaxConfig  = {
                        url : "{{ URL }}/admin/banners/update-banner",
                        type: "POST",
                        success: function(result) {
                            if( result.status == "ok" ) {
                                $("img[data-id="+ id +"]", "#list-banner").attr("src", result.path);
                                $("a.fileinput-exists", "#image-div").trigger("click");
                                $(".editable-cancel", "#image-div").trigger("click");
                                toastr.success(result.message, "Message");
                            } else {
                                toastr.error(result.message, "Error");
                            }
                        }
                    };
    var files = $("[name=file]", "#image-div")[0].files;
    var process = false;
    if( files && files.length ) {
        var data = new FormData();
        data.append("image", files[0]);
        data.append("pk", id);
        data.append("name", "image");
        ajaxConfig["contentType"] = false;
        ajaxConfig["processData"] = false;
        process      = true;
    }
    if( process ) {
        ajaxConfig["data"] = data;
        $.ajax(ajaxConfig);
    } else {
        $("a.fileinput-exists", "#image-div").trigger("click");
        $(".editable-cancel", "#image-div").trigger("click");
    }

});
$(".editable-cancel", "#image-div").click(function(){
    $("[name=file]", "#image-div").val("");
    $("#image-div").modal("hide");
});
var columnDefs = [
{
            "targets": 2,
            "name"  : "name",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="name" data-type="textarea" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/banners/update-banner' }}" data-title="Name">'+row[2]+'</a>';
            }
        },
        {
            "targets": 3,
            "className" : "text-center",
            "orderable": false,
            "name"  : "image",
            "data" : function(row, type, val, meta) {
                var html = '<img onclick="imageEditable(this)" data-id="'+row[1]+'" src="{{ URL }}/assets/images/noimage/110x110.gif" style="width: 110px;" />';
                if( row[3] ){
                    html = '<img onclick="imageEditable(this)" data-id="'+row[1]+'" src="{{ URL }}/'+row[3]+'" style="width: 110px;" />';
                }
                return html;
            }
        },
        {
            "targets": 4,
            "className" : "text-center",
            "name"  : "order_no",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="order_no" data-type="number" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/banners/update-banner' }}" data-title="Order">'+ row[4] +'</a>';
            }
        },
        {
            "targets": 5,
            "className" : "text-center",
            "name"  : "active",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[5] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[5]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/banners/update-banner' }}" data-title="Active">'+ html +'</a>';
            }
        },
    ];
listRecord({
    url: "{{ URL.'/admin/banners/list-banner' }}",
    delete_url : "{{ URL.'/admin/banners/delete-banner' }}",
    table_id: "#list-banner",
    columnDefs: columnDefs,
    fnDrawCallback: function(){
        $(".xeditable-input","#list-banner").editable();
        $(".xeditable-textarea","#list-banner").editable();
        $(".xeditable-select","#list-banner").editable({
            source: [{value: 1, text: "Yes"},{value: 0, text: "No"}]
        });
    },
});

function imageEditable(object)
{
    var src = $(object).attr("src");
    var id = $(object).attr("data-id");
    $("img", "#image-div").attr("src", src);
    $("[name=id]", "#image-div").val(id);
    $("#image-div").modal("show");
}
</script>
@stop

