<html>
<head>
	<title>Content Builder</title>
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Open+Sans:300,600,800">
	{{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/content-builder/css/content.css' ) }}"> --}}
	<link rel="stylesheet" type="text/css" href="http://vi.local/assets/themes/default/css/style.css">
	<link rel="stylesheet" type="text/css" href="http://vi.local/assets/themes/default/css/style2.css">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/content-builder/css/contentbuilder.css' ) }}">
</head>
<body>
	<div id="content-area" class="container connectSortable ui-sortable ui-droppable">
		@if( isset($content) && !empty($content) )
		{{ HTML::decode($content) }}
		@else
	    <div class="row clearfix">
	        <div class="column full display">
	            <h1>The Cafe</h1>
	            <p>Fresh roasted coffee, exclusive teas &amp; light meals</p>
	        </div>
	    </div>
	    <div class="row clearfix">
	        <div class="column half">
	            <img src="{{ URL.'/assets/content-builder/images' }}/cafe.jpg">
	        </div>
	        <div class="column half">
	            <p>Welcome to the website of the Cafe on the Corner. We are situated, yes you've guessed it, on the corner of This Road and That Street in The Town.</p>
	            <p>We serve freshly brewed tea and coffee, soft drinks and a section of light meals and tasty treats and snacks. We are open for breakfast, lunch and afternoon tea from 8 am to 5 pm and unlike any other cafe in the town, we are open 7 days per week.</p>
	       </div>
	    </div>
	    <div class="row clearfix">
	        <div class="column full">
	            <p>A truly family run business, we aim to create a cosy and friendly atmosphere in the cafe with Mum and Auntie doing the cooking and Dad and the (grown-up) children serving front of house. We look forward to welcoming you to the Cafe on the Corner very soon.</p>
	        </div>
	    </div>
	    @endif
	</div>
	<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery.min.js' ) }}"></script>
	<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js' ) }}"></script>
	<script type="text/javascript" src="{{ URL::asset( 'assets/content-builder/js/contentbuilder.js' ) }}"></script>
	<script type="text/javascript">
		$("#content-area").contentbuilder({
		    zoom: 0.85,
		    snippetOpen: true,
		    snippetFile: "{{ URL.'/assets/content-builder/content-builder.html' }}"
		});

		function getContent()
		{
			return $("#content-area").data("contentbuilder").html();
		}

		function getHeight()
		{
			return $("#content-area").height();
		}
	</script>
</body>
</html>