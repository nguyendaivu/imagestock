<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Anvy Images Stock">
	@if( isset($metaInfo['favicon']) && $metaInfo['favicon'] != URL )
	<link href="{{ URL::asset($metaInfo['favicon']) }}" rel="shortcut icon" type="image/x-icon" />
	@endif
	<title>{{ isset($metaTitle) ? $metaTitle : (isset($metaInfo['title_site']) && !empty($metaInfo['title_site']) ? $metaInfo['title_site'] : '')}}</title>
	<meta name="description" content="{{ $metaInfo['meta_description'] or '' }}" />
	@yield('pageCSS')

	<!-- Bootstrap core CSS -->
	<link href="{{URL}}/assets/global/plugins/bootstrap332/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{URL}}/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
	<link href="{{URL}}/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
	<link href="{{URL}}/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet">
	<link href="{{URL}}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
	<!--[if lt IE 9]><script src="{{URL}}/assets/global/plugins/bootstrap332/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<script src="{{URL}}/assets/global/plugins/bootstrap332/assets/js/ie-emulation-modes-warning.js"></script>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link href="{{URL}}/assets/css/main.css" rel="stylesheet" />


	<style type="text/css" media="screen">
		#search-form .popover{
			min-width: 400px;
			max-width: 400px;
			margin-top: 20px !important;
		}
		#search-form input[type=text],
		#search-form select{
			width:100%;
		}
		.colorpicker{
			z-index: 100000;
		}
		div.refine_search {
			width: 120px; 
			display:inline-block; 
			margin-left:80px;
		}
		
	</style>

  </head>

  <body>


	@include('frontend.layout.header')

	<!-- Begin page content -->

	<div class="container search_bar">
		<form class="form-inline" action="{{URL}}/search" method="GET" enctype="application/x-www-form-urlencoded" id="search-form">
			<input type="hidden" name='sort_method' value="{{ Input::has('sort_method')?Input::get('sort_method'):'new' }}">
			<input type="hidden" name='sort_style' value="{{ Input::has('sort_style')?Input::get('sort_style'):'mosaic' }}">
			<input type="hidden" name='page' value='{{ Input::has('page')?Input::get('page'):1 }}'>
			<input type="hidden" name='take' value='{{ Input::has('take')?Input::get('take'):30 }}'>
			<input type="hidden">
			<input type="hidden">
			<input type="hidden">
			<div class="col-md-2 form-group logo">
				<a href="{{URL}}"><img src="{{URL}}/assets/images/logo2.png" alt="logo" id="logo" /></a>
			</div>
			<div class="col-md-10 form-group search_box">
				<label for="keySearch" class="sr-only">Search key</label>
				<div class="input-group col-md-12">
					<input type="text" class="form-control" style="width:90%;" id="keySearch" name="keyword" placeholder="Search images, vectors and video" value='{{ Input::has('keyword')?Input::get('keyword'):'' }}' autocomplete="off" spellcheck="false" />
					<input type="hidden" name="select_type" value="0" />
					<!-- <select name="select_type" class="form-control" style="width:20%;" >
						<option value="0">All Images</option>
						@foreach($types as $type)
							<option value="{{ $type['id'] }}" {{ Input::has('type') && $type['id']==Input::get('type') ? 'selected' :'' }}> {{ $type['name'] }}</option>
						@endforeach
					</select> -->
					<button type="button" id="btn-search" class="btn btn-primary search_bt" style="width:10%;" >
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</div>                
			</div>
            <div class="refine_search">
                <a href="#" title="" id="refine_search" data-toggle="popover" data-placement="bottom" style="line-height: 30px;" data-trigger="click">
                    Refine Your Search
                </a>            
            </div>
			<div  id="popover_search" style="display:none;">
				<div class="row">
					<label for="" class="col-md-5 text-right">Image type:</label>
					<div class="col-md-7">
						<input type="radio" name="type" value="0" checked onclick="changeType()">All Images<br/>
						@foreach($types as $type)
							<input onclick="changeType(this)" type="radio" name="type" value="{{ $type['id'] }}" {{ Input::has('type') && $type['id']==Input::get('type') ? 'checked' : ''  }}>{{ $type['name'] }}<br/>
						@endforeach
					</div>
				</div>

				<div class="row">
					<label for="" class="col-md-5 text-right">Categories:</label>
					<div class="col-md-7">
						<select  name="category" onchange="{{
						 isset($in_search)? 'changeCategory()': ''
						 }}">
							<option value="0">Any Category</option>
							@foreach($categories as $category)
								<option value="{{ $category['id'] }}" {{ Input::has('category') && $category['id']==Input::get('category') ? 'selected' :'' }}> {{ $category['name'] }}</option>
							@endforeach
						</select>
					</div>
				</div>

				<div class="row">
					<label for="" class="col-md-5 text-right">Orientation:</label>
					<div class="col-md-7">
						<select  name="orientation" onchange="{{
						 isset($in_search)? 'changeOrientation()': ''
						 }}">
							<option value="any" {{ (Input::has('orientation')&&Input::get('orientation')=='any')?'selected':'' }}>Any Orientation</option>
							<option value="horizontal" {{ (Input::has('orientation')&&Input::get('orientation')=='horizontal')?'selected':'' }}>Horizontal</option>
							<option value="vertical" {{ (Input::has('orientation')&&Input::get('orientation')=='vertical')?'selected':'' }}>Vertical</option>
							<option value="square" {{ (Input::has('orientation')&&Input::get('orientation')=='square')?'selected':'' }}>Square</option>
						</select>
					</div>
				</div>

				<div class="row">
					<label for="" class="col-md-5 text-right">Exclude Keyword:</label>
					<div class="col-md-7">
						<input type="text"  class="form-control" name='exclude_keyword' value="{{ Input::has('exclude_keyword')?Input::get('exclude_keyword'):'' }}">
					</div>
				</div>
				<div class="row">
					<label for="" class="col-md-5 text-right">People:</label>
					<div class="col-md-7">
						<input type="checkbox" name="exclude_people"  onchange="changeExcludePeople(this)" value="1"  {{ Input::has('exclude_people')?'checked':'' }}>Exclude People<br/>
						<input type="checkbox" name="include_people"  onchange="changeIncludePeople(this)"value="1"   {{ Input::has('include_people')?'checked':'' }}>Image with People<br/>
						<div id="people_option" style="{{ Input::has('include_people')?'':'display:none;' }}">
							<select name="gender" onchange="{{ isset($in_search)? 'getImage();': '' }}">
								<option value="any">Any Gender</option>
								<option value="male">Male</option>
								<option value="female">Female</option>
								<option value="both">Both Gender</option>
							</select>
							<br/>
							<select name="age" onchange="{{ isset($in_search)? 'getImage();': '' }}">
								<option value="any">Any Age</option>
								<option value="0-1">Infans (0-1)</option>
								<option value="1-10">Children (1-10)</option>
								<option value="11-19">Teenagers (11-19)</option>
								<option value="20-29">Age 20-29</option>
								<option value="30-39">Age 30-39</option>
								<option value="40-49">Age 40-49</option>
								<option value="50-59">Age 50-59</option>
								<option value="60-69">Age 60-69</option>
								<option value="70-200">Age 70+</option>
							</select>
							<br/>
							<select name="ethnicity" onchange="{{ isset($in_search)? 'getImage();': '' }}">
								<option value="any">Any Ethnicity</option>
								<option value="african">African</option>
								<option value="african_american">African American</option>
								<option value="black">Black</option>
								<option value="brazilian">Brazilian</option>
								<option value="chinese">Chinese</option>
								<option value="caucasian">Caucasian (White)</option>
								<option value="east_asian">East Asian</option>
								<option value="hispanic">Hispanic (Latin)</option>
								<option value="japanese">Japanese</option>
								<option value="middle_eastern">Middle Eastern</option>
								<option value="native_american">Native American</option>
								<option value="pacific_islander">Pacific Islander</option>
								<option value="south_asian">South Asian</option>
								<option value="southeast_asian">Southeast Asian</option>
								<option value="other">Other</option>
							</select>
							<select name="number_people" onchange="{{ isset($in_search)? 'getImage();': '' }}">
								<option value="any">Any Number of People</option>
								<option value="1">1 Person</option>
								<option value="2">2 People</option>
								<option value="3">3 People</option>
								<option value="4">4+ People</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<label for="" class="col-md-5 text-right">Editorial:</label>
					<div class="col-md-7">
						<input type="checkbox" onchange="{{ isset($in_search)? 'getImage();': '' }}" name="editorial" {{ Input::has('editorial')?'checked':'' }} value="1">Editorial<br/>
						<input type="checkbox" onchange="{{ isset($in_search)? 'getImage();': '' }}" name="non_editorial" {{ Input::has('non_editorial')?'checked':'' }} value="1">Non-Editorial
					</div>
				</div>
				<div class="row">
					<label for="" class="col-md-5 text-right">Color:</label>
					<div class="col-md-7">
						<div class="input-group color colorpicker-default" data-color="" data-color-format="hex"  data-placement="top">
							<input type="text" class="form-control" value="{{ Input::has('color')?Input::get('color'):'' }}" name="color" id="input_color">
							<span class="input-group-btn">
									<button class="btn default" type="button"><i id="show-current-color" style="background-color: {{ Input::has('color')?Input::get('color'):'#3865a8' }};">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</i></button>
							</span>
						</div>
					</div>
				</div>
				<br/>
				<div class="text-center">
					<input type="button" class="btn btn-primary" value="Search" onClick="btnPrimarySearch()">
					<input type="button" class="btn btn-secondary" value="Clear" onClick="btnResetSearch(this.form)">
				</div>
			</div>

		</form>

	</div>
	<div class="container main_container">
		{{ $content or '' }}
		@yield('content')
	</div>
	<!-- /.container -->


	@include('frontend.layout.footer')

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="{{URL}}/assets/global/plugins/jquery.min.js"></script>
	<script src="{{URL}}/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js"></script>
	<script src="{{URL}}/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="{{URL}}/assets/global/plugins/jquery.number.min.js"></script>
	<script src="{{URL}}/assets/global/plugins/bootstrap332/dist/js/bootstrap.min.js"></script>
	<script src="{{URL}}/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="{{URL}}/assets/global/plugins/bootstrap332/assets/js/ie10-viewport-bug-workaround.js"></script>
	<script>
		$("#refine_search").popover({
			content: $("#popover_search").html(),
			html:true,
			container: '#search-form'
		});
		
		$("[data-toggle=popover]").on('show.bs.popover', function () {
			$("#popover_search").remove();
		});

		$("[data-toggle=popover]").on('shown.bs.popover', function () {
			
			$(".colorpicker-default").colorpicker();
						
			$("#show-current-color").css("background-color", '{{ Input::has("color")?Input::get("color"):"#3865a8" }}');
			
		});
		
		function changeType(obj){
			$("input[name=page]").val(1);
			$("#search-form select[name=select_type] option[value="+$(obj).val()+"]").prop("selected",true);
			{{ isset($in_search)? 'getImage();': '' }}
		}
		function changeOrientation(){
			$("input[name=page]").val(1);
			getImage();
		}

		function changeExcludePeople(obj){
			if($(obj).is(":checked")){
				$("input[name=include_people]").prop("checked",false);
				$("#people_option").hide();
			}
			{{ isset($in_search)? 'getImage();': '' }}
		}

		function changeIncludePeople(obj){
			if($(obj).is(":checked")){
				$("input[name=exclude_people]").prop("checked",false);
				$("#people_option").show();
				{{ isset($in_search)? 'getImage();': '' }}
			}else{
				$("#people_option").hide();
			}
			{{ isset($in_search)? 'getImage();': '' }}
		}

		$("#search-form [name=select_type]").on("change",function(){
			$("input[name=page]").val(1);
			$("#search-form input:radio[name=type][value="+$(this).val()+"]").prop("checked",true);
			{{ isset($in_search)? 'getImage();': '' }}
		});

		$("#search-form [id=btn-search]").on("click",function(){
			$("input[name=page]").val(1);
			$("#search-form").submit();
		});

		$("#search-form [id=keySearch]").on("keypress",function(e){
			if (!e) e = window.event;
		    var keyCode = e.keyCode || e.which;
		    if (keyCode == '13'){//enter
		      $("#search-form").submit();
		    }			
		});
		
		function btnPrimarySearch()
		{
			$("input[name=page]").val(1);
			$("#search-form").submit();			
		}
		
		function btnResetSearch(oForm)
		{
			var elements = oForm.elements; 			
			oForm.reset();			
			for(i=0; i<elements.length; i++) 
			{			  
				field_type = elements[i].type.toLowerCase();			
				switch(field_type) 
				{			
					case "text": 
					case "password": 
					case "textarea":
					case "hidden":							
						elements[i].value = ""; 
						break;					
					case "radio":
					case "checkbox":
						if (elements[i].checked) {
							elements[i].checked = false; 
						}
						break;			
					case "select-one":
					case "select-multi":
							elements[i].selectedIndex = -1;
						break;			
					default: 
						break;
				}
			}			
		}

	</script>
	@yield('pageJS')
  </body>
</html>
