<div class="portlet light">
    <div class="portlet-title tabbable-line">
        <ul class="nav nav-tabs">
            <li class="active">
                <a href="#template" data-toggle="tab">
                    <i class="icon-envelope-open"></i>
                    Email Template </a>
            </li>
            <li>
                <a href="#setting" data-toggle="tab">
                    <i class="icon-settings"></i>
                    Email Setting </a>
            </li>
        </ul>
    </div>
    <div class="portlet-body ">
        <div class="tab-content">
            <div class="tab-pane active" id="template">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-envelope-o"></i>Template Listing
                                </div>
                                <div class="actions">
                                    <a href="{{ URL }}/admin/email-templates/add-template" class="btn default yellow-stripe">
                                        <i class="fa fa-plus"></i>
                                        <span class="hidden-480">New Template</span>
                                    </a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <table class="table table-striped table-hover table-bordered" id="list-template">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th>
                                                    #
                                                </th>
                                                <th>
                                                    Id
                                                </th>
                                                <th>
                                                     Name
                                                </th>
                                                <th>
                                                     Type
                                                </th>
                                                <th>
                                                     Active
                                                </th>
                                                <th class="text-center" width="18%">
                                                     Tools
                                                </th>
                                            </tr>
                                            <tr role="row" class="filter">
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[name]">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-filter input-sm" name="search[type]">
                                                </td>
                                                <td>
                                                    <select name="search[active]" class="form-control form-filter input-sm">
                                                        <option value="">Select...</option>
                                                        <option value="yes">Yes</option>
                                                        <option value="no">No</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button id="search-button" class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i>Search</button>
                                                    <button id="cancel-button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i>Reset</button>
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
            <div class="tab-pane" id="setting">
                <div class="portlet">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-cogs"></i>Email Configure
                        </div>
                    </div>
                    <div class="portlet-body form">
                        {{ Form::open([
                                        'url'   => URL.'/admin/email-templates/update-email',
                                        'id'    => 'form-email',
                                        'method'=> 'POST',
                                        'class' => 'form-horizontal'
                                        ]) }}
                        <div class="form-body">
                            <div class="alert alert-danger display-hide">
                                <button class="close" data-close="alert"></button>
                                <div id="content-message">
                                    You have some form errors. Please check below.
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Username</label>
                                    <div class="col-md-8">
                                        <input type="email" name="username" data-required="1" class="form-control" placeholder="email@anvydigital.com" value="{{ $email['username'] or '' }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Password</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <span class="input-group-addon" id="view-password" >
                                                <i class="fa fa-eye"></i>
                                            </span>
                                            <input type="password" name="password" data-required="1" class="form-control" value="{{ $email['password'] or '' }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Host</label>
                                    <div class="col-md-8">
                                        <input type="text" name="host" data-required="1" class="form-control" placeholder="smtp.google.com" value="{{ $email['host'] or '' }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Port</label>
                                    <div class="col-md-8">
                                        <input type="text" name="port" data-required="1" class="form-control" placeholder="465" value="{{ $email['port'] or '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Encryption</label>
                                    <div class="col-md-8">
                                        <input type="text" name="encryption" data-required="1" class="form-control" placeholder="ssl" value="{{ $email['encryption'] or '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" data-required="1" class="form-control" placeholder="AnvyOnline" value="{{ $email['name'] or '' }}">
                                    </div>
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
            "targets": 4,
            "className": "text-center",
            "name" : "active",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[4] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[4]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/email-templates/update-template' }}" data-title="Active">'+html+'</a>';
            }
        }];
listRecord({
    url: "{{ URL.'/admin/email-templates/list-template' }}",
    delete_url : "{{ URL.'/admin/email-templates/delete-template' }}",
    edit_url : "{{ URL.'/admin/email-templates/edit-template' }}",
    table_id: "#list-template",
    columnDefs: columnDefs,
    fnDrawCallback: function(){
        $(".xeditable-select[data-name=active]","#list-template").editable({
            source: [{value: 1, text: "Yes"},{value: 0, text: "No"}],
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
$("#view-password").mousedown(function() {
    $("input[name=password]").attr("type", "text");
}).mouseup(function() {
    $("input[name=password]").attr("type", "password");
});

$("#form-email").validate({
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
        username: {
            required: true,
            email: true
        },
        password: {
            required: true,
        },
        port: {
            required: true,
            number: true
        },
        host: {
            required: true,
        },
        encryption: {
            required: true,
        }
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#form-email").show();
        Metronic.scrollTo($(".alert-danger","#form-email"), -200);
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
        $(".alert-danger","#form-email").hide();
        this.submit();
    }
});
</script>
@stop