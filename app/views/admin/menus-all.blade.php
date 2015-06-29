@section('pageAction')
<div class="btn-group pull-right">
	<button id="add-menu" type="button" class="btn btn-fit-height red" >
	{{ 'Add Menu' }}
	</button>
</div>
@stop
<div class="row">
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="icon-list"></i>{{ 'Menu' }}
				</div>
			</div>
			<div class="portlet-body">
				<div class="row">
					<div class="col-md-6" id="menu-order">
						<div class="portlet box red tab-pane">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-reorder"></i>{{ 'Menu Order' }}
								</div>
								<div class="tools">
									<a href="javascript:;" class="fullscreen">
									</a>
								</div>
							</div>
							<div class="portlet-body tabbable-custom">
								<form id='form-reorder' action="{{ URL.'/admin/menus/menu-reorder'}}" method="POST" >
								<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
								<div id="menu-order-content">
									<ul class="nav nav-tabs">
										@foreach($arrMenu as $type => $value)
										<li <?php if(!isset($active)){ echo 'class="active"'; $active = 1; } ?>><a href="#tab-{{$type}}" data-toggle="tab">{{ ucfirst($type) }}</a></li>
										@endforeach
										<?php unset($active); ?>
									</ul>
									<div class="tab-content">
										@foreach($arrMenu as $type => $menus)
										<div id="{{ 'tab-'.$type }}" class=" dd tab-pane <?php if(!isset($active)){ echo 'active'; $active = 1; } ?>" style="min-height: 325px;">
											@if( is_array($menus) )
											<div class="tabbable-line">
												<ul class="nav nav-tabs">
												@foreach($menus as $subType =>$menu)
												<li <?php if(!isset($subActive)){ echo 'class="active"'; $subActive = 1; } ?>><a href="#tab-{{$subType}}" data-toggle="tab">{{ ucfirst($subType) }}</a></li>
												@endforeach
												</ul>
											</div>
											<div class="tab-content ">
											@foreach($menus as $subType => $menu)
											<div id="{{ 'tab-'.$subType }}" class=" dd tab-pane <?php if(!isset($ssubActive)){ echo 'active'; $ssubActive = 1; } ?>" style="min-height: 325px;">
											{{$menu}}
											</div>
											<input type="hidden" id="{{$subType}}_store" name="{{$subType}}_store" value="" />
											@endforeach
											</div>
											@else
											{{$menus}}
											<input type="hidden" id="{{$type}}_store" name="{{$type}}_store" value="" />
											@endif
										</div>
										@endforeach
									</div>
								</div>
								<div class="form-actions">
									<div class="col-md-12">
										<div class="row">
											<div class="text-right">
												<button id="reorder" type="submit" class="btn green">Re-Order</button>
											</div>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
					<div class="col-md-6" id="menu-info">
						<div class="portlet box red tab-pane">
							<div class="portlet-title">
								<div class="caption">
									<i class="fa fa-reorder"></i>{{ 'Menu Info' }}
								</div>
								<div class="tools">
									<a href="javascript:;" class="fullscreen">
									</a>
								</div>
							</div>
							<div class="portlet-body form">
								<form id="update-menu" action="{{ URL.'/admin/menus/update-menu' }}"  method="POST" class="form-horizontal" role="form" id="menu-info">
									<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
									<div class="form-body">
										<input type="hidden" id="id" name="id" value="0">
										<div class="form-group">
											<label class="col-md-3 control-label">Name</label>
											<div class="col-md-9">
												<input type="text" class="form-control" id="name" name="name" placeholder="">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Type</label>
											<div class="col-md-9">
												<select class="form-control" name="type" id="type">
													<option value="backend">Backend</option>
													<option value="frontend">Frontend</option>
												</select>
											</div>
										</div>
										<div class="form-group" id="group-div" style="display: none;">
											<label class="col-md-3 control-label">Group</label>
											<div class="col-md-9">
												<select class="form-control" name="group" id="group">
													<option value="header">Header Menu</option>
													<option value="footer">Footer Menu</option>
												</select>
											</div>
										</div>
										<div class="form-group" id="icon-div">
											<label class="col-md-3 control-label">Icon</label>
											<div class="col-md-9">
												<div class="input-inline" style="width:100%;">
													<div class="input-group col-md-12">
													<select class="form-control" name="icon_class" id="icon_class" data-live-search="true" data-size="6" data-dropup-auto="false">
														<option value="icon-user" data-icon="icon-user">User</option>
														<option value="icon-user-female" data-icon="icon-user-female">User female</option>
														<option value="icon-users" data-icon="icon-users">Users</option>
														<option value="icon-user-follow" data-icon="icon-user-follow">User follow</option>
														<option value="icon-user-following" data-icon="icon-user-following">User following</option>
														<option value="icon-user-unfollow" data-icon="icon-user-unfollow">User unfollow</option>
														<option value="icon-trophy" data-icon="icon-trophy">Trophy</option>
														<option value="icon-speedometer" data-icon="icon-speedometer">Speedometer</option>
														<option value="icon-social-youtube" data-icon="icon-social-youtube">Social youtube</option>
														<option value="icon-social-twitter" data-icon="icon-social-twitter">Social twitter</option>
														<option value="icon-social-tumblr" data-icon="icon-social-tumblr">Social tumblr</option>
														<option value="icon-social-facebook" data-icon="icon-social-facebook">Social facebook</option>
														<option value="icon-social-dropbox" data-icon="icon-social-dropbox">Social dropbox</option>
														<option value="icon-social-dribbble" data-icon="icon-social-dribbble">Social dribbble</option>
														<option value="icon-shield" data-icon="icon-shield">Shield</option>
														<option value="icon-screen-tablet" data-icon="icon-screen-tablet">Screen tablet</option>
														<option value="icon-screen-smartphone" data-icon="icon-screen-smartphone">Screen smartphone</option>
														<option value="icon-screen-desktop" data-icon="icon-screen-desktop">Screen desktop</option>
														<option value="icon-plane" data-icon="icon-plane">Plane</option>
														<option value="icon-notebook" data-icon="icon-notebook">Notebook</option>
														<option value="icon-moustache" data-icon="icon-moustache">Moustache</option>
														<option value="icon-mouse" data-icon="icon-mouse">Mouse</option>
														<option value="icon-magnet" data-icon="icon-magnet">Magnet</option>
														<option value="icon-magic-wand" data-icon="icon-magic-wand">Magic wand</option>
														<option value="icon-hourglass" data-icon="icon-hourglass">Hourglass</option>
														<option value="icon-graduation" data-icon="icon-graduation">Graduation</option>
														<option value="icon-ghost" data-icon="icon-ghost">Ghost</option>
														<option value="icon-game-controller" data-icon="icon-game-controller">Game controller</option>
														<option value="icon-fire" data-icon="icon-fire">Fire</option>
														<option value="icon-eyeglasses" data-icon="icon-eyeglasses">Eyeglasses</option>
														<option value="icon-envelope-open" data-icon="icon-envelope-open">Envelope open</option>
														<option value="icon-envelope-letter" data-icon="icon-envelope-letter">Envelope letter</option>
														<option value="icon-energy" data-icon="icon-energy">Energy</option>
														<option value="icon-emoticon-smile" data-icon="icon-emoticon-smile">Emoticon smile</option>
														<option value="icon-disc" data-icon="icon-disc">Disc</option>
														<option value="icon-cursor-move" data-icon="icon-cursor-move">Cursor move</option>
														<option value="icon-crop" data-icon="icon-crop">Crop</option>
														<option value="icon-credit-card" data-icon="icon-credit-card">Credit card</option>
														<option value="icon-chemistry" data-icon="icon-chemistry">Chemistry</option>
														<option value="icon-bell" data-icon="icon-bell">Bell</option>
														<option value="icon-badge" data-icon="icon-badge">Badge</option>
														<option value="icon-anchor" data-icon="icon-anchor">Anchor</option>
														<option value="icon-action-redo" data-icon="icon-action-redo">Action redo</option>
														<option value="icon-action-undo" data-icon="icon-action-undo">Action undo</option>
														<option value="icon-bag" data-icon="icon-bag">Bag</option>
														<option value="icon-basket" data-icon="icon-basket">Basket</option>
														<option value="icon-basket-loaded" data-icon="icon-basket-loaded">Basket loaded</option>
														<option value="icon-book-open" data-icon="icon-book-open">Book open</option>
														<option value="icon-briefcase" data-icon="icon-briefcase">Briefcase</option>
														<option value="icon-bubbles" data-icon="icon-bubbles">Bubbles</option>
														<option value="icon-calculator" data-icon="icon-calculator">Calculator</option>
														<option value="icon-call-end" data-icon="icon-call-end">Call end</option>
														<option value="icon-call-in" data-icon="icon-call-in">Call in</option>
														<option value="icon-call-out" data-icon="icon-call-out">Call out</option>
														<option value="icon-compass" data-icon="icon-compass">Compass</option>
														<option value="icon-cup" data-icon="icon-cup">Cup</option>
														<option value="icon-diamond" data-icon="icon-diamond">Diamond</option>
														<option value="icon-direction" data-icon="icon-direction">Direction</option>
														<option value="icon-directions" data-icon="icon-directions">Directions</option>
														<option value="icon-docs" data-icon="icon-docs">Docs</option>
														<option value="icon-drawer" data-icon="icon-drawer">Drawer</option>
														<option value="icon-drop" data-icon="icon-drop">Drop</option>
														<option value="icon-earphones" data-icon="icon-earphones">Earphones</option>
														<option value="icon-earphones-alt" data-icon="icon-earphones-alt">Earphones alt</option>
														<option value="icon-feed" data-icon="icon-feed">Feed</option>
														<option value="icon-film" data-icon="icon-film">Film</option>
														<option value="icon-folder-alt" data-icon="icon-folder-alt">Folder alt</option>
														<option value="icon-frame" data-icon="icon-frame">Frame</option>
														<option value="icon-globe" data-icon="icon-globe">Globe</option>
														<option value="icon-globe-alt" data-icon="icon-globe-alt">Globe alt</option>
														<option value="icon-handbag" data-icon="icon-handbag">Handbag</option>
														<option value="icon-layers" data-icon="icon-layers">Layers</option>
														<option value="icon-map" data-icon="icon-map">Map</option>
														<option value="icon-picture" data-icon="icon-picture">Picture</option>
														<option value="icon-pin" data-icon="icon-pin">Pin</option>
														<option value="icon-playlist" data-icon="icon-playlist">Playlist</option>
														<option value="icon-present" data-icon="icon-present">Present</option>
														<option value="icon-printer" data-icon="icon-printer">Printer</option>
														<option value="icon-puzzle" data-icon="icon-puzzle">Puzzle</option>
														<option value="icon-speech" data-icon="icon-speech">Speech</option>
														<option value="icon-vector" data-icon="icon-vector">Vector</option>
														<option value="icon-wallet" data-icon="icon-wallet">Wallet</option>
														<option value="icon-arrow-down" data-icon="icon-arrow-down">Arrow down</option>
														<option value="icon-arrow-left" data-icon="icon-arrow-left">Arrow left</option>
														<option value="icon-arrow-right" data-icon="icon-arrow-right">Arrow right</option>
														<option value="icon-arrow-up" data-icon="icon-arrow-up">Arrow up</option>
														<option value="icon-bar-chart" data-icon="icon-bar-chart">Bar chart</option>
														<option value="icon-bulb" data-icon="icon-bulb">Bulb</option>
														<option value="icon-calendar" data-icon="icon-calendar">Calendar</option>
														<option value="icon-control-end" data-icon="icon-control-end">Control end</option>
														<option value="icon-control-forward" data-icon="icon-control-forward">Control forward</option>
														<option value="icon-control-pause" data-icon="icon-control-pause">Control pause</option>
														<option value="icon-control-play" data-icon="icon-control-play">Control play</option>
														<option value="icon-control-rewind" data-icon="icon-control-rewind">Control rewind</option>
														<option value="icon-control-start" data-icon="icon-control-start">Control start</option>
														<option value="icon-cursor" data-icon="icon-cursor">Cursor</option>
														<option value="icon-dislike" data-icon="icon-dislike">Dislike</option>
														<option value="icon-equalizer" data-icon="icon-equalizer">Equalizer</option>
														<option value="icon-graph" data-icon="icon-graph">Graph</option>
														<option value="icon-grid" data-icon="icon-grid">Grid</option>
														<option value="icon-home" data-icon="icon-home">Home</option>
														<option value="icon-like" data-icon="icon-like">Like</option>
														<option value="icon-list" data-icon="icon-list">List</option>
														<option value="icon-login" data-icon="icon-login">Login</option>
														<option value="icon-logout" data-icon="icon-logout">Logout</option>
														<option value="icon-loop" data-icon="icon-loop">Loop</option>
														<option value="icon-microphone" data-icon="icon-microphone">Microphone</option>
														<option value="icon-music-tone" data-icon="icon-music-tone">Music tone</option>
														<option value="icon-music-tone-alt" data-icon="icon-music-tone-alt">Music tone alt</option>
														<option value="icon-note" data-icon="icon-note">Note</option>
														<option value="icon-pencil" data-icon="icon-pencil">Pencil</option>
														<option value="icon-pie-chart" data-icon="icon-pie-chart">Pie chart</option>
														<option value="icon-question" data-icon="icon-question">Question</option>
														<option value="icon-rocket" data-icon="icon-rocket">Rocket</option>
														<option value="icon-share" data-icon="icon-share">Share</option>
														<option value="icon-share-alt" data-icon="icon-share-alt">Share alt</option>
														<option value="icon-shuffle" data-icon="icon-shuffle">Shuffle</option>
														<option value="icon-size-actual" data-icon="icon-size-actual">Size actual</option>
														<option value="icon-size-fullscreen" data-icon="icon-size-fullscreen">Size fullscreen</option>
														<option value="icon-support" data-icon="icon-support">Support</option>
														<option value="icon-tag" data-icon="icon-tag">Tag</option>
														<option value="icon-trash" data-icon="icon-trash">Trash</option>
														<option value="icon-umbrella" data-icon="icon-umbrella">Umbrella</option>
														<option value="icon-wrench" data-icon="icon-wrench">Wrench</option>
														<option value="icon-ban" data-icon="icon-ban">Ban</option>
														<option value="icon-bubble" data-icon="icon-bubble">Bubble</option>
														<option value="icon-camcorder" data-icon="icon-camcorder">Camcorder</option>
														<option value="icon-camera" data-icon="icon-camera">Camera</option>
														<option value="icon-check" data-icon="icon-check">Check</option>
														<option value="icon-clock" data-icon="icon-clock">Clock</option>
														<option value="icon-close" data-icon="icon-close">Close</option>
														<option value="icon-cloud-download" data-icon="icon-cloud-download">Cloud download</option>
														<option value="icon-cloud-upload" data-icon="icon-cloud-upload">Cloud upload</option>
														<option value="icon-doc" data-icon="icon-doc">Doc</option>
														<option value="icon-envelope" data-icon="icon-envelope">Envelope</option>
														<option value="icon-eye" data-icon="icon-eye">Eye</option>
														<option value="icon-flag" data-icon="icon-flag">Flag</option>
														<option value="icon-folder" data-icon="icon-folder">Folder</option>
														<option value="icon-heart" data-icon="icon-heart">Heart</option>
														<option value="icon-info" data-icon="icon-info">Info</option>
														<option value="icon-key" data-icon="icon-key">Key</option>
														<option value="icon-link" data-icon="icon-link">Link</option>
														<option value="icon-lock" data-icon="icon-lock">Lock</option>
														<option value="icon-lock-open" data-icon="icon-lock-open">Lock open</option>
														<option value="icon-magnifier" data-icon="icon-magnifier">Magnifier</option>
														<option value="icon-magnifier-add" data-icon="icon-magnifier-add">Magnifier add</option>
														<option value="icon-magnifier-remove" data-icon="icon-magnifier-remove">Magnifier remove</option>
														<option value="icon-paper-clip" data-icon="icon-paper-clip">Paper clip</option>
														<option value="icon-paper-plane" data-icon="icon-paper-plane">Paper plane</option>
														<option value="icon-plus" data-icon="icon-plus">Plus</option>
														<option value="icon-pointer" data-icon="icon-pointer">Pointer</option>
														<option value="icon-power" data-icon="icon-power">Power</option>
														<option value="icon-refresh" data-icon="icon-refresh">Refresh</option>
														<option value="icon-reload" data-icon="icon-reload">Reload</option>
														<option value="icon-settings" data-icon="icon-settings">Settings</option>
														<option value="icon-star" data-icon="icon-star">Star</option>
														<option value="icon-symbol-female" data-icon="icon-symbol-female">Symbol female</option>
														<option value="icon-symbol-male" data-icon="icon-symbol-male">Symbol male</option>
														<option value="icon-target" data-icon="icon-target">Target</option>
														<option value="icon-volume-1" data-icon="icon-volume-1">Volume 1</option>
														<option value="icon-volume-2" data-icon="icon-volume-2">Volume 2</option>
														<option value="icon-volume-off" data-icon="icon-volume-off">Volume off</option>
													</select>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Link</label>
											<div class="col-md-9">
												<div class="input-inline">
													<div class="input-group">
														<span class="input-group-addon">
														{{ URL.'/' }}
														</span>
														<input type="text" class="form-control" id="link" name="link" placeholder="admin/menus">
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Parent Menu</label>
											<div class="col-md-9">
												<select class="form-control" name="parent_id" id="parent_id">
													<option value="0">*Root</option>
													@if( isset($arrParent['backend']) )
													@foreach($arrParent['backend'] as $parent)
													{{$parent}}
													@endforeach
													@endif
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Order no</label>
											<div class="col-md-9">
												<div id="order_spinner">
													<div class="input-group input-small">
														<input type="text" class="spinner-input form-control" minlength="1" value="1" readonly id="order_no" name="order_no">
														<div class="spinner-buttons input-group-btn btn-group-vertical">
															<button type="button" class="btn spinner-up btn-xs red">
															<i class="fa fa-angle-up"></i>
															</button>
															<button type="button" class="btn spinner-down btn-xs red">
															<i class="fa fa-angle-down"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-3 control-label">Active</label>
											<div class="col-md-9">
												<div class="checkbox-list">
													<label class="checkbox-inline">
													<input type="checkbox" id="active" name="active" value="1" checked>  </label>
												</div>
											</div>
										</div>
									</div>
									<div class="form-actions">
										<div class="row">
											<div class="col-md-offset-3 col-md-9">
												<button type="submit" class="btn green">Submit</button>
												<button type="button" id="cancel" class="btn default">Cancel</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/jquery-nestable/jquery.nestable.css' ) }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}"/>
