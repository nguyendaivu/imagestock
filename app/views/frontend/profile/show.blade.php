@section('pageCSS')
@stop
@section('pageJS')
<script>

function cancelChangePassword()
{
	$('#div-change-password').html('');
}

function passwordChange()
{
	$.post("/account/change-password",{
		old_password: $("#old_password").val(),
		password: $("#password").val(),
		password_confirm: $("#password_confirm").val()
	},
	function(data, status){

		alert(data['message']);

		if(data['result'] == "success")
		{
			$('#div-change-password').html('');
		}

	});

}

$(document).ready(function() {

	$("#change-password").on("click",function(){

		$.get("/account/change-password",{},
		function(data, status){
			$('#div-change-password').html(data['html']);
		});

	});

});
</script>
@stop

<div class="container">
      <div class="row">
	@if (Auth::user()->check())
      <div class="col-md-5  toppad  pull-right col-md-offset-3 ">

        <!--<a href="/account/sign-out" >Logout</a>-->

      </div>
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Account Details</h3>
            </div>
            <div class="panel-body">
              <div class="row">

                <div class=" col-md-12 col-lg-12 ">
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Email:</td>
                        <td>{{ $user->email }}</td>
                      </tr>
                      <tr>
                        <td>Password:</td>
                        <td><a id="change-password" href="#" class="btn btn-primary">Change Password</a></td>
                      </tr>
                      <tr style="border-top:none">
                      	<td style="border-top:none"></td>
                      	<td style="border-top:none">
                        	<div id="div-change-password"></div>
                        </td>
                      </tr>
                      <tr>
                        <td>Contact Information</td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>First name:</td>
                        <td>{{ $user->first_name }}</td>
                      </tr>
                      <tr>
                        <td>Last name:</td>
                        <td>{{ $user->last_name }}</td>
                      </tr>


                    </tbody>
                  </table>

                </div>
              </div>
            </div>
                 <div class="panel-footer" style="height:50px">

                        <span class="pull-right">
                            <a href="/account/sign-out" data-original-title="Logout" data-toggle="tooltip" type="button" class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-log-out"></i></a>

<!--                            <a href="#" data-original-title="Remove this user" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
-->
                        </span>
                    </div>

          </div>
        </div>
        @else
            <p>No profile yet.</p>
            <li><a href="{{ URL::route('account-sign-in') }}" class="btn btn-primary">Sign in</a></li>
            <li><a href="#" class="btn btn-primary">Create an account</a></li>
        @endif
  </div>
</div>