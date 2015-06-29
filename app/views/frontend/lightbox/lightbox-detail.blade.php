<div class="container">
	<div class="navbar">
		<div class="nav nav-tabs" id="lightbox_action">
			<div class="pull-left breadcrumb_nav">
				<span><a href="{{ URL }}/lightbox">Lightboxes</a></span>
				<span id="lightbox_name">{{$lightbox->name}}</span> <span id="total_image">({{count($images)}})</span>
			</div>
			<div class="pull-left action_nav col-md-offset-2 hidden" id='select_image'>
			Selected Images: &nbsp;&nbsp;&nbsp;
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_remove"><span class="fa fa-remove"></span>Remove</button>
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_copy"><span class="fa fa-copy"></span>Copy</button>
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_move"><span class="fa fa-scissors"></span>Move</button>
			</div>
			<div class="pull-right action_nav">
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_email"><span class="fa fa-envelope-o"></span>Email</button>
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_share"><span class="fa fa-share-alt"></span>Share</button>
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_rename"><span class="fa fa-pencil"></span>Rename</button>
				<button class="btn btn-link" data-toggle="modal" data-target="#modal_delete"><span class="fa fa-trash-o"></span>Delete</button>
			</div>
		</div>
	</div>
</div>

<div class="container">
	@if(count($images)>0)
	<div class="container" id="list_lightbox">
		@foreach($images as $image)
			<div class="lightbox_div">
				<div class="item_lightbox">  
                	<div class="div_image">              	
						<img src="{{URL.$image['path']}}" alt="{{$image['name']}}" onclick="chooseImage(this)">
                    </div>
                    <div class="div-image-name" style="width:110px; line-height:none;">
                    	<a href="{{URL}}/pic-{{$image['image_id']}}/{{$image['short_name']}}.html" title="{{ $image['name'] }}" >
                        	{{ Str::words($image['name'], 3, '...') }}
                        </a>
                    </div>
				</div>
				<div class="text-center check_lightbox">
					<input type="checkbox" class="checkbox_image"  value="{{$image['image_id']}}">
				</div>
			</div>
		@endforeach
	</div>
	@else
	<div class="text-center" style="height:300px;vertical-align: bottom;padding-top: 150px;">
		<h4>Lightboxes allow you to categorize groups of photos and send them to your friends or colleagues.</h4>
		Create your first Lightbox by finding an image and clicking the <strong>"Add to Lightbox"</strong> icon beneath it.
	</div>
	@endif
</div>


<input type="hidden" id="id_lightbox" value="{{$lightbox->id}}">

<!-- Modal Email-->

<div class="modal fade" id="modal_email" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Email</h4>
			</div>
			<div class="modal-body">
				<p>Recipient will not be able to modify your lightbox.</p>
				<input class="form-control" maxlength="120" placeholder="Email Address" id="email_input" type="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Send</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Share-->
<div class="modal fade" id="modal_share" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Share</h4>
			</div>
			<div class="modal-body">
				<p>Recipient will be able to modify your lightbox.</p>
				<input class="form-control" maxlength="50" placeholder="Username" id="username_input" type="text">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary">Share</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Rename-->
<div class="modal fade" id="modal_rename" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Rename</h4>
			</div>
			<div class="modal-body">
				<input class="form-control" maxlength="50" placeholder="New name" id="name_input" type="text">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary"  onclick="renameLightBox(this);">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Delete-->
<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Delete</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to delete this entire lightbox?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick='deleteLightBox(this)'>Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Remove-->
<div class="modal fade" id="modal_remove" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Remove Image</h4>
			</div>
			<div class="modal-body">
				<p>Are you sure you want to remove this image from this lightbox?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="deleteImageLightbox(this);">Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Copy-->
<div class="modal fade" id="modal_copy" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Copy Image</h4>
			</div>
			<div class="modal-body">
				<p>Copy image to</p>
				<select class="lightboxes form-control">
					@foreach($list_lightbox as $lightbox)
						<option value="{{$lightbox['id']}}">{{$lightbox['name']}}</option>
					@endforeach
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="copyImageLightbox(this);">Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Move-->
<div class="modal fade" id="modal_move" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Move Image</h4>
			</div>
			<div class="modal-body">
				<p>Move image to</p>
				<select class="lightboxes form-control">
					@foreach($list_lightbox as $lightbox)
						<option value="{{$lightbox['id']}}">{{$lightbox['name']}}</option>
					@endforeach
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="moveImageLightbox(this);">Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{URL}}/assets/css/style.css">
<style type="text/css" media="screen">
	#list_lightbox .lightbox_div{
		width: 150px;
		height:auto;
		float: left;
		margin: 10px;
	}
	.item_lightbox{
		width:150px;
		/*line-height: 150px;*/
		vertical-align: middle;
		display: table-cell;
		text-align: center;
	}

	.item_lightbox div.div_image{
		margin: 0 5px;
		overflow: hidden;
		height:150px;
	}
	.item_lightbox div.div_image img{
		height:100%;
	}
	.item_lightbox div.div-image-name{
		white-space: nowrap;
		overflow: hidden;
		text-overflow: ellipsis;			
	}

	.check_lightbox{
		width:150px;
	}
