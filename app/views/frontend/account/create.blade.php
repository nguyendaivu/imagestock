
    <div class="row">
        <div class="col-sm-6 col-md-6 col-md-offset-3">
            <h1 class="text-center login-title" style="font-size:24px">Create your account</h1>
            <br />
            <div class="account-wall">
                <form name="formCreate" action="{{ URL::route('account-create-post') }}" method="post" class="form-signin">
             
                    <div class="form-group">
                        <label class="control-label">First name:</label>
                        <input type="text" name="first_name" value="{{ Input::old('first_name') }}" placeholder="Your first name" class="form-control" required autofocus> 
                        @if($errors->has('first_name'))
                            <div class="has-error" style="color:#a94442;">{{ $errors->first('first_name')}}</div>
                        @endif
                    </div>
    
                    <div class="form-group">
                        <label class="control-label">Last name:</label>
                        <input type="text" name="last_name" value="{{ Input::old('last_name') }}" placeholder="Your last name" class="form-control" required> 
                        @if($errors->has('last_name'))
                            <div class="has-error" style="color:#a94442;">{{ $errors->first('last_name')}}</div>
                        @endif
                    </div>
    
                    <div class="form-group">
                        <label class="control-label">E-mail:</label>
                        <input type="email" name="email" value="{{ Input::old('email') }}" placeholder="Your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" required> 
                        @if($errors->has('email'))
                            <div class="has-error" style="color:#a94442;">{{ $errors->first('email')}}</div>
                        @endif
                    </div>
            
                    <div class="form-group">
                        <label class="control-label">Password:</label> 
                        <input type="password" name="password" class="form-control" required> 
                        @if($errors->has('password'))
                            <div class="has-error" style="color:#a94442;">{{ $errors->first('password')}}</div>
                        @endif
                    </div>
    
                    <div class="form-group">
                        <label class="control-label">Password confirm:</label> 
                        <input type="password" name="password_confirm" class="form-control" required> 
                        @if($errors->has('password_confirm'))
                            <div class="has-error" style="color:#a94442;">{{ $errors->first('password_confirm')}}</div>
                        @endif
                    </div>
                    <div class="has-error">
                    	<div class="checkbox">
                            <label class="checkbox pull-left">
                                <input type="checkbox" value="agreed" required>
                                I agree to Image-Stock's website terms and Licensing terms.
                            </label>
                    	</div>
                    </div>
                    <br /><br /><br />
                    <button class="btn btn-lg btn-primary btn-block" type="submit">Create Account</button>
                    <span class="clearfix"></span>
                        {{ Form::token() }}
            
                </form>
            </div>
            <br />

<!--            <div style="text-align:center">
            <a href="{{ URL::route('account-sign-in') }}" class="text-center">Sign-in </a>
            </div>
-->            
        </div>
	</div>


