@section('pageCSS')
<style>
	a.button {
		text-decoration:none;
	}
	
	ul.list_image li a .div_image{
		width:115px;
		height:115px;
		margin: 0 5px;
		overflow: hidden;
	}
	ul.list_image li a .div-image-name{
		width:110px;  
		white-space: nowrap;
  		overflow: hidden;
 		text-overflow: ellipsis;
 		text-decoration: none;
 		color: #888;
	}
	.div-image-name:hover{
		text-decoration: none!important;
	}
	.tooltip.in {
		opacity: 1 !important;
	}
	.tooltip-arrow{
		border-bottom-color: #e7e7e7 !important;
	}
	.tooltip-inner{
		background: #e7e7e7 !important;
		max-width: 100% !important;
		padding: 3px !important;
	}
	table.size-list {
		width: 100%;
	}
	table.size-list td {
		width: 10%;
	}
	table.size-list td:first-child {
		width: 5%;
	}
	.close_popover{
		position: absolute;
		top:5px;
		right:5px;
		cursor: pointer;
		padding: 3px;
	}
	.close_popover:hover{
		background: #ddd;
	}
	.popover_lightbox{
		min-width: 250px;
	}
	
	/*For radio image*/
	div.customize-control-radio-image {
		padding:0px;
	}

	.customize-control-radio-image div.product-title {
		white-space: nowrap; 
		overflow: hidden; 
		text-overflow: ellipsis;
		font-size:smaller;
		padding-bottom:3px;
	}

	.customize-control-radio-image a {
		cursor:pointer;
	}
	
	.customize-control-radio-image label {
		box-sizing: border-box;
		max-width:  110%;
		height:     auto;
		padding:    1px;
		border:     4px solid transparent;
		cursor:pointer;
	}

    .customize-control-radio-image label:hover,
    .customize-control-radio-image label:focus {
        border-color: #ddd;
    }
	
	.customize-control-radio-image input{ /* HIDE RADIO */		
	  visibility: hidden; /* Makes input not-clickable */
	  position: absolute; /* Remove input from document flow */
	}
	.customize-control-radio-image input[type="radio"]:checked + label {
		border:4px solid #F80;
	}
	
	.customize-control-radio-image label img {
		width:105px;
	}	
		
	a.morelink {
		text-decoration:none;
		outline: none;
	}
	.morecontent span {
		display: none;
	}
	@if($mod_download==0 || $mod_order==0)
	.on_off_tab{
		display: none;
	}
	.tab-content{
		margin-left: -17px;
	}
	@endif
	
	div.display-price {
		display:inline; 
		margin-left:120px; 
		margin-top:-50px; 
		position:absolute;
	}
	
	#main-image img {
		width:100%;
	}
	
	/*Framed*/
	#main-image div.framed {
		border: 25px #000 solid; 
		padding: 60px; 
		box-shadow: 10px 10px 15px #ccc; 
		background-color: #EFEFEF;	
		margin: 15px 15px 15px 0px;
	}	
	#main-image div.framed img.framed{
		border: 3px #DADADA solid; 
		border-top-color:#fff; 
		border-bottom-color:#999999;
	}

	/*Photo Print*/
	#main-image img.photo{
		border: 1px #fff;
		box-shadow: 10px 10px 15px #ccc; 
	}
	
	/*Canvas*/
	#main-image img.canvas{
		border-right: 5px #DADADA solid;
		border-bottom: 5px #999999 solid;
		border-left: 1px #999999 solid;
		border-top: 3px #fff solid;
		box-shadow: 10px 10px 15px #ccc; 
	}
	
</style>
@stop

@if (Session::has('message'))
	<div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif
