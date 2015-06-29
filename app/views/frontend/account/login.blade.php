@section('body')
<body class="page-the-profound-aesthetic-academy customer-logged-in template-page">
@stop
<header class="row">
    <div class="left columns large-6">
        <h1 class="page-title">Login</h1>
    </div>
    <div class="row show-for-medium-up">
        <div class="columns">
            <ul class="breadcrumbs colored-links">
                <li><a href="{{ URL }}">Home</a></li>
                <li><a href="javascript:void(0)">User</a></li>
                <li><a href="{{ URL }}/user/login">Login</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="row account-content">
	<div class="large-4 columns">
		<form action="{{ URL }}/user/login" method="post" accept-charset="utf-8">
			<?php
				$login = Session::has('_old_input')?Session::get('_old_input'):array();
			?>
			<div id="login_div" style="{{ Session::has('forgot')?'display:none':'' }}">
			       <label for="email" class="label">Username or Email</label>
			       <input type="text" name="email" id="email" value="{{ isset($login['email']) ? $login['email'] : '' }}" placeholder="Your email" autocomplete="off"/>
			       <label for="email" class="label">Password</label>
			       <input type="password" name="password" id="password" value="{{ isset($login['password']) ? $login['password'] : '' }}" placeholder="" autocomplete="off"/>
			       <input type="hidden" name="redirect_url" value="<?php
			       		if(Input::has('redirect_url')){
			       			echo Input::get('redirect_url');
			       		}else{
			       			if(isset($login['redirect_url'])){
				       			echo $login['redirect_url'];
				       		}else{
				       			echo '';
				       		}
			       		}
			       ?>">
			       <label for="email" class="label">
			       <input type="checkbox" name="remember" {{ isset($login['remember']) ? 'checked' : '' }} value="1"/>Remember</label>
			       <p><a href="javascript:forgot_password();" title="Forgot your password">Forgot your password?</a></p>
			       <button type="submit">Login</button> &nbsp; or &nbsp; <a href="{{ URL }}/user/signup" title="Register a new account">Register a new account</a>
			</div>
		</form>
		<form action="{{ URL }}/user/forgot_password" method="post" accept-charset="utf-8">
			<div id="forgot_pass_div" style="{{ Session::has('forgot')?'':'display:none' }}">
				<label for="email" class="label">Username or Email</label>
			       	<input type="email" name="email" id="email_forgot" value="" placeholder="Your email" autocomplete="off" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
			       	<button type="submit" id="btn_forgot_password">Submit</button> &nbsp; or &nbsp; <a href="javascript:backto_login();" title="Back to login">Back to login</a>
			</div>
		</form>
			<div class="error">
			       		{{ Session::has('error')?Session::pull('error'):'' }}
			</div>
		
	</div>
</div>
@section('pageJS')
	<script>
                               function forgot_password(){
                               		$("#login_div").hide(50);
                               		$("#forgot_pass_div").show(50);
                               		$(".error").fadeOut(1000);
                               }

                               function backto_login(){
                               		$("#login_div").show(50);
                               		$("#forgot_pass_div").hide(50);
                               		$(".error").fadeOut(1000);
                               }
	</script>
@stop

