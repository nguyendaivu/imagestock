<div id="configure-add-div" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">Add Configure</h4>
            </div>
            <div class="modal-body form">
                <form id="configure-add-form" action="javascript:void(0)" method="POST" class="form-horizontal form-row-seperated">
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
                                <input type="text" name="cname" value="" class="form-control"/>
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
                                <input type="text" name="ckey" value="" class="form-control"/>
                            </div>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="col-sm-4 control-label">Value Type</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select id="value-type" class="form-control">
                                    <option value="text">Text</option>
                                    <option value="file">File</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="text-value">
                        <label class="col-sm-4 control-label">Value</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                                </span>
                                <input type="text" name="cvalue" value="" class="form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="file-value" style="display: none;">
                        <label class="col-sm-4 control-label">Value</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-file-text"></i>
                                </span>
                                <input type="file" name="cvalue" disabled value="" class="form-control"/>
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
                                <textarea id="description" name="description" row="5" style="resize: none;" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Active</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="checkbox" name="active" checked class="form-control"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="configure-add-submit" class="btn btn-primary"><i class="fa fa-check"></i>Save change</button>
            </div>
        </div>
    </div>
</div>
<div class="portlet light">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#main" data-toggle="tab" aria-expanded="true">
                Main </a>
            </li>
            <li class="">
                <a href="#other" data-toggle="tab" aria-expanded="false">
                Other </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body">
        <div class="tab-content">
            <div class="tab-pane active" id="main">
                {{ Form::open(['method' => 'POST', 'url' => URL.'/admin/configures/update-configure', 'files' => true, 'id' => 'main-configure-form' ]) }}
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <div id="content-message">
                            <i class="fa-lg fa fa-warning"></i>
                            You have some form errors. Please check below.
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-2">Title Site</label>
                        <div class="col-md-10">
                            <input type="text" name="title_site" class="form-control maxlength-handler" maxlength="50"  value="{{ $configure['title_site'] or '' }}"><span class="help-block">
                                        max 50 chars </span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-2">Meta Description</label>
                        <div class="col-md-10">
                            <textarea name="meta_description" class="form-control maxlength-handler" maxlength="250" style="resize:none;" rows="5">{{ $configure['meta_description'] or '' }}</textarea>
                            <span class="help-block">
                                        max 250 chars </span>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="row col-md-6" id="logo-content">
                            <label class="control-label col-md-4">Logo</label>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        @if( isset($configure['main_logo']) )
                                        <img data-origin-src="{{ URL::asset( $configure['main_logo'] ) }}" src="{{ URL::asset( $configure['main_logo'] ) }}"/>
                                        @else
                                        <img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}"/>
                                        @endif
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
                                            <input name="main_logo" id="file" accept="image/*" type="file">
                                        </span>
                                        <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-6">
                            <label class="control-label col-md-4">Favicon</label>
                            <div class="col-md-8">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                        @if( isset($configure['favicon']) )
                                        <img data-origin-src="{{ URL::asset( $configure['favicon'] ) }}" src="{{ URL::asset( $configure['favicon'] ) }}"/>
                                        @else
                                        <img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}"/>
                                        @endif
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
                                            <input name="favicon" id="favicon" accept="image/*" type="file">
                                        </span>
                                        <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
                                        Remove </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label col-md-2">Mask</label>
                        <div class="col-md-10">
                            <input type="text" name="mask" class="form-control" value="{{ $configure['mask'] or URL }}" />
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9 text-right">
                            <button type="submit" class="btn green">Submit</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
            <div class="tab-pane" id="other">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i> Configure Listing
                                </div>
                                <div class="actions">
                                    <a href="#configure-add-div" class="btn default yellow-stripe" data-toggle="modal">
                                        <i class="fa fa-plus"></i>
                                        <span class="hidden-480">New Configure</span>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-striped table-hover table-bordered" id="list-configure">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th>#</th>
                                                <td>Id</td>
                                                <th>Name</th>
                                                <th>Key</th>
                                                <th>Value</th>
                                                <th>Description</th>
                                                <th>Active</th>
                                                <th class="text-center" width="18%">
                                                     {{'Tools'}}
                                                </th>
                                            </tr>
                                            <tr role="row" class="filter">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[cname]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[ckey]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[cvalue]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[cdescription]">
                                                </td>
                                                <td>
                                                    <select name="search[active]" class="form-control form-filter input-sm">
                                                        <option value=""></option>
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
            </div>
        </div>
    </div>
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}">
<style type="text/css">
#configure-add-div .modal-dialog{
    width: 100%;
    margin: 0;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js' ) }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js' ) }}"></script>