</style>
@stop
@section('pageJS')
<script>
	$(".checkbox_image").on("click",function(){
		if($(".checkbox_image:checked").length){
			$("#select_image").removeClass('hidden');
		}else{
			$("#select_image").addClass('hidden');
		}
	})
	function renameLightBox(obj){
		$(obj).text('Saving...');
		var new_name = $("#name_input").val().trim();
		var id_lightbox = $("#id_lightbox").val();

		$.ajax({
			url:'{{URL}}/lightbox/rename',
			type:'POST',
			data:{
				name:new_name,
				id:id_lightbox
			},
			success:function(data){
				$(obj).text('Save');
				if(data.result == 'success'){
					$("#lightbox_name").text(new_name);
					$(obj).next().trigger('click');
				}else{
					alert(data.message);
				}
			}
		})
	}

	function deleteImageLightbox(obj){
		var id_lightbox = $("#id_lightbox").val();
		var list_image = [];
		var delete_lightbox = false;
		$(".checkbox_image:checked").each(function(){
			list_image.push(parseInt($(this).val()));
		})
		if(list_image.length==0){
			alert('Please choose image to delete');
			$(obj).next().trigger('click');
			return false;
		}
		if(list_image.length==1){
			if(confirm('Lightbox need least 1 image. If you delete this image, lightbox will be delete')){
				delete_lightbox = true;
			}else{
				return delete_lightbox;
				$(obj).next().trigger('click');
			}
		}
		$(obj).text('Deleting...');
		$.ajax({
			url:'{{URL}}/lightbox/delete-image',
			type:'POST',
			data:{
				list_image:list_image,
				id:id_lightbox
			},
			success:function(data){
				$(obj).text('Delete');
				if(data.result == 'success'){
					$(".checkbox_image:checked").parent().parent().remove();
					$("#total_image").text("("+$(".checkbox_image").parent().parent().length+")");
					if(delete_lightbox){
						$.ajax({
							url:'{{URL}}/lightbox/delete',
							type:'POST',
							data:{
								id:$("#id_lightbox").val()
							},
							success:function(data){
								if(data.result == 'success'){
									window.location = '{{URL}}/lightbox'
								}else{
									alert(data.message);
								}
							}
						})
					}
					$(obj).next().trigger('click');
				}else{
					alert(data.message);
				}
			}
		})
	}
	function deleteLightBox(obj){
		var id_lightbox = $("#id_lightbox").val();
		$(obj).text('Deleting...');
		$.ajax({
			url:'{{URL}}/lightbox/delete',
			type:'POST',
			data:{
				id:id_lightbox
			},
			success:function(data){
				$(obj).text('Delete');
				if(data.result == 'success'){
					window.location = '{{URL}}/lightbox'
				}else{
					alert(data.message);
				}
			}
		})
	}

	function copyImageLightbox(obj){
		var id_lightbox = $(obj).parent().prev().find($(".lightboxes")).val();
		var list_image = [];
		$(".checkbox_image:checked").each(function(){
			list_image.push(parseInt($(this).val()));
		})
		if(list_image.length==0){
			alert('Please choose image to copy');
			$(obj).next().trigger('click');
			return false;
		}
		$(obj).text('Copying...');
		$.ajax({
			url:'{{URL}}/lightbox/copy-image',
			type:'POST',
			data:{
				list_image:list_image,
				id:id_lightbox,
				
			},
			success:function(data){
				$(obj).text('Yes');
				if(data.result == 'success'){
					$(obj).next().trigger('click');
				}else{
					alert(data.message);
				}
			}
		})
	}

	function moveImageLightbox(obj){
		var id_lightbox = $(obj).parent().prev().find($(".lightboxes")).val();
		var old_id_lightbox = $("#id_lightbox").val();
		var list_image = [];
		var delete_lightbox = false;
		$(".checkbox_image:checked").each(function(){
			list_image.push(parseInt($(this).val()));
		})
		if(list_image.length==0){
			alert('Please choose image to move');
			$(obj).next().trigger('click');
			return false;
		}
		if(list_image.length==1){
			if(confirm('Lightbox need least 1 image. If you move this image, lightbox will be delete')){
				delete_lightbox = true;
			}else{
				return delete_lightbox;
				$(obj).next().trigger('click');
			}
		}
		$(obj).text('Moving...');
		$.ajax({
			url:'{{URL}}/lightbox/move-image',
			type:'POST',
			data:{
				list_image:list_image,
				id:id_lightbox,
				old_id:old_id_lightbox
			},
			success:function(data){
				$(obj).text('Yes');
				if(data.result == 'success'){
					$(".checkbox_image:checked").parent().parent().remove();
					$("#total_image").text("("+$(".checkbox_image").parent().parent().length+")");
					if(delete_lightbox){
						$.ajax({
							url:'{{URL}}/lightbox/delete',
							type:'POST',
							data:{
								id:$("#id_lightbox").val()
							},
							success:function(data){
								if(data.result == 'success'){
									window.location = '{{URL}}/lightbox'
								}else{
									alert(data.message);
								}
							}
						})
					}
					$(obj).next().trigger('click');
				}else{
					alert(data.message);
				}
			}
		})
	}

	function chooseImage(obj){
		$(obj).parent().next().find($("input[type=checkbox]")).trigger('click');
	}
</script>
@stop