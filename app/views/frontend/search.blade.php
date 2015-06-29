<div>
	<div id="options_view" class="container">
		<ul class="pull-right">
			<li><span class="glyphicon glyphicon-th" aria-hidden="true"></span>
			<li><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span>
			<li><span class="mosaic_grid"></span></li>
			<li><span class="glyphicon glyphicon-cog" aria-hidden="true" data-placement="left"></span>
		</ul>
	</div>
	<div class="collapse navbar-collapse" id="navigator">
		<ul class="nav nav-tabs left" id="sort_method">
			@foreach($arr_sort_method as $key=>$value)
				<li class="{{($key==$sort_method)?'active':''}}">
					<a href="#" title="{{$value}}">{{$value}}</a>
				</li>
			@endforeach
		</ul>
		<ul class="pagination">
			@if($total_image>0 && $total_page>1)
			<?php
				$current = Input::has('page')?Input::get('page'):1;
				$from = $current - 2> 0 ? $current - 2: 1;
				$to = $current + 2<= $total_page ? $current + 2: $total_page;
			?>
			<li>
				<a href="#" aria-label="Previous" data-value='prev' onclick='changePage(this)'>
					<span aria-hidden="true">&laquo;</span>
				</a>
			</li>
			@for( $i = $from; $i<= $to; $i++)
				@if($i == $current)
				<li class="active"><a href="#" data-value="{{ $i }}" onclick='changePage(this)'>{{ $i }}</a></li>
				@else
				<li><a href="#" data-value="{{ $i }}" onclick='changePage(this)'>{{ $i }}</a></li>
				@endif
			@endfor
			<li>
				<a href="#" aria-label="Next" data-value="next" onclick='changePage(this)'>
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
			<li>
				<span>{{ $current }}/{{ $total_page }}</span>
			</li>
			@endif
		</ul>
	</div>
</div>
<span id="result_search">
	@if(empty($images))
		<h4 class="container">We can not found image. Please try again with other option.</h4>
	@else
		<h4 class="container">We found {{ $total_image>1?$total_image.' images': '1 image' }}</h4>
	@endif
</span>
<div class="container" id="grid-image">

</div>
<div class="text-center">
	<ul class="pagination">
		@if($total_image>0 && $total_page>1)
		<?php
			$current = Input::has('page')?Input::get('page'):1;
			$from = $current - 2 > 0 ? $current - 2 : 1;
			$to = $current + 2 <= $total_page ? $current + 2 : $total_page;
		?>
		<li>
			<a href="#" aria-label="Previous" data-value='prev' onclick='changePage(this)'>
				<span aria-hidden="true">&laquo;</span>
			</a>
		</li>
		@for( $i = $from; $i<= $to; $i++)
			@if($i == $current)
			<li class="active"><a href="#" data-value="{{ $i }}" onclick='changePage(this)'>{{ $i }}</a></li>
			@else
			<li><a href="#" data-value="{{ $i }}" onclick='changePage(this)'>{{ $i }}</a></li>
			@endif
		@endfor
		<li>
			<a href="#" aria-label="Next" data-value="next" onclick='changePage(this)'>
				<span aria-hidden="true">&raquo;</span>
			</a>
		</li>
		<li>
				<span>{{ $current }}/{{ $total_page }}</span>
			</li>
		@endif
	</ul>
</div>
@if(count($categories)>0)
<div class="panel panel-default">
  <div class="panel-heading hc2 abel bold">View Image by Category</div>
  <div class="panel-body category-list">
  	<?php
		$per_col= round(count($categories)/4);
	?>
   	@foreach($categories as $key => $category)
   		@if($key%$per_col==0)
   		<ul class="col-md-3  col-sm-6  col-xs-6 list-unstyled">
   		@endif
   			<li><a href="{{ URL }}/cat-{{ $category['short_name'] }}-{{ $category['id'] }}.html" title="{{ $category['name'] }}">{{ $category['name'] }}</a> </li>
   		@if($key%$per_col==$per_col -1)
   		</ul>
   		@endif
   	@endforeach
  </div>
</div>
@endif
<div id="take_page" style="display:none;">
	<select onchange="changeTake(this)" class="form-control">
		<option value="30" {{ (Input::has('take')&&Input::get('take')==30)?'selected':'' }}>30</option>
		<option value="50" {{ (Input::has('take')&&Input::get('take')==50)?'selected':'' }}>50</option>
		<option value="100" {{ (Input::has('take')&&Input::get('take')==100)?'selected':'' }}>100</option>
		<option value="200" {{ (Input::has('take')&&Input::get('take')==200)?'selected':'' }}>200</option>
	</select>
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
		<div class="clear-fix">
			<button type="button" class="btn btn-default" onclick="saveLightBox(this)" style="width:100px;">Like</button>
		</div>    
	@endif
