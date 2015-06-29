<div class="portlet">
    {{ Form::open(array('url'=>URL.'/admin/pages/update-page', 'method'=> 'POST', 'class'=> 'form-horizontal', 'id'=> 'page-form') ) }}
        <div class="portlet-title">
            <div class="actions btn-set text-right">
                <a class="btn default"  href="{{ URL.'/admin/pages' }}"><i class="fa fa-angle-left"></i> Back</a>
                <button class="btn default" type="reset"><i class="fa fa-reply"></i> Reset</button>
                <button class="btn green" type="submit"><i class="fa fa-check"></i> Save</button>
                <button class="btn green" type="submit" name="continue" value="continue"><i class="fa fa-check-circle"></i> Save &amp; Continue Edit</button>
                @if( isset($page['id']) )
                <div class="btn-group">
                    <a class="btn yellow dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-share"></i> More <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="javascript:void(0)">
                            Duplicate </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" onclick="deleteRecord({ 'deleteUrl' : '{{ URL.'/admin/pages/delete-page/'.$page['id'] }}', returnUrl : '{{ URL.'/admin/pages' }}' })">
                            Delete </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                            Print </a>
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
                        <a href="#main" data-toggle="tab">
                        Main </a>
                    </li>
                    <li>
                        <a href="#meta" data-toggle="tab">
                        Meta </a>
                    </li>
                    <li>
                        <a href="#content" data-toggle="tab">
                        Content</a>
                    </li>
                </ul>
                <div class="tab-content no-space">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <div id="content-message">
                            You have some form errors. Please check below.
                        </div>
                    </div>
                    <div class="tab-pane active" id="main">
                        <div class="form-body col-md-9 left">
                            @if(isset($page['id']))
                            <input type="hidden" name="id" value="{{ $page['id'] }}">
                            @endif
                            <div class="form-group">
                                <label class="col-md-2 control-label">Name<span class="required">
                                * </span>
                                </label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" name="name" value="{{ $page['name'] or '' }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Include on Menu
                                </label>
                                <div class="col-md-10">
                                    <input type="checkbox" class="form-control" name="on_menu" {{ isset($page['menu_id']) && $page['menu_id'] ? 'checked' : '' }} />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Active
                                </label>
                                <div class="col-md-10">
                                    <input type="checkbox" class="form-control" name="active" {{ !isset($page['active']) || $page['active'] ? 'checked' : '' }} />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="meta">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="col-md-2 control-label">Meta Title</label>
                                <div class="col-md-10">
                                    <input type="text" class="form-control maxlength-handler" name="meta_title" value="{{ $page['meta_title'] or '' }}" maxlength="50" placeholder="">
                                    <span class="help-block">
                                    max 50 chars </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Meta Description</label>
                                <div class="col-md-10">
                                    <textarea class="form-control maxlength-handler" rows="8" name="meta_description" maxlength="255">{{ $page['meta_description'] or '' }}</textarea>
                                    <span class="help-block">
                                    max 255 chars </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="content">
                        <div class="form-body">
                            <iframe id="content-builder" src="{{ URL.'/admin/pages/content-builder/'.( isset($page['id']) ? $page['id'] : 0 ) }}" style="border: none; width: 100%; min-height: 500px;"></iframe>
                            <input type="hidden" id="content" name="content" value="{{ isset($page['content']) ? e($page['content']) : '' }}";
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{ Form::close() }}
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/content-builder/css/contentbuilder.css' ) }}">
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js' ) }}" type="text/javascript"></script>
<script type="text/javascript">
var contentBuilder = document.getElementById("content-builder").contentWindow;
setTimeout(function(){
    autoResize();
}, 500);
$("#page-form").validate({
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
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#page-form").show();
        Metronic.scrollTo($(".alert-danger","#page-form"), -200);
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
        $(".alert-danger","#page-form").hide();
        var html = contentBuilder.getContent();
            html = htmlEntities(html);
        $("input#content").val(html);
        this.submit();
    }
});
$(".maxlength-handler").maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});

function autoResize()
{
    setInterval(function(){
        $("#content-builder").css("height", contentBuilder.getHeight() + "px");
    }, 500);
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
</script>
@stop
