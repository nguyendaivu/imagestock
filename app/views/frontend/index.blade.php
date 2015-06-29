<div class="container" id="search_index">
	<div class ="hero-unit">
		<div class="hero-logo">
			<a href="#">
				  <img src="{{URL}}/assets/images/logo_invert.png" alt="Logo_invert" />
			  </a>
		</div>
		<div class="hero-search">
			<form class="form-inline" action="{{URL}}/search" method="GET" enctype="application/x-www-form-urlencoded" id="search-form">
				<div class="input-group col-md-12">
					<input type ="text" class="form-control" placeholder="Search images and vectors" autocomplete="off" spellcheck="false" dir="auto" name="keyword" aria-describedby="basic-addon1" style="width:75%">
					<select name="type" class="form-control input-group-addon" style="width:25%;" >
						<option value="0">All Images</option>
						@foreach($types as $type)
							<option value="{{ $type['id'] }}" {{ Input::has('type') && $type['id']==Input::get('type') ? 'selected' :'' }}> {{ $type['name'] }}</option>
						@endforeach
					</select>
					<div class="input-group-btn">
						<button type="submit" class="btn btn-primary" >
							<span class="glyphicon glyphicon-search"></span>
						</button>
					</div>

				</div>
			</form>
		</div>
	</div>
</div>
<!-- Browse Images by Category -->
<div class="container category-list">
	<div class="col-md-3 col-md-offset-1">
		<h3 class="hc1 abel" style="margin-top:0;padding-top:0;">Browse Images by Category</h3>
	</div>
	<?php
		$per_col= round(count($categories)/4);
	?>
	@foreach($categories as $key => $category)
		@if($key%$per_col==0)
		<ul class="col-md-2 col-sm-6  col-xs-6 list-unstyled">
		@endif
			<li><a href="{{ URL }}/cat-{{ $category['short_name'] }}-{{ $category['id'] }}.html" title="{{ $category['name'] }}">{{ $category['name'] }}</a> </li>
		@if($key%$per_col==$per_col -1)
		</ul>
		@endif
	@endforeach
</div>

<!-- Stock Photos, Vectors, Illustrations -->
<div class="container text-center hline">
	<h1 class="hc1 ">Stock Photos, Vectors, Illustrations</h1>
	<h4 class="hc5">Find everything you need for your creative projects. Download instantly.</h4>
</div>
<div class="container text-center" style="margin-top: 18px;">
	<div class="btn-group" id="control_slider">
		@foreach($types as $key => $type)
			<button class="btn btn-default btn-lg {{$key==0?'active':''}}" data-key="{{ $key }}" onclick="sliderTo({{ $key }})">{{ $type['name'] }}</button>
		@endforeach
	</div>
	<ul id="slider_index">
		@foreach($types as $key => $type)
			<li>
				<div class="row-grid">
					@foreach($arr_img[$key] as $image)
					<div class="item">
                    	<a href="{{URL}}/pic-{{$image->id}}/{{$image->short_name}}.html">
						<img src="{{ URL }}/pic/large-thumb/{{$image->short_name}}-{{ $image->id }}.jpg" alt="" height="215" width="{{ ($image->width / $image->height)*215 }}">
							<div class="item-caption">
	                        	<h4>{{ $image->name }}</h4>
	                        	<span>{{$image->artist}}</span>
	                        </div>
                        </a>

					</div>
					@endforeach
				</div>
			</li>
		@endforeach
	</ul>
</div>


<div class="container signup_index">
	<div class="col-md-3 col-md-offset-1">
		<h3 class="hc3">Sign up and get free content every week.</h3>
		<form name="formCreate" action="{{ URL::route('account-create-post') }}" method="post" class="form-signin">

            <div class="form-group">
            	<input type="email" name="email" value="{{ Input::old('email') }}" placeholder="Your email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control" required>
           	</div>
            <div class="form-group">
            	<input type="password" name="password" class="form-control" required placeholder="Password">
           	</div>
            <div class="form-group">
            	<input type="password" name="password_confirm" class="form-control" required placeholder="Password Confirm">
           	</div>
            <div class="form-group">
                <input type="checkbox" value="agreed" required>
                I agree to Image-Stock's website terms and Licensing terms.
           	</div>
            <div class="form-group">
            	<button class="btn btn-lg btn-primary btn-block" type="submit">Create Account</button>
            	<span class="clearfix"></span>
                {{ Form::token() }}
           	</div>

        </form>
	</div>
</div>
@section('pageCSS')
	<link rel="stylesheet" type="text/css" href="{{URL}}/assets/global/plugins/light-slider/css/lightslider.css">
	<link rel="stylesheet" type="text/css" href="{{URL}}/assets/css/input_search_home.css">
	<style type="text/css" media="screen">
		#search_index{
			margin-top: -20px;
			height:388px;
			@if( !empty($banner['main']) )
			background: url('{{ $banner['main'] }}');
			background-repeat: no-repeat;
			background-attachment: scroll;
			background-position: center;
			background-size: 100% 100%;
			@else
			background-color: #fff;
			@endif
		}
	</style>
@stop
@section('pageJS')
<script src="{{URL}}/assets/global/plugins/light-slider/js/lightslider.js" type="text/javascript"></script>
<script>
var slider = $("#slider_index").lightSlider({
	item: 1,
	// loop:true,
	slideMargin: 0,
	controls: false,
	speed:1000,
	keyPress:false,
	enableTouch:false,
	enableDrag:false,
	pager:false,
	verticalHeight:500,
	// autoWidth:true,
});

function sliderTo(number){
	$("#control_slider button.active").removeClass('active');
	$("#control_slider button[data-key="+number+"]").addClass('active');
	slider.goToSlide(number);
}
function setWidthHeight(){
	$.each($(".row-grid img"),function(key,element){
		var window_h = $(window).height();
		var h = 215/626*window_h;
		var w = (element.width/element.height)*h;
		element.height=h;
		element.width=w;
	});
}
function createGrid(){
	$.each($(".row-grid"),function(key,element){
		$(element).find('img').each(function(key2, image){
			var bg_url = image.src;
			var bg_size = '100%';
			if(image.width/image.height >1.2){
				bg_size = 'auto 100%';
			}
			$(image).parent().css({
				'width': '31%',
				'margin': '1%',
				'background-image': "url('"+bg_url+"')",
				'background-position': 'center',
				'background-repeat': 'no-repeat',
				'background-size': bg_size,
				'float':'left',
				'cursor':'pointer',
			});
			$(image).css({
				  'visibility': 'hidden',
			});
		});
	})
}
setWidthHeight();
createGrid();
$(window).resize(function(){
	setWidthHeight();
	createGrid();
});
</script>
@stop
