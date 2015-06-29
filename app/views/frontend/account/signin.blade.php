


    <div class="row">
        <div class="col-sm-4 col-md-8 col-md-offset-2">
    	<h1 class="text-center" style="font-size:24px">Sign in</h1>
        <div class="account-wall">
            <form name="formSignin" action="{{ URL::route('account-sign-in-post') }}" method="post" class="form-signin">
         
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
         		 <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                
                    {{ Form::token() }}
        
            </form>
        </div>        
        <br />
<!--        
        <div style="text-align:center">
        <a href="/account/create" class="text-center new-account">Create an account </a>
      	</div>
-->     </div>
   </div>