@if (isset($imageObj))
<div>
	<div class='col-md-8 center-content'>
		<input type="hidden" id="img-id" value="{{ $imageObj['image_id'] }}">
		<input type="hidden" id="img-name" value="{{ $imageObj['short_name'] }}">
		<div class="" id="div-main-image">{{ $htmlMainImage }}</div>
		<div class="col-md-12" style="margin-top:-20px;padding-left:0">
            <div class="text-left col-md-12" id="div-same-artist">{{ $htmlSameArtist }}</div>
            <div class="text-left col-md-12" id="div-similar-images">{{ $htmlSimilarImages }}</div>
            <!--<div class="container text-left" id="div-view-keywords">{{ $htmlKeywords }}</div>-->
            <div class="panel panel-default" id="div-view-categories">
            	<div class="panel-heading hc2 abel bold">View Image by Category</div>
  				<div class="panel-body category-list">
                {{ $htmlCategories }}
                </div>
            </div>
        </div>
	</div>
</div>
<div id="add_light_box" style="display:none;">
	@if(Auth::user()->check())
		<div class="popover_lightbox" id="list_lightbox">
			@foreach($lightboxes as $lightbox)
				<p data-id-lightbox="{{ $lightbox['id'] }}" class="btn btn-default " onclick="addLightBox(this)" style="margin:5px;">{{$lightbox['name']}}</p>
			@endforeach
		</div>
		<div class="clear-fix">
			<input type="text" id="lightbox_name">
			<button type="button" class="btn btn-default" onclick="saveLightBox(this)">Save</button>
		</div>
	@else
		<div class="popover_lightbox">
			<p>Please sign-in</p>
			<p class="small">
				To organize photos in lightboxes you must first register or login. Registration is Free! Lightboxes allow you to categorize groups of photos and send them to your friends or colleagues.
			</p>
			<span class="text-center">
				<a href="{{URL}}/account/sign-in">Sign in</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{{URL}}/account/create">Create an account</a>
			</span>
		</div>
	@endif
</div>
@else
No Image.
@endif


@section('pageJS')
<script type="text/javascript">

function setOrderType(order_type, img_class)
{	
	//display image
	if(img_class == null)
	{
		img_class = 'framed';
	}
	if(img_class == 'photo')
	{
		$('#main-image-cover').removeClass('framed');
		$('#main-image-cover').removeAttr( 'style' );								
		$('#main-image-display').removeAttr( 'style' );								
	}
	else if(img_class == 'canvas')
	{
		$('#main-image-cover').removeClass('framed');
		$('#main-image-cover').removeAttr( 'style' );	
		$('#main-image-display').removeAttr( 'style' );								
	}
	else
	{
		$('#main-image-cover').attr("class", 'framed');
	}
	$('#main-image-display').attr("class", img_class);
	
	var html, sku;
	
	var arr_order_type = order_type.split("_");
	sku = arr_order_type[1];

	html = $('#div-choose-order-'+sku).html();
	$('#div-choose-order').html(html);
	
	var order_form = document.getElementById("order-form");	
	var img_sizing = order_form.elements.namedItem("img_sizing");
	
	if(img_sizing != null && img_sizing.value == '')
	{
		changeSize(img_sizing.value, sku);
	}

	caculatePrice(sku);	
}

function changeOption(option_obj, group_key, sku)
{
	if(group_key == 'depth')
	{
		//var order_form = document.getElementById("order-form");	
		//var option_depth = order_form.elements.namedItem("option_depth");
		var option_name = option_obj.options[option_obj.selectedIndex].text;
		var bleed = parseFloat(option_name);
		//alert(bleed);
		var default_bleed = parseFloat($('#default-'+group_key+'-'+sku).val());
		if($('#main-image-display').hasClass("framed"))
		{
			var img_border_width = 3;
			var new_img_border_width = bleed / default_bleed * img_border_width;
			$('#main-image-display').css('border-right-width', new_img_border_width+'px');
			$('#main-image-display').css('border-bottom-width', new_img_border_width+'px');
		}		
	}
	else if(group_key == 'wrap_option')
	{
		var arr_color = new Array();
		arr_color['black'] = '#000';
		arr_color['natural'] = '#663300';
		arr_color['m_wrap'] = '#CDAF95';
		arr_color['red'] = '#FF0000';
		arr_color['white'] = '#fff';
		var option_key = option_obj.value;
		if($('#main-image-display').hasClass("framed"))
		{
			if(arr_color[option_key] != null)
			{
				$('#main-image-cover').css('border-color', arr_color[option_key]);	
			}			
		}		
	}

	caculatePrice();
}