<style type="text/css">
.pull-right > a:hover{
	text-decoration: none !important;
}
.dd3-content.active {
	background-color: #d84a38 !important;
	color: #fff !important;
}
.dd3-content:hover {
	cursor: pointer !important;
}
</style>
@stop
@section('pageJS')
<script src="{{ URL::asset( 'assets/global/plugins/fuelux/js/spinner.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/jquery-nestable/jquery.nestable.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script src="{{URL::asset( 'assets/admin/pages/scripts/ui-nestable.js') }}"></script>
<script type="text/javascript">
var parent = {{json_encode($arrParent)}};
var permission = {{json_encode($arrPermission)}};
$('#order_spinner').spinner({value:1, min: 1});

$('#icon_class').selectpicker().trigger("change");
$("#parent_id").change(function(){
	checkParentType();
});
$("#type").change(function(){
	checkParentType();
	var type = $(this).val();
	var id = $("#id").val();
	getParentByType(type, "menu_"+id);
	if( type == "backend" ) {
		$("#group-div").hide();
		$("#icon-div").show();
	} else {
		$("#group-div").show();
		$("#icon-div").hide();
		$("#group").val("header");
	}
}).val("frontend").trigger("change");


$("#menu-info #id").change(function(){
	var id = $(this).val();
	$(".dd3-content").removeClass("active");
	if( id != "" ) {
		$(".dd3-content[data-id="+ id +"]").addClass("active");
	}
});

