<div class="portlet">
    <form id="role-form" action="{{ URL.'/admin/roles/update-role' }}" method="POST" class="form-horizontal">
        {{ Form::token(); }}
        <?php
            if(Session::has('_old_input')) {
                $role = Session::get('_old_input');
                if( isset($role['arr_permission']) )
                    $arrPermission = json_decode($role['arr_permission']);
            }
        ?>
        <div class="portlet-title">
            <div class="actions btn-set text-right">
                <button name="back" type="button" class="btn default"  onclick="window.location.assign('{{ URL.'/admin/roles' }}')"><i class="fa fa-angle-left"></i> Back</button>
                <button class="btn default" type="reset"><i class="fa fa-reply"></i> Reset</button>
                <button class="btn green" type="submit"><i class="fa fa-check"></i> Save</button>
                <button class="btn green" name="continue" value="continue" type="submit"><i class="fa fa-check-circle"></i> Save &amp; Continue Edit</button>
                @if( isset($role['id']) )
                <div class="btn-group">
                    <a class="btn yellow dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-share"></i> More <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu pull-right">
                        <li>
                            <a href="#">
                            Duplicate </a>
                        </li>
                        <li>
                            <a href="#">
                            Delete </a>
                        </li>
                        <li class="divider">
                        </li>
                        <li>
                            <a href="#">
                            Print </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
        </div>
        <div class="portlet-body form">
            <div class="tabbable">
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <div id="content-message">
                        You have some form errors. Please check below.
                    </div>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#basic-info" data-toggle="tab">
                        Basic infomation </a>
                    </li>
                    <li>
                        <a href="#role" data-toggle="tab">
                        Permissions </a>
                    </li>
                </ul>
                <div class="tab-content no-space">
                    <div class="tab-pane active" id="basic-info">
                        <div class="form-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    @if(isset($arrPermission))
                                    <input hidden="arr_permission" value="{{ json_encode($arrPermission) }}" />
                                    @endif
                                    @if(isset($role['id']))
                                    <input type="hidden" name="id" value="{{ $role['id'] }}">
                                    @endif
                                    <label class="control-label col-md-4">Name</label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" data-required="1" class="form-control" placeholder="" value="{{ $role['name'] or '' }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="role">
                        <div class="table-container">
        					<table class="table table-hover">
        						<thead>
        							<tr>
        								<th width="15%"></th>
        								<th width="2%"></th>
        								<th class="text-center" width="15%">
        									View
        								</th>
                                        <th class="text-center" width="15%">
                                            Create
                                        </th>
        								<th class="text-center" width="15%">
        									Edit
        								</th>
        								<th class="text-center" width="15%">
        									Delete
        								</th>
        							</tr>
        						</thead>
        						<tbody>
        							@foreach($arrController as $controller)
        							<tr>
        								<td>
        									{{ ucfirst($controller) }}
        								</td>
        								<td></td>
                                        <?php $controller = str_replace(' ', '', $controller);  ?>
                                        @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                        <?php if($controller == 'admin' && $action != 'view') continue 2;  ?>
                                        <td class="text-center">
                                            <select name="permission[{{ $controller }}][{{ $action }}]" class="bs-select form-control" data-width="95px">
                                                @foreach(['none' => 'danger','owner' => 'default', 'all' => 'success'] as $type => $class)
                                                <?php if($controller == 'admin' && $type == 'owner') continue;  ?>
                                                <?php if($action == 'create' && $type == 'all') continue;  ?>
                                                <option data-content="<span class='label lable-sm label-{{ $class }}'>{{ ucfirst($type) }}</span>" value="{{$type}}" {{ isset($arrPermission["{$controller}_{$action}_{$type}"]) ? 'selected' : '' }} ></value>
                                                @endforeach
                                            </select>
                                        </td>
                                        @endforeach
        							</tr>
                                    @if( $controller == 'menus' )
                                    @foreach(['menus frontend', 'menus backend'] as $extra)
                                    <tr>
                                        <td>
                                            <i class="fa fa-minus"></i> {{ ucfirst($extra) }}
                                        </td>
                                        <td></td>
                                        <?php $extra = str_replace(' ', '', $extra);  ?>
                                        @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                        <td class="text-center">
                                            <select name="permission[{{ $extra }}][{{ $action }}]" class="bs-select form-control" data-width="95px">
                                                @foreach(['none' => 'danger', 'all' => 'success'] as $type => $class)
                                                <option data-content="<span class='label lable-sm label-{{ $class }}'>{{ ucfirst($type) }}</span>" value="{{$type}}" {{ isset($arrPermission["{$extra}_{$action}_{$type}"]) ? 'selected' : '' }} ></value>
                                                @endforeach
                                            </select>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                    @endif
        							@endforeach
        						</tbody>
        					</table>
        				</div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}"/>
<style type="text/css">
.table-hover > tbody td:first-child {
	border-right: 1px solid #ddd !important;
    font-size: 14px;
    font-weight: 600
}
.bootstrap-select.open {
    z-index: 100;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript">
$(".bs-select").selectpicker({
    iconBase: 'fa',
    tickIcon: 'fa-check'
});
$("#role-form").validate({
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: false,
    ignore: "",
    rules: {
        name: {
            minlength: 4,
            required: true
        },
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#role-form").show();
        Metronic.scrollTo($(".alert-danger","#role-form"), -200);
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
        $(".alert-danger","#role-form").hide();
        form.submit();
    }
});
$("select[name='permission[admin][view]']", "#role").change(function(){
    if( $(this).val() == "none" ) {
        $("select[name!='permission[admin][view]']", "#role").val("none");
        $("select[name!='permission[admin][view]']", "#role").selectpicker("val", "none");
    }
});
$("select[name!='permission[admin][view]']", "#role").change(function(){
    if( $("select[name='permission[admin][view]']", "#role").val() == "none" ) {
        $(this).selectpicker("val", "none");
        $(this).val("none");
    }
});
</script>
@stop

