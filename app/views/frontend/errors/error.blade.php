@section('body')
<body class="page-404-not-found template-404">
@stop
<div class="row">
	<div class="columns">
	    <ul class="breadcrumbs colored-links">
	   		<li><a href="/">Home</a></li>
	       	<li>{{ $code }}</li>
		</ul>
	</div>
</div>
<div class="row colored-links">
	<div class="columns">
	  <h1 class="page-title">{{ $title }}</h1>
	  <h2>{{ $message }}</h2>
	  <p>Go back to our <a href="{{ URL }}">homepage</a> or view our range of <a href="{{ URL }}/collections/">products</a>.</p>
	</div>
</div>