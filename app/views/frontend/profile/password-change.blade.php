    
    <div class="row">
        <div>
            <form action="#" method="post" class="form-signin">
         
                <div class="form-group">
                    <label class="control-label">Password Old:</label> 
                    <input type="password" name="old_password" id="old_password" class="form-control" required> 
                    @if($errors->has('old_password'))
                        <div class="has-error" style="color:#a94442;">{{ $errors->first('old_password')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label">Password:</label> 
                    <input type="password" name="password" id="password" class="form-control" required> 
                    @if($errors->has('password'))
                        <div class="has-error" style="color:#a94442;">{{ $errors->first('password')}}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label">Password confirm:</label> 
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required> 
                    @if($errors->has('password_confirm'))
                        <div class="has-error" style="color:#a94442;">{{ $errors->first('password_confirm')}}</div>
                    @endif
                </div>

         		 <button id="password-change" class="btn" type="button" onclick="passwordChange()">Change Password</button>
                 <button id="cancel-password-change" class="btn" type="button" onclick="cancelChangePassword()">Cancel</button>
                 
        
            </form>
        </div>
    </div>