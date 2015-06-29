
@section('content')
@if (Session::has('message'))
	<div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif
@if (Session::has('payment_message'))
	<div class="alert alert-warning">{{ Session::get('payment_message') }}</div>
@endif

<div>
	<div class="col-md-2 left_column">

	</div>
	<div class="col-md-8 right_column">    
		<div id="div-account-home">
			<h2>Welcome back to Imagestock!</h2>
			<hr/>
			<div role="tabpanel" class="panel panel-default">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs panel-heading" role="tablist" id="myTab">
					<li role="presentation" class="active"><h4><a href="#recently-search" aria-controls="recently-search" role="tab" data-toggle="tab">Recently Searched Images</a></h4></li>
					<li role="presentation" style="margin-left: 10px;padding-left: 10px;"><h4><a href="#recently-view" aria-controls="recently-view" role="tab" data-toggle="tab">Recently Viewed Images</a></h4></li>

				</ul>
				
				<!-- Tab panes -->
				<div class="tab-content panel-body">
					<div role="tabpanel" class="tab-pane active" id="recently-search">
						<div id="div-recently-search"></div> 
					</div>
					<div role="tabpanel" class="tab-pane" id="recently-view">
						<div id="div-recently-view"></div> 
					</div>
				</div>
			
			</div>
			
			<div id="div-load-lightbox" class="panel panel-default">
				<div class="panel-heading">
                    <h4>Your Lightboxes
                        <span>&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/lightbox" style="font-size:16px">View All</a></span>
                    </h4>
				</div>
				<div class="panel-body">
					<div id="div-lightbox">
					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><h4>Featured Lightboxes</h4></div>
				<div class="panel-body">
					<div id="div-featured-lightbox"></div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><h4>View Image by Category</h4></div>
				<div class="panel-body">
					<div id="div-view-categories"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2" id="advertise_column">
		
	</div>
</div>
@stop

@section('pageCSS')
	<link rel="stylesheet" type="text/css" href="{{URL}}/assets/global/plugins/light-slider/css/lightslider.css">
	<style>
	#div-account-home .panel-default,
	#div-account-home .panel{
		border: none !important;
		-webkit-box-shadow: none !important; 
		box-shadow: none; 
	}
	.nav-tabs>li>h4>a{
		color: #555;
	}
	.nav-tabs>li>h4>a:hover{
		text-decoration: none;
	}
	.nav-tabs>li.active>h4>a, .nav-tabs>li.active>h4>a:focus, .nav-tabs>li.active>h4>a:hover{
		color: #555;
		cursor: default;
		background-color: #fff;
		border: 1px solid #ddd;
		border-bottom-color: transparent;
		padding: 19px;
	}
	#div-account-home>div{
		margin-bottom: 20px;
	}
	#div-recently-search{
		height:auto !important;
	}
	.lSPager.lSpg{
		display: none;
	}
	
	


	</style>
@stop

@section('pageJS')
	<script src="{{URL}}/assets/global/plugins/light-slider/js/lightslider.js" type="text/javascript"></script>
	<script type="text/javascript">
	
        function searchByKeyword(url)
        {
            window.location = url;
        }


		$(document).ready(function() {

			//load recently search images
			$.get("/account/recently-search-images/", {}, function(data, status){

				$('#div-recently-search').html(data['html']);
				$("#div-recently-search").lightSlider({
					item: 5,
					controls: true,
					speed:1000,
					keyPress:true,
					auto:true,
					loop:true,
					pause:5000,
				}).play(); 

			});
			
			//show tab
			$('#myTab a:last').on('click', function(){
				$('#myTab a:last').tab('show');
				$("#div-recently-view").lightSlider({
					item: 5,
					controls: true,
					speed:1000,
					keyPress:true,
					auto:true,
					loop:true,
					// autoWidth:true,
					pause:5000,

				}).play();
								
				
			});

			//load recently view images
			$.get("/account/recently-view-images/", {}, function(data, status){

				//alert(data['html']);
				$('#div-recently-view').html(data['html']);	

			});                                         

			//load lightboxes
			$.get("/lightbox/show/", {}, function(data, status){
				if(data['message'])
				{
					$('#div-lightbox').html(data['html']);
					$("#div-lightbox").lightSlider({
							item: 5,
							controls: true,
							speed:1000,
							keyPress:true,
							auto:true,
							loop:true,
							pause:5000,
						}).play(); 					
				}
				else
				{
					$('#div-load-lightbox').hide();
				}

			}); 

			//load featured lightboxs
			$.get("/lightbox/featured-lightboxs/", {}, function(data, status){

				$('#div-featured-lightbox').html(data['html']);
				$("#div-featured-lightbox").lightSlider({
						item: 5,
						controls: true,
						speed:1000,
						keyPress:true,
						loop:true,					
					})

			});              

			//load categories
			$.get("/load-categories", {}, function(data, status){

				$('#div-view-categories').html(data['html']);

			});                                         


			
		});
	</script>
@stop   