$("#cancel", "#menu-info").click(function(){
	if( $(".fullscreen","#menu-info").hasClass("on") ) {
		$(".fullscreen","#menu-info").trigger("click");
	}
});
$("#add-menu").click(function(){
	if( !permission["frontend"].create && !permission["backend"].create ) {
		toastr.warning("You do not have permission to do this!", "Warning");
		return false;
	}
	resetInput();
	$(".fullscreen","#menu-info").trigger("click");
});
$("#form-reorder").on( "submit", function( e ) {
	e.preventDefault();
	$.ajax({
	  	url: "{{ URL.'/admin/menus/menu-reorder'}}",
	  	type: "POST",
	  	data: $('#form-reorder').serialize(),
	  	success: function(result){
	  		if( result.status == "ok" ) {
	  			$("#sidebar-menu li").not(".sidebar-toggler-wrapper").remove();
	  			$("#sidebar-menu").append(result['sidebar']);
	  			activeSidebar();
	  			parent = result.parent;
	  			$("#menu-info #id").trigger("change");
	  			toastr.success("Menu has been re-ordered.", "Message");
	  		} else if( result.status == "error" ) {
	  			toastr.error(result.message, "Error");
	  		} else {
	  			toastr.warning(result.message, "Warning");
	  		}
	  	}
	});
});
$("#update-menu").on( "submit", function( e ) {
	e.preventDefault();
	if( parseInt($("#id", this).val()) == 0 && !permission["frontend"].create && !permission["backend"].create ) {
		toastr.warning("You do not have permission to do this!", "Warning");
		return false;
	}
	$.ajax({
	  	url: "{{ URL.'/admin/menus/update-menu' }}",
	  	type: "POST",
	  	data: $('#update-menu').serialize(),
	  	success: function(result){
	  		if( result.status == "ok" ) {
	  			if( $(".fullscreen", "#menu-info").hasClass("on") ) {
	  				$(".fullscreen", "#menu-info").trigger("click");
	  			}
	  			parent = result.parent;
	  			var arrMenu = {};
	  			var arrType = [];
	  			var menu = result.menu;
	  			var i = 0;
	  			for(var type in menu) {
	  				if( type.indexOf('-') != -1 ) {
	  					type = type.split('-');
	  					if( arrMenu[type[0]] == undefined ) {
	  						arrMenu[type[0]] = {};
	  					}
	  					arrMenu[type[0]][type[1]] = '<ol class="dd-list">'+ menu[type[0]+'-'+type[1]] +'</ol>';
						arrType[i] = type[1];
	  				} else {
	  					arrMenu[type] = '<ol class="dd-list">'+ menu[type] +'</ol>';
	  					arrType[i] = type;
	  				}
	  				i++;
	  			}

				arrMenu = rsortObjectByKey(arrMenu);

	  			var arrActive = [];
	  			i = 0;
	  			$(".nav-tabs li.active a").each(function(){
	  				arrActive[i] = $(this).attr("href");
	  				i++;
	  			});

	  			var html = createTabs(arrMenu);
	  				html += '<div class="tab-content">' +
	  							createTabContent(arrMenu) +
	  						'</div>';
	  			$("#menu-order-content").html(html);
	  			$(".nav-tabs a").click(function (e) {
				  	e.preventDefault()
				  	$(this).tab('show');
				});
				var found;
				$(".nav-tabs > li > a").each(function(){
					if( $.inArray($(this).attr("href"), arrActive) != -1 ) {
						$(this).trigger("click");
						found = true;
						return false;
					}
				});
				if( !found ) {
					$(".nav-tabs > li > a:first").trigger("click");
				}
				found = false;
				$("div.tabbable-line > .nav-tabs > li > a").each(function(){
					if( $.inArray($(this).attr("href"), arrActive) != -1 ) {
						$(this).trigger("click");
						found = true;
						return false;
					}
				});
				if( !found ) {
					$("div.tabbable-line > .nav-tabs > li > a:first").trigger("click");
				}
	  			menuInit(arrType);
	  			$("#sidebar-menu li").not(".sidebar-toggler-wrapper").remove();
	  			$("#sidebar-menu").append(result['sidebar']);
	  			activeSidebar();
	  			$("#menu-info #id").trigger("change");

	  			toastr.success("Message",result['message']);
	  		} else {
	  			toastr.error(result.message, "Error");
	  		}
	  	}
	});
});
var updateOutput = function(e) {
    var list = e.length ? e : $(e.target),output = list.data('output');
    if (window.JSON) {
        output.val(window.JSON.stringify(list.nestable('serialize')));
    } else {
        alert('JSON browser support required for this.');
    }
};