function changeSize(img_sizing, sku)
{
	if(img_sizing == '')
	{
		$('input[name=img_width]').val('');
		$('input[name=img_height]').val('');
		
		$('#div-custom-sizing-'+sku).show();		
		$('#price').val(0);
		$('#display_price').number(0, 2);		
	}
	else
	{
		//Display Image
		var sizes = img_sizing.split("|");
		sizew = sizes[0];
		sizeh = sizes[1];
		var default_sizew = $('#default-sizew-'+sku).val();
		var default_sizeh = $('#default-sizeh-'+sku).val();
		if($('#main-image-display').hasClass("framed"))
		{
			var img_padding = 35;
			var new_img_padding = default_sizew / sizew * img_padding;
			if(sizeh > default_sizeh)
			{
				new_img_padding = default_sizeh / sizeh * img_padding;
			}
			$('#main-image-cover').css('padding', new_img_padding+'px');
		}
		
		$('#div-custom-sizing-'+sku).hide();		
		caculatePrice();
	}
}

function changeQuantity(order_qty)
{
	var old_qty = $('#old_qty').val();
	if(order_qty == old_qty)
	{
		return;	
	}
	$('#old_qty').val(order_qty);	
	caculatePrice();
}

function caculatePrice()
{
	var sum = 0;
	var sizew, sizeh = 0;
	var depth, wrap_option, edge_color, orientation, frame_colour, border;
	
	var order_type = $('input[name="order_type"]:checked').val();
	
	var arr_order_type = order_type.split("_");
	var sku = arr_order_type[1];

	var order_form = document.getElementById("order-form");
	
	var img_sizing = order_form.elements.namedItem("img_sizing");
	if(img_sizing != null && img_sizing.value != '')
	{
		var size = img_sizing.value;
		var sizes = size.split("|");
		sizew = sizes[0];
		sizeh = sizes[1];
	}
	else
	{
		if(order_form.elements.namedItem("img_width") != null && order_form.elements.namedItem("img_height") != null)
		{
			sizew = order_form.elements.namedItem("img_width").value;
			sizeh = order_form.elements.namedItem("img_height").value;			
			
			if(sizew == '' || sizew <= 0 || sizeh == '' || sizeh <= 0 )
			{
				$('#price').val(0);
				$('#display_price').number(0, 2);
				
				return;	
			}			
		}
	}
	
	if(order_form.elements.namedItem("option_depth") != null)
	{
		depth = order_form.elements.namedItem("option_depth").value;
	}
	if(order_form.elements.namedItem("option_wrap_option") != null)
	{
		wrap_option = order_form.elements.namedItem("option_wrap_option").value;
	}
	if(order_form.elements.namedItem("option_orientation") != null)
	{
		orientation = order_form.elements.namedItem("option_orientation").value;
	}
	if(order_form.elements.namedItem("option_frame_colour") != null)
	{
		frame_colour = order_form.elements.namedItem("option_frame_colour").value;
	}
	if(order_form.elements.namedItem("option_border") != null)
	{
		border = order_form.elements.namedItem("option_border").value;
	}
	if(order_form.elements.namedItem("option_edge_color") != null)
	{
		edge_color = order_form.elements.namedItem("option_edge_color").value;
	}
	
	var order_qty = $('#order_qty').val();	

	$('#sell_price').val(0);
	$('#price').val(0);
	
	$('#display_price').html('<img src="{{URL}}/assets/images/others/ajax-loader.gif" width="20px">');
	$.post("/order/calculate-price",
	{
		sku: sku,
		sizew: sizew,
		sizeh: sizeh,
		depth: depth,
		wrap_option: wrap_option,
		orientation: orientation,
		frame_colour: frame_colour,
		border: border,
		edge_color: edge_color,
		order_qty: order_qty
	},
	function(data, status){
		if(data['status'] == 'ok')
		{
			sum = data['data']['amount'];
			var sell_price = data['data']['sell_price'];
			$('#sell_price').val(sell_price);
			$('#price').val(sum);
			$('#display_price').number(sum, 2);			
		}
	});		
		
}

