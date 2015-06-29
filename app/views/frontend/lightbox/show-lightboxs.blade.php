@section('pageCSS')
<style>
#lightbox {
	/*width: 540px;*/
	margin: 40px auto 0 auto;
	padding: 0 60px 30px 60px;
	border: solid 1px #cbcbcb;
	/*background: #fafafa;*/
	background: #fff;
	-moz-box-shadow: 0px 0px 10px #cbcbcb;
	-webkit-box-shadow: 0px 0px 10px #cbcbcb;
}

h1 {
	margin: 30px 0 15px 0;
	font-size: 30px;
	font-weight: bold;
	font-family: Arial;
}

h1 span {
	font-size: 50%;
	letter-spacing: -0.05em;
}

hr {
	border: none;
	height: 1px; line-height: 1px;
	background: #E5E5E5;
	margin-bottom: 20px;
	padding: 0;
}

p {
	margin: 0;
	padding: 7px 0;
}

a {
	outline: none;
}

a img {
	border: 1px solid #BBB;
	padding: 2px;
	margin: 10px 20px 10px 0;
	vertical-align: top;
}

a img.last {
	margin-right: 0;	
}

ul {
	margin-bottom: 24px;
	padding-left: 30px;
}

#div-lightbox-name
{
	width: 100px; 
	text-align: center; 
	margin-top: -10px; 
	color: blue; 
	cursor: pointer;
	text-decoration:underline;
}

.borderimg1 { 
    border: 10px solid transparent;

    border-image-source: url(/assets/global/img/border.png);
    border-image-repeat: round;
    border-image-slice: 30;
    border-image-width: 10px;
	width:115px;       
}


</style>
@stop
@section('pageJS')
	<script type="text/javascript">
	
		function removeLightboxImages(event, id)
		{
			event.preventDefault();
			var r = confirm("Are you sure you want to remove this item from your lightbox?");
			if (r == true) {
				$.get("/lightbox/remove/"+id,
				{
					
				},
				function(data, status){
					$('#div-lightbox').html(data['html']);
				});											
			}
		}			

		function lightboxDetail(id)
		{

			$.get("/lightbox/detail/"+id,
			{
				
			},
			function(data, status){
				$('#div-lightbox').html(data['html']);
			});											

		}			
	
		function backToLightbox()
		{
			$.get("/lightbox/show/",
			{
				
			},
			function(data, status){
				$('#div-lightbox').html(data['html']);
			});														
		}
		$(document).ready(function() {
			/*
			*   Examples - images
			*/

			$("a[rel=example_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
			
			
			
		});
	</script>
@stop    
@section('content')
	@if (Auth::user()->check())

	<div id="div-lightbox">    
        <div id="lightbox">
            <h1><span>Your Lightboxes</span></h1>    
            <hr />    

            @if(isset($arrlightbox) && count($arrlightbox)>0)
                @foreach($arrlightbox as $lightbox)
                	@if (isset($lightbox['path'])) 
					<div style="display:inline-block">

                        <div><a rel="example_group" href="{{URL}}{{ $lightbox['path'] }}" title="{{ $lightbox['name'] }}"><img alt="" src="{{URL}}{{ $lightbox['path'] }}" class="borderimg1" /></a></div>
                        <div id="div-lightbox-name" onclick="lightboxDetail('{{ $lightbox['id'] }}')">{{ $lightbox['name'] }}</div>

					</div>
                    @endif
                @endforeach            	
            @else
            	There are no items in your lightbox.
            @endif
        
        </div>
    </div>
	@endif          
@stop
