
@if (Session::has('message'))
    <div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif

<div id="create_or_signin">
    <div class="col-md-6 left_column">
        <div id="div-account-create" class="panel panel-default">
            {{ $formCreate }}
        </div>
    </div>
    <div class="col-md-5 right_column">    
        <div id="div-account-signin" class="panel panel-default">
          {{ $formSignin }}
        </div>
    </div>
</div>
