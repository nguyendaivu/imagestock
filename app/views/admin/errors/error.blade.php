@extends('admin.layout.default')
@section('content')
<div class="row">
	<div class="col-md-12 page-404">
		<div class="number">
			{{ $code }}
		</div>
		<div class="details">
			<h3>{{ $title }}</h3>
			<p>
				{{ $message }}
			</p>
		</div>
	</div>
</div>
@stop
@section('pageCSS')
<link href="{{ URL::asset( 'assets/admin/pages/css/error.css' ) }}" rel="stylesheet" type="text/css"/>
@stop