<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8"/>
<title>Metronic | Lock Screen</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<meta content="" name="description"/>
<meta content="" name="author"/>
<link href="{{ URL::asset( 'assets/global/plugins/font-awesome/css/font-awesome.min.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/simple-line-icons/simple-line-icons.min.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/bootstrap/css/bootstrap.min.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/uniform/css/uniform.default.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/admin/pages/css/lock.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/css/components.css' ) }}" id="style_components" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/admin/layout/css/layout.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/admin/layout/css/themes/default.css' ) }}" rel="stylesheet" type="text/css" id="style_color"/>
<link href="{{ URL::asset( 'assets/admin/layout/css/custom.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/admin/layout/css/google-font.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-toastr/toastr.min.css' )}}" rel="stylesheet" type="text/css"/>
<link rel="shortcut icon" href="{{ URL::asset( 'assets/admin/layout/img/favicon.png') }}"/>
</head>
<body>
<div class="page-lock">
	<div class="page-logo">
		<a class="brand" href="index-2.html">
		<img src="{{ URL::asset( 'assets/admin/layout/img/logo-big.png' ) }}" alt="logo"/>
		</a>
	</div>
	<div class="page-body">
		<div class="lock-head">
			 Locked
		</div>
		<div class="lock-body">
			<div class="pull-left lock-avatar-block">
				<img src="{{ empty($admin->image) ? URL.'/assets/images/noimage/110x110.gif' : URL.'/'.$admin->image }}" class="lock-avatar">
			</div>
			<form id="lock-form" class="lock-form pull-left" method="POST" action="javascript:void(0)">
				<h4>{{ $admin->first_name.' '.$admin->last_name }}</h4>
				<div class="form-group">
					<input class="form-control placeholder-no-fix" type="password" autocomplete="off" name="password"/>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success uppercase">Login</button>
				</div>
			</form>
		</div>
		<div class="lock-bottom">
			<a href="{{ URL.'/admin/logout' }}">Not {{ $admin->first_name.' '.$admin->last_name }}?</a>
		</div>
	</div>
	<div class="page-footer-custom">
		2015 © <a href="http://anvyonline.com" target="_blank">AnvyOnline</a> - <a href="http://anvydigital.com" target="_blank">AnvyDigital</a>.
	</div>
</div>
<!--[if lt IE 9]>
<script src="{{ URL::asset( 'assets/global/plugins/respond.min.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/excanvas.min.js' ) }}"></script>
<![endif]-->
<script src="{{ URL::asset( 'assets/global/plugins/jquery.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/plugins/jquery-migrate.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/plugins/bootstrap/js/bootstrap.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/plugins/jquery.blockui.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/plugins/uniform/jquery.uniform.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/plugins/backstretch/jquery.backstretch.min.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/global/scripts/metronic.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/admin/layout/scripts/backend.js' ) }}" type="text/javascript"></script>
<script src="{{ URL::asset( 'assets/admin/layout/scripts/layout.js' ) }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script src="{{URL::asset( 'assets/admin/pages/scripts/ui-toastr.js') }}"></script>
<script>
Metronic.init();
Layout.init();
Backend.init();
	$.backstretch([
    "{{ URL::asset( 'assets/admin/pages/media/bg/1.jpg' ) }}",
    "{{ URL::asset( 'assets/admin/pages/media/bg/2.jpg' ) }}",
    "{{ URL::asset( 'assets/admin/pages/media/bg/3.jpg' ) }}",
    "{{ URL::asset( 'assets/admin/pages/media/bg/4.jpg' ) }}"
    ], {
      fade: 1000,
      duration: 8000
});
toastr.options = {
	"preventDuplicates": true,
};
$.ajaxSetup({
    headers: {
        'X-CSRF-Token': '{{ csrf_token() }}'
    }
});
$('#lock-form').submit(function(event){
	event.preventDefault();
	var password = $('[name=password]', this).val();
	if( password ) {
		var data = {password : $('[name=password]', this).val()};
		$.ajax({
			url: '{{ URL }}/admin/lock',
			type: 'POST',
			data: data,
			success: function(result) {
				if( result.status == 'error' ) {
					$('#lock-form [name=password]').val('');
					toastr.error(result.message, 'Error');
				} else {
					location.reload();
				}
			}
		});
	} else {
		toastr.error('Password cannot be empty.', 'Error');
	}
});
</script>
</body>
</html>