<script type="text/javascript">
$(".maxlength-handler").maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});
$('#value-type').change(function(){
    var id = $(this).val();
    var hideId;
    if( id == 'text' ) {
        hideId = 'file';
    } else {
        hideId = 'text';
    }
    $('#'+ hideId +'-value').hide();
    $('#'+ hideId +'-value input').prop('disabled', true);

    $('#'+ id +'-value input').prop('disabled', false);
    $('#'+ id +'-value').show();
});
$("#main-configure-form").validate({
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: false,
    ignore: "",
    messages: {
        select_multi: {
            maxlength: $.validator.format("Max {0} items allowed for selection"),
            minlength: $.validator.format("At least {0} items must be selected")
        }
    },
    rules: {
        title_site: {
            required: true,
        },
        meta_description: {
            required: true,
        },
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#main-configure-form").show();
        Metronic.scrollTo($(".alert-danger","#main-configure-form"), -200);
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
        $(".alert-danger","#main-configure-form").hide();
        this.submit();
    }
});
$("#configure-add-submit").click(function(){
    $("#content-message", "#configure-add-form").html("You have some form errors. Please check below.");
    $("#configure-add-form").submit();
});
$("#configure-add-form").validate({
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: false,
    ignore: "",
    messages: {
        select_multi: {
            maxlength: $.validator.format("Max {0} items allowed for selection"),
            minlength: $.validator.format("At least {0} items must be selected")
        }
    },
    rules: {
        cname: {
            required: true,
        },
        ckey: {
            required: true,
        },
        cvalue: {
            required: true,
        },
    },
    errorPlacement: function(error, element) {
        element.parent().parent().append(error);
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#configure-add-form").show();
        Metronic.scrollTo($(".alert-danger","#configure-add-form"), -200);
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
        var form = $("#configure-add-form");
        var data = new FormData();
        $("input, textarea", form).not(':disabled').each(function(){
            var name = $(this).attr('name');
            var value = $(this).val();
            if( name ) {
                data.append(name, value);
            }
        });
        if( $("input[type=file]", form).not(':disabled').length ) {
            data.append('cvalue', $("input[type=file]", form).not(':disabled')[0].files[0]);
        }
        $(".alert-danger", form).hide();
        $.ajax({
            url: "{{ URL.'/admin/configures/update-configure' }}",
            type: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function(result) {
                if( result.status == "ok" ) {
                    $("input, textarea", form).val("");
                    $("[name=active]", form).prop("checked", true);
                    $("#configure-add-div").modal("hide");
                    $("#cancel-button").trigger("click");
                    toastr.success(result.message, "Message");
                } else {
                    $("#content-message", form).html(result.message);
                    $(".alert-danger", form).show();
                }
            }
        });
    }
});
var columnDefs = [
        {
            "targets": 2,
            "name"  : "cname",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="cname" data-type="text" data-pk="'+ row[1] +'" data-url="{{ URL.'/admin/configures/update-configure' }}">'+ row[2] +'</a>';
            }
        },
        {
            "targets": 3,
            "name"  : "ckey",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="ckey" data-type="text" data-pk="'+ row[1] +'" data-url="{{ URL.'/admin/configures/update-configure' }}">'+ row[3] +'</a>';
            }
        },
        {
            "targets": 4,
            "name"  : "ckey",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="cvalue" data-type="textarea" data-pk="'+ row[1] +'" data-url="{{ URL.'/admin/configures/update-configure' }}">'+ row[4] +'</a>';
            }
        },
        {
            "targets": 5,
            "name"  : "cdescription",
            "data" : function(row, type, val, meta) {
                return '<a href="javascript:void(0)" class="xeditable-input" data-escape="true" data-name="cdescription" data-type="textarea" data-pk="'+ row[1] +'" data-url="{{ URL.'/admin/configures/update-configure' }}">'+row[5]+'</a>';
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
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[6]+'" data-pk="'+ row[1] +'" data-value="'+ row[6] +'" data-url="{{ URL.'/admin/configures/update-configure' }}" data-title="Active">'+ html +'</a>';
            }
        },
    ];
listRecord({
    url: "{{ URL.'/admin/configures/list-configure' }}",
    delete_url: "{{ URL.'/admin/configures/delete-configure' }}",
    table_id: "#list-configure",
    columnDefs: columnDefs,
    pageLength: 20,
    fnDrawCallback: function(){
        $("a.xeditable-input","#list-configure").editable({
            success: function(response, newValue){
                if( response.status == "ok" ) {
                    toastr.success(response.message, 'Message');
                } else {
                    return response.message;
                }
            }
        });
        $(".xeditable-select[data-name=active]","#list-configure").editable({
            source: [{value: 1, text: "Yes"},{value: 0, text: "No"}]
        });
    },
});
</script>
@stop
