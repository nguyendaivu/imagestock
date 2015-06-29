<div class="portlet">
    {{ Form::open(array('url'=>URL.'/admin/users/update-user', 'files'=>true , 'method'=> 'POST', 'class'=> 'form-horizontal', 'id'=> 'user-form') ) }}
        <?php
            if(Session::has('_old_input')) {
                $user = Session::get('_old_input');
                unset($user['password'],$user['password_confirmation']);
            }
        ?>
        <div class="portlet-title">
            <div class="actions btn-set text-right">
                <a class="btn default"  href="{{ URL.'/admin/users' }}"><i class="fa fa-angle-left"></i> Back</a>
                <button class="btn default" type="reset"><i class="fa fa-reply"></i> Reset</button>
                <button class="btn green" type="submit"><i class="fa fa-check"></i> Save</button>
                <button class="btn green" type="submit" name="continue" value="continue"><i class="fa fa-check-circle"></i> Save &amp; Continue Edit</button>
                @if( isset($user['id']) )
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
                            <a href="javascript:void(0)" onclick="deleteRecord({ 'deleteUrl' : '{{ URL.'/admin/users/delete-user/'.$user['id'] }}', returnUrl : '{{ URL.'/admin/users' }}' })">
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
                        <a href="#tab_account" data-toggle="tab">
                        Account infomation </a>
                    </li>
                    <li>
                        <a href="#tab_person" data-toggle="tab">
                        Personal information</a>
                    </li>
                </ul>
                <div class="tab-content no-space">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <div id="content-message">
                            You have some form errors. Please check below.
                        </div>
                    </div>
                    <div class="tab-pane active" id="tab_account">
                        <div class="form-body">
                            @if(isset($user['id']))
                            <input type="hidden" name="id" value="{{ $user['id'] }}">
                            @endif
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Email</label>
                                    <div class="col-md-8">
                                        <input type="email" name="email" class="form-control" placeholder="" value="{{ $user['email'] or '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Confirm password</label>
                                    <div class="col-md-8">
                                        <input type="password" name="password_confirmation" class="form-control" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label col-md-4">Active</label>
                                    <div class="col-md-8">
                                        <input type="checkbox" class="form-control" name="active" {{ !isset($user['active']) || $user['active'] ? 'checked' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_person">
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class=" col-md-12">Image</label>
                                    <div class="col-md-12">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                @if( isset($user['image']) && !empty($user['image']) )
                                                <img data-origin-src="{{ URL::asset($user['image']) }}" src="{{ URL::asset($user['image']) }}" alt=""/>
                                                @else
                                                <img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" alt=""/>
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                            </div>
                                            <div>
                                                <span class="btn default btn-file">
                                                    <span class="fileinput-new">
                                                    Select image </span>
                                                    <span class="fileinput-exists">
                                                    Change </span>
                                                    <input type="file" name="image">
                                                </span>
                                                <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
                                                Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="row form-group ">
                                        <label class="control-label col-md-4">First name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="first_name" class="form-control" placeholder="" value="{{ $user['first_name'] or '' }}">
                                        </div>
                                    </div>
                                    <div class="row form-group ">
                                        <label class="control-label col-md-4">Last name</label>
                                        <div class="col-md-8">
                                            <input type="text" name="last_name" class="form-control" placeholder="" value="{{ $user['last_name'] or '' }}">
                                        </div>
                                    </div>
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
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}">
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>

<script type="text/javascript">
$("#user-form").validate({
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
        @if( !isset($user['id']) )
        password: {
            minlength: 6,
            required: true
        },
        @endif
        email: {
            required: true,
            email: true
        },
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#user-form").show();
        Metronic.scrollTo($(".alert-danger","#user-form"), -200);
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
        $(".alert-danger","#user-form").hide();
        this.submit();
    }
});
@stop