menuInit({{ json_encode($arrType) }});
function bindChange(name)
{
	$('#tab-'+ name).change(function(){
	    updateOutput($('#tab-'+ name).data('output', $('#'+ name +'_store')));
	});
}
function menuInit(arrType)
{
	var maxDepth;
	for(var i in arrType) {
		var t = arrType[i];
		if( t == "header" || t == "footer" ) {
			t = "frontend";
		}
		if( !permission[t].edit ) {
			continue;
		}
		if( arrType[i] == 'backend' ) {
			maxDepth = 5;
		} else {
			maxDepth = 2;
		}
		$('#tab-'+ arrType[i]).nestable({
		    group : 1,
		    maxDepth: maxDepth
		});
		bindChange(arrType[i]);
	}
	/*$(".pull-right > a").click(function() {
		var id = $(this).attr("data-id");
		var action = $(this).attr("data-function");
		if( action == "edit" ) {
			editMenu(id);
		} else {
			deleteMenu(id);
		}
	});*/
	$(".dd3-content").click(function(){
		var id = $(this).attr("data-id");
		editMenu(id);
	});
}

function checkParentType()
{
	var parent_id = $("#parent_id").val();
	if( parent_id == 0 )
		return false;
	var parent = $("#menu-"+parent_id).val();
	parent = $.parseJSON(parent);
	if( parent.type != $("#type").val() ) {
		$("#parent_id").val(0);
	}
}
function getParentByType(type, id)
{
	var html = "<option value=\"0\">*Root</option>";
	for(i in parent[type]) {
		if( i == id ) continue;
		html += parent[type][i];
	}
	$("#parent_id").html(html);
}
function editMenu(id)
{
	if( $(".dd3-content[data-id="+ id +"]").hasClass("disabled-link") ){
		return false;
	}
	var info = $("#menu-"+id).val();
	info = $.parseJSON(info);
	for(i in info){
		if( !$("#"+i).length ) continue;
		info[i] = $.trim(info[i]);
		if( $("#"+i).is(":checkbox") ) {
			if( parseInt(info[i]) ) {
				$("#"+i).prop("checked", true);
				$("#"+i).parent().addClass("checked");
			} else {
				$("#"+i).prop("checked", false);
				$("#"+i).parent().removeClass("checked");
			}
		} else if( i == "parent_id") {
			getParentByType(info["type"], 'menu_'+info['id']);
		} else if( i == "order_no"){
			$("#order_spinner").spinner("value", info[i]);
			$("#"+i).val(info[i]);
		} else {
			$("#"+i).val(info[i]).trigger("change");
		}
	}
	$("#parent_id").val(info["parent_id"]).trigger("change");
	$("#icon_class").trigger("change");
	$("#name").focus();
	$("html, body").animate({
        scrollTop: $("#menu-info").offset().top - $(".page-header").height()
    }, 200);
}
function deleteMenu(id)
{
	bootbox.confirm("{{ 'Delete this record will also delete all of its children. Are you sure to delete this record?' }}", function(result) {
    	if(result){
    		$.ajax({
    			url: "{{ URL.'/admin/menus/delete-menu/' }}"+id,
    			success: function(result){
    				if( result.status == "success" ) {
    					$(".dd-item[data-id='" + id + "']").remove();
    					if( result.sidebar != undefined ) {
    						$("#sidebar-menu li").not(".sidebar-toggler-wrapper").remove();
    						$("#sidebar-menu").append(result.sidebar);
    						activeSidebar();
    					}
	  					toastr.success(result.message, "Message");
    				} else {
	  					toastr.error(result.message, "Error");
    				}
    				if( $("#menu-info #id").val() == id ) {
						resetInput();
    				}
    			}
    		})
    	}
    });
}

