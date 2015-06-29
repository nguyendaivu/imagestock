<!-- Fixed navbar -->
<nav class="navbar navbar-default navbar-menu">
  <div class="container">
	
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	  </button>
	  <div class="mobile_logo">
	  <a class="navbar-brand" href="#">
		  <img src="{{URL}}/assets/images/logo2.png" alt="logo" />
	  </a>
	  </div>
	</div>

	<div id="navbar" class="collapse navbar-collapse">
	  <ul class="nav navbar-nav" id="left_menu">
		<li class="dropdown active">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Images <span class="caret"></span></a>
		  <ul class="dropdown-menu" role="menu">
			<li><a href="{{ URL }}/photos">Photos</a></li>
			<li><a href="{{ URL }}/vectors">Vectors</a></li>
			<li><a href="{{ URL }}/editorial">Editorial</a></li>
		  </ul>
		</li>
	  </ul>
	  <?php 
	  	$user = Auth::user()->user();
	  ?>
	@if($user)

	  <ul class="nav navbar-nav navbar-right">
		<li class="dropdown active">
			<a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Hi, {{ $user->first_name.' '.$user->last_name }} <span class="caret"></span></a>
			<ul class="dropdown-menu" role="menu">
				<li><a href ="{{URL}}/order"><span class="fa fa-list"></span>&nbsp; Orders</a></li>
                <li><a href ="{{URL}}/upload"><span class="fa fa-upload"></span>&nbsp; Uploads</a></li>
                <li><a href ="{{URL}}/lightbox"><span class="fa fa-lightbulb-o"></span>&nbsp; Lightboxes</a></li>
                <li><a href ="{{URL}}/account/profile"><span class="fa fa-user"></span> Account Details</a></li>
				<!--<li><a href ="#"><span class="fa fa-download"></span> Download History</a></li>-->
				<li><a href ="{{URL}}/account/signout"><span class="fa fa-sign-out"></span> Sign out</a></li>
			</ul>
		</li>
		<li><a href ="#"><span class="fa fa-info-circle"></span> View Plans &amp; Pricing </a></li>
	</ul>
	@else
	  <ul class="nav navbar-nav navbar-right">
	  	<li><a href ="#">Start Downloading <span class="fa fa-chevron-circle-right"></span></a></li>
		<li class="dropdown active">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Sign in <span class="caret"></span></a>
			<ul class   ="dropdown-menu" role="menu">
				<li style="  width: 300px;">
					<div class="col-md-12">
						<form name="formSignin" action="{{ URL::route('account-sign-in-post') }}" method="post" class="form-signin" style="border-bottom: 1px solid #e7e7e7;margin-bottom: 15px;">
						
							<div class="form-group">
								<label class="control-label">E-mail:</label>
								<input type="email" name="emailLogin" value="{{ Input::old('emailLogin') }}" placeholder="Your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" required autofocus> 
								@if($errors->has('emailLogin'))
								<div class="has-error" style="color:#a94442;">{{ $errors->first('emailLogin')}}</div>
								@endif
							</div>
							
							<div class="form-group">
								<label class="control-label">Password:</label> 
								<input type="password" name="passwordLogin" class="form-control" required> 
								@if($errors->has('passwordLogin'))
								<div class="has-error" style="color:#a94442;">{{ $errors->first('passwordLogin')}}</div>
								@endif
							</div>
							<div class="form-group">
								<div class="checkbox">
									<label class="checkbox pull-left">
									<input type="checkbox" value="remember-me">
									Remember me
									</label>
								</div>
							</div>
							<br /><br />
							<button class="btn btn-primary" type="submit">Sign in</button>
							<!--<span><a href="{{URL}}/account/fogotpassword">Forgot your password?</a></span>-->
							{{ Form::token() }}
						
						</form>
						<strong>Not Registered?</strong>
						<p><a href="{{URL}}/account/create">Create a Free Browse Account</a></p>
					   </div>
					   <hr/>

				</li>
			</ul>
		</li>
	  </ul>
	@endif
    <ul class="nav navbar-nav navbar-right">
    	<li><a href="/cart"><span class="glyphicon glyphicon-shopping-cart"></span>&nbsp;Your Cart</a></li>
	</ul>      
    
	</div><!--/.nav-collapse -->
  </div>
</nav>