function addLightBox(obj){
	var id_lightbox = $(obj).data('id-lightbox');
	var id_image = $("#image_id").val();
	$.ajax({
		url:'{{URL}}/lightbox/add/'+id_image+'/'+id_lightbox,
		type:'GET',
		success:function(data){
			if(data.result = 'success'){
				$(obj).parent().parent().html('<div class="popover_lightbox">'+'Saved to '+$(obj).text()+'</div>');
			}else{
				$(obj).parent().parent().html('<div class="popover_lightbox">Save error</div>');
			}
		}
	})
}
function saveLightBox(obj){
	var name_lightbox = $(obj).prev().val();
	var id_image = $("#image_id").val();
	$.ajax({
		url:'{{URL}}/lightbox/add-by-name/'+id_image+'/'+name_lightbox,
		type:'GET',
		success:function(data){
			if(data.result == 'success'){
				$(obj).parent().parent().html('<div class="popover_lightbox">'+'Saved to '+name_lightbox+'</div>');
				$.ajax({
					url:'{{URL}}/lightbox/get-lightbox-user',
					type:'GET',
					success:function(data){
						if(data.result=='success'){
							html='';
							$.each(data.lightboxes,function(key,value){
								html+='<p data-id-lightbox="'+value['id']+'" class="btn btn-default " onclick="addLightBox(this)" style="margin:5px;">'+value['name']+'</p>'
							})
							$("#list_lightbox").html(html);
						}else{
							alert(data.message);
						}
					}
				})
			}else{
				$(obj).parent().parent().html('Save error');
			}
		}
	})
}

function truncateDescription()
{
   	var showChar = 200;
    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";
    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar-1, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ ' </span><span class="morecontent"><span>' + h + '</span>  <a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}

$(document).ready(function() {
	
	//load Order Type
	setOrderType("{{ $arrProduct[2]['short_name'] }}_{{ $arrProduct[2]['sku'] }}");
	
	truncateDescription();
	
	$('#add-to-card-btn').click(function( event ) {
  		event.preventDefault();
		var order_form = document.getElementById("order-form");
		order_form.submit();
	});
	
/*	$('body').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
			&& $(e.target).parents('.popover.in').length === 0) {
		   $('[data-toggle=popover]').not("#refine_search").popover('hide');
		}
	});
*/	
	$('#save-lightbox').on('click',function(){
		$(this).popover({
			content: function(){
				return $("#add_light_box").html();
			},
			html:true,
			container:'body',
			width:250,
			placement:'bottom',
			template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
		})
	});
	$('img[data-toggle=tooltip]').tooltip({
		html: true,
		placement: 'auto right',
		container: 'body',
	});
	$('table.size-list > tbody > tr').click(function() {
		$('table.size-list > tbody > tr').removeClass('active');
		$('input:radio', this).prop('checked', true);
		$(this).addClass('active');
	});
	$('#download-btn').click(function(){
		var id = $('#img-id').val();
		var name = $('#img-name').val();
		var img = $('input[name=size_type]:checked').val();
		var url = '{{ URL }}';
		var open = false;
		$.ajax({
			url: '{{ URL }}/d/' + id + '/' + name,
			type: 'POST',
			data: {
				img: img
			},
			async: false,
			success: function(result){
				if( result.status == 'ok' ) {
					url = result.url;
					open = true;
				}
			}
		});
		if( open ) {
			window.open(url,'_blank');
		}
	});
});

</script>
@stop