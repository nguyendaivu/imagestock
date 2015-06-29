<div class="portlet">
{{ Form::open([
        'url'   => URL.'/admin/email-templates/update-template',
        'id'    => 'form-template',
        'method'=> 'POST',
        'class' => 'form-horizontal'
        ]) }}
    <div class="portlet-title">
        <div class="actions btn-set text-right">
            <a class="btn default" href="{{ URL.'/admin/email-templates' }}"><i class="fa fa-angle-left"></i> Back</a>
            <button class="btn default" type="reset"><i class="fa fa-reply"></i> Reset</button>
            <button class="btn green" type="submit"><i class="fa fa-check"></i> Save</button>
            <button class="btn green" type="submit" name="continue" value="continue"><i class="fa fa-check-circle"></i> Save &amp; Continue Edit</button>
            @if( isset($template['id']) )
            <div class="btn-group">
                <a class="btn yellow dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-share"></i> More <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu pull-right">
                    <li>
                        <a onclick="deleteRecord({ 'deleteUrl' : '{{ URL.'/admin/email-templates/delete-template/'.$template['id'] }}', returnUrl : '{{ URL.'/admin/email-templates' }}' })" href="javascript:void(0)">
                            Delete </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
    <div class="portlet-body form">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#general" data-toggle="tab">
                        General </a>
                </li>
                <li>
                    <a href="#template" data-toggle="tab">
                        Template </a>
                </li>
            </ul>
            <div class="tab-content no-space">
                <div class="tab-pane active" id="general">
                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            <div id="content-message">
                                You have some form errors. Please check below.
                            </div>
                        </div>
                        @if( isset($template['id']) )
                        <input type="hidden" name="id" value="{{ $template['id'] }}">
                        @endif
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4">{{ 'Name' }}</label>
                                <div class="col-md-8">
                                    <input type="text" name="name" data-required="1" class="form-control" placeholder="" value="{{ $template['name'] or ''; }}">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label col-md-4">{{ 'Type' }}</label>
                                <div class="col-md-8">
                                    <select name="type" class="form-control">
                                        <option value="Default">Default</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group  col-md-6">
                                <label class="col-md-4 control-label">Active
                                </label>
                                <div class="col-md-8">
                                    <input type="checkbox" class="form-control" name="active" {{ !isset($template['active']) || $template['active'] ? 'checked' : '' }} />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="template">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="control-label col-md-2">{{ 'Field' }}</label>
                                <div class="col-md-10 field-button">
                                    <button type="button" class="btn btn-info" contenteditable="false" unselectable="on" rel="[CUSTOMER_NAME]">Customer Name</button>
                                    <button type="button" class="btn yellow" contenteditable="false" unselectable="on" rel="[LINK]">Link</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group  col-md-12">
                                <label class="control-label col-md-2">Template</label>
                                <div class="col-md-10">
                                    <textarea id="content" name="content">{{ $template['content'] or '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/plugins/select2/select2.css' ) }}" rel="stylesheet" type="text/css"/>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/admin/js/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
$("#form-template").validate({
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
        name: {
            required: true,
        },
        type: {
            required: true,
        },
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

CKEDITOR.config.contentsCss = "{{ URL::asset( 'assets/global/css/components.css') }}";
CKEDITOR.replace("content");
$("button",".field-button").click(function(){
    var html = $(this);
    CKEDITOR.instances.content.insertHtml(html[0].outerHTML);
});
</script>
@stop

