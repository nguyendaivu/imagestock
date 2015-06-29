@section('pageCSS')
<style>
.parallax-window
{
    min-height: 600px;
    background: transparent;
}
#popular-search-images
{
	padding-top: 3%;
  padding-right: 4%;
  padding-left: 4%;
  display: table;
}
#featured-collections{
  display: table;
  width: 100%;
  padding-right: 3%;
  padding-left: 3%;
}


/*h1 {
    margin: 0 0 0 0;
    font-size: 27px;
    font-weight: bold;
    font-family: Verdana;
    text-align: left;
}

h1 span {
    letter-spacing: -0.05em;
	padding-left:40px;
    color: #bbb;
}*/

hr {
    border: none;
    height: 1px; line-height: 1px;
    background: #E5E5E5;
    margin-bottom: 0;
    padding: 0;
}
</style>
@stop

@if (Session::has('message'))
    <div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif

<div class="parallax-window" data-parallax="scroll" data-start="0" data-stop="200" data-image-src="{{URL}}/{{ isset($typeObj->image)?$typeObj->image:''; }}">
  <div class="col-md-9 center-content" style="height: 400px;padding:25px 8px 25px 8px;">
    <div class="opacity30-radius3 title-type-box">
      <h2 class="hc2 title-type">{{$typeObj->name}}</h2>
      <p class="hc5">{{$typeObj->description}}</p>
      <br />
    </div>
  </div>
</div>

<div align="center" class="col-md-9 center-content">
  	<div style="margin-top: -400px;" class="panel panel-type-box">
      {{ $htmlPopularSearches }}
  	</div>
</div>
<div align="center" class="col-md-12 gray-light-bg">
  {{ $htmlFeaturedCollections }}
</div>

@section('pageJS')
<script src="{{URL}}/assets/global/plugins/parallax/parallax.min.js"></script>
<script type="text/javascript">

function searchByKeyword(keyword)
{
	window.location = "/search?keyword="+keyword;
}

$(document).ready(function() {

	//$('.parallax-window').parallax({imageSrc: '/path/to/image.jpg'});

});
</script>
@stop