function createTabs(arrMenu)
{
	var html = '';
	var active = 0;
	for(var i in arrMenu) {
		html += '<li><a href="#tab-'+ i +'" '+( !active ? 'class="active"' : '' )+'>'+ ucfirst(i) +'</a></li>';
		active = 1;
	}
	return '<ul class="nav nav-tabs">'+ html + '</ul>';
}

function createTabContent(arrMenu)
{
	var html = '';
	for(var type in arrMenu) {
		html += '<div id="tab-'+ type + '" class=" dd tab-pane" style="min-height: 325px;">';
		if( typeof arrMenu[type] != "string" ) {
			html += '<div class="tabbable-line">'+ createTabs(arrMenu[type]) +'</div>' +
					'<div class="tab-content ">' +
						createTabContent(arrMenu[type]) +
					'</div>';
		} else {
			html += arrMenu[type] + '<input type="hidden" id="'+ type +'_store" name="'+ type +'_store" value="" />';
		}
		html += '</div>';
	}
	return html;
}

function ucfirst(str)
{
	str += '';
	var f = str.charAt(0).toUpperCase();
	return f + str.substr(1);
}

function rsortObjectByKey(obj)
{
	var keys = [];
	var sorted_obj = {};

	for(var key in obj){
	    if(obj.hasOwnProperty(key)){
	        keys.push(key);
	    }
	}

	// sort keys
	keys.sort().reverse();

	// create new array based on Sorted Keys
	$.each(keys, function(i, key){
	    sorted_obj[key] = obj[key];
	});

	return sorted_obj;
};

function resetInput()
{
	var arr = ['id','name', 'icon_class', 'link'];
	for(i in arr) {
		$("#"+arr[i]).val("").trigger("change");
	}
	var html = "<option value=\"0\">*Root</option>";
	for(i in parent) {
		html += parent[i];
	}
	$("#parent_id").html(html);
	$("#parent_id").val(0);
	$("#type").val("frontend").trigger("change");
	getParentByType("frontend","menu_0");
	$("#order_no").val(1);
	$("#order_spinner").spinner(1);
	$("#active").prop("checked", true);
	$("#active").parent().addClass("checked");
}
</script>
@stop