<!--		<div class="popover_lightbox">
			<p>Please sign-in</p>
			<p class="small">
				To organize photos in lightboxes you must first register or login. Registration is Free! Lightboxes allow you to categorize groups of photos and send them to your friends or colleagues.
			</p>
			<span class="text-center">
				<a href="{{URL}}/account/sign-in">Sign in</a>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<a href="{{URL}}/account/create">Create an account</a>
			</span>
		</div>-->
	
</div>

@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{URL}}/assets/css/style.css">
<style type="text/css" media="screen">
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
	@if($mod_download==0)
	.is_mod_download{
		display: none!important;
	}
	@endif
</style>
@stop
@section('pageJS')
<script src="{{URL}}/assets/global/plugins/rowgrid/row-grid.js" type="text/javascript" charset="utf-8" ></script>
<script>
	var list_image = {{ json_encode($images) }}; console.log(list_image);
	var total_page = {{ $total_page }};
	var search_type = '{{ isset($search_type)?$search_type:'search' }}';
	var first = 1;
	var w,h; w=110; h=160;
	
	var options = {minMargin: 10, maxMargin: 15, itemSelector: ".item"};
	$("#options_view .glyphicon-th").on("click",function(){
		$("input[name=sort_style]").val('small_grid');
		html='';
		if(list_image.length){
			$.each(list_image,function(key,elem){
				title = "<img src='"+'{{ URL}}'+'/pic/with-logo/'+elem['short_name']+'-'+elem['id']+".jpg' />";
				html+='<div class="item inline small_grid">'+
						'<a href="{{URL}}/pic-'+elem['id']+'/'+elem['short_name']+'.html" data-toggle="tooltip" data-placement="right auto" title="'+title+'">'+
							'<div class="img_mark"><img src="{{ URL}}'+'/pic/small-thumb/'+elem['short_name']+'-'+elem['id']+'.jpg" /></div>'+
						'</a>'+
						'<span class="image_action">'+
							'<span class="glyphicon glyphicon-heart" title="{{ $image_action_title }}" data-id-image="'+elem['id']+'"  data-toggle="popover"></span><small>(<span id="count_favorite_'+elem['id']+'">' + elem["count_favorite" ] + '</span>)</small>'+
							'<span class="glyphicon glyphicon-arrow-down is_mod_download" title="Download" onclick="downloadImage(\''+elem['id']+'\', \''+elem['short_name']+'\')"></span><small class="is_mod_download">(<span id="count_download_'+elem['id']+'">' + elem["downloads" ].length + '</span>)</small>'+
						'</span>'+
					'</div>';
			})
		}
		$("#grid-image").html(html);
		showAddLightBox();
		changeURL();
		$("#grid-image a").tooltip({
			html:true,
			container:'body',
		});
	})

	$("#options_view .glyphicon-th-large").on("click",function(){
		$("input[name=sort_style]").val('grid');
		html='';
		if(list_image.length){
			$.each(list_image,function(key,elem){
				title = "<img src='"+'{{ URL}}'+'/pic/with-logo/'+elem['short_name']+'-'+elem['id']+".jpg' >";
				html+='<div class="item inline large_grid">'+
						'<a href="{{URL}}/pic-'+elem['id']+'/'+elem['short_name']+'.html"  data-toggle="tooltip" data-placement="right auto" title="'+title+'">'+
							'<div class="img_mark"><img src="{{ URL}}'+'/pic/thumb/'+elem['short_name']+'-'+elem['id']+'.jpg" /></div>'+
						'</a>'+
						'<span class="image_action">'+
							'<span class="glyphicon glyphicon-heart" title="{{ $image_action_title }}" data-id-image="'+elem['id']+'"  data-toggle="popover"></span><small>(<span id="count_favorite_'+elem['id']+'">' + elem["count_favorite" ] + '</span>)</small>'+
							'<span class="glyphicon glyphicon-arrow-down is_mod_download" title="Download" onclick="downloadImage(\''+elem['id']+'\', \''+elem['short_name']+'\')"></span><small class="is_mod_download">(<span id="count_download_'+elem['id']+'">' + elem["downloads" ].length + '</span>)</small>'+
						'</span>'+
					'</div>';
			})
		}
		$("#grid-image").html(html);
		showAddLightBox()
		changeURL();
		$("#grid-image a").tooltip({
			html: true,
			container:'body',
		});
	})

	$("#options_view .mosaic_grid").on("click",function(){
		$("input[name=sort_style]").val('mosaic');
		html='';
		if(list_image.length){
			$.each(list_image,function(key,elem){

				html+='<div class="item inline">'+
						'<a href="{{URL}}/pic-'+elem['id']+'/'+elem['short_name']+'.html">'+
							'<img src="{{ URL}}'+'/pic/with-logo/'+elem['short_name']+'-'+elem['id']+'.jpg" height="250" width="'+(elem['width']/elem['height']*250)+'" />'+
						'</a>'+
						'<span class="image_action">'+
							'<span class="glyphicon glyphicon-heart" title="{{ $image_action_title }}" data-id-image="'+elem['id']+'" data-toggle="popover"></span><small>(<span id="count_favorite_'+elem['id']+'">' + elem["count_favorite" ] + '</span>)</small>'+
							'<span class="glyphicon glyphicon-arrow-down is_mod_download" title="Download" onclick="downloadImage(\''+elem['id']+'\', \''+elem['short_name']+'\')"></span><small class="is_mod_download">(<span id="count_download_'+elem['id']+'">' + elem["downloads" ].length + '</span>)</small>'+
						'</span>'+
					'</div>';
			})
		}
		$("#grid-image").html(html);
		$("#grid-image").rowGrid(options);
		showAddLightBox();
		changeURL();
	})

	$("#options_view .glyphicon-cog").popover({
		content: $("#take_page").html(),
  		html:true,
  		width:50,
	})
	@if($sort_style=='small_grid')
		$("#options_view .glyphicon-th").trigger('click');
	@elseif($sort_style=='grid')
		$("#options_view .glyphicon-th-large").trigger('click');
	@else
		$("#options_view .mosaic_grid").trigger('click');
	@endif


	

	$('body').on('click', function (e) {
		//did not click a popover toggle or popover
		if ($(e.target).data('toggle') !== 'popover'
		&& $(e.target).parents('.popover.in').length === 0
		) {
			$('.image_action .glyphicon-heart').popover('hide');
		}

		if ($(e.target).data('toggle') === 'popover'
		    && $(e.target).attr('aria-describedby')!==$(".popover.in").get(0).id
		    ){
			$('.image_action .glyphicon-heart').not($(e.target)).popover('hide');
		}
	});

	
	function changeCategory(){
		$("input[name=page]").val(1);;
		getImage();
	}
	$("#sort_method li a").on("click",function(){
		$("input[name=page]").val(1);
		var method = $(this).attr('title').toLowerCase();
		$("input[name=sort_method]").val(method);
		$("#sort_method li").removeClass("active");
		$(this).parent().addClass("active");
		getImage();
	})

	function changePage(obj){
		var page = $(obj).attr('data-value');
		if(page=='next'){
			console.log(parseInt($("input[name=page]").val()) );
			if(parseInt($("input[name=page]").val()) < total_page){
				$("input[name=page]").val(parseInt($("input[name=page]").val())+1);
				getImage();
			}
		}else{
			if(page=='prev'){
				if(parseInt($("input[name=page]").val()) > 1){
					$("input[name=page]").val(parseInt($("input[name=page]").val())-1);
					getImage();
				}
			}else{
				$("input[name=page]").val(page);
				getImage();
			}
		}
	};

	function getImage(){
		$.ajax({
			url:getURL(),
			type:'GET',
			success:function(result){
				appendImage(result);
			}
		})
	}
	function appendImage(result){
		
		list_image = result.images;
		total_page = result.total_page;
		total_image = result.total_image;
		sort_style = result.sort_style;
		switch(sort_style){
			case 'small_grid':
				$("#options_view .glyphicon-th").click();
				break;
			case 'grid':
				$("#options_view .glyphicon-th-large").click();
				break;
			case 'mosaic':
				$("#options_view .mosaic_grid").click();
				break;
			default:
				$("#options_view .mosaic_grid").click();
				break;
		}
		if(total_image>0){
			html='<h4 class="container">We found ';
			html+= total_image>1?total_image+' images': '1 image';
			html+='</h4>';
		}else{
			html='<h4 class="container">We can not found image. Please try again with other option.</h4>';
		}
		createPage(total_image,total_page);
		$(".popover").remove();
		$(".tooltip").remove();
		$("#result_search").html(html);
	}

	function createPage(total_image,total_page){
		var html='';

		if(total_image>0 && total_page>1){
			var current_page = parseInt($("input[name=page]").val());
			var from = current_page- 2 > 0 ? current_page- 2 : 1;
			var to = current_page+ 2<= total_page ? current_page+2 : total_page;
			console.log(current_page, from,to,total_page);
			html+='<li>';
			html+='<a href="#" aria-label="Previous" data-value="prev" onclick="changePage(this)">';
			html+=		'<span aria-hidden="true">&laquo;</span>';
			html+=	'</a>';
			html+=	'</li>';
			for(i=from;i<=to;i++){
				if(i==current_page){
					html+='<li class="active"><a href="#" data-value="'+i+'" onclick="changePage(this)">'+i+'</a></li>';
				}else{
					html+='<li><a href="#" data-value="'+i+'" onclick="changePage(this)">'+i+'</a></li>';
				}
			}
			html+='<li>';
			html+=	'<a href="#" aria-label="Next" data-value="next" onclick="changePage(this)">';
			html+=		'<span aria-hidden="true">&raquo;</span>';
			html+=	'</a>';
			html+=	'</li>';
			html+='<li>';
			html+='	<span>'+current_page+'/'+total_page+'</span>';
			html+='</li>';
		}
		$(".pagination").html(html);
	}

	function getURL(){
		var querry = $("#search-form").serialize();
		if(search_type=='search')
			var url = '{{ URL }}/search?'+querry;
		else
			var url = location.protocol + '//' + location.host + location.pathname+'?'+querry;
		return url;
	}

	function changeTake(obj){
		$("input[name=page]").val(1);
		var take = $(obj).val();
		$("input[name=take]").val(take);
		getImage();
	}


	function changeURL(){
		if(first!=1)
			window.history.pushState('data', '', getURL());
		first++;

	}

	function showAddLightBox(){
		$('#grid-image [data-toggle=popover]').popover({
			content: function(){
				return $("#add_light_box").html();
			},
	  		html:true,
	  		container:'body',
	  		width:150,
	  		placement:'bottom',
	  		template:'<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="close_popover" onclick="closePopover()">X</div><div class="popover-content"></div></div>'
		});
		$('#grid-image [data-toggle=popover]').on('shown.bs.popover',function(){
			html = '<input type="hidden" name="" id="id_image" value="'+$(this).data('id-image')+'">';
			$("#"+$(this).attr('aria-describedby')+' .popover-content').append(html);
		})
	}


	function addLightBox(obj){
		var id_lightbox = $(obj).data('id-lightbox');
		var id_image = $(obj).parent().parent().parent().find($("#id_image")).val();
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
		var id_image = $(obj).parent().parent().parent().find($("#id_image")).val();
		$.ajax({
			url:'{{URL}}/lightbox/add-by-name/'+id_image+'/'+name_lightbox,
			type:'GET',
			success:function(data){
				if(data.result == 'success'){

					//Increase the number of like of an image to 1
					if(data.count == 0)
					{
						var count_favorite = 1;
						count_favorite += parseInt($('#count_favorite_'+id_image).html());
						$('#count_favorite_'+id_image).html(count_favorite);							
					}

					if(data.case == 'favorites')
					{
						name_lightbox = data.case;
					}
					
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


	function closePopover(){
		$('.image_action .glyphicon-heart').popover('hide');
	}
	
	function downloadImage(image_id, short_name)
	{
		var url = '{{URL}}/pic-'+image_id+'/'+short_name+'.html?a=download';
		window.location = url;
	}


	var v_gender = "{{ Input::has('gender')?Input::get('gender'):'any' }}";
	var v_age = "{{ Input::has('age')?Input::get('age'):'any' }}";
	var v_ethnicity = "{{ Input::has('ethnicity')?Input::get('ethnicity'):'any' }}";
	var v_number_people = "{{ Input::has('number_people')?Input::get('number_people'):'any' }}";

	$("#people_option select[name=gender] option[value="+v_gender+"]").prop('selected',true);
	$("#people_option select[name=age] option[value="+v_age+"]").prop('selected',true);
	$("#people_option select[name=ethnicity] option[value="+v_ethnicity+"]").prop('selected',true);
	$("#people_option select[name=number_people] option[value="+v_number_people+"]").prop('selected',true);
</script>

@stop