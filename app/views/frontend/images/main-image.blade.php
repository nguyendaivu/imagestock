@if (isset($imageObj))
	<div id="div-main-image" class="col-md-6" style="padding-left:0">
        <input type="hidden" name="image_id" id="image_id" value="{{ $imageObj['image_id'] }}" />
        <input type="hidden" name="image_name" id="image_name" value="{{ $imageObj['name'] }}" />
        <input type="hidden" name="image_path" id="image_path" value="{{URL}}{{ $imageObj['path'] }}" />
    
		<div id="main-image">
        	<div id="main-image-cover" class="framed">
				<img id="main-image-display" src="{{URL}}{{ $imageObj['path'] }}" class="framed" style="width:100%;"/>
            </div>
		</div>
		<div style="display:inline-block; padding-top: 15px">
			@if (Auth::user()->check())
				<div style="display:inline; padding:10px 10px 10px 10px">
					<span class="fa fa-lightbulb-o"></span>
					<a href="javascript:void(0)" id="save-lightbox" data-toggle="popover" class="small" title="Save to a lightbox">Save to a lightbox</a>
				</div>
				<div class="small" style="display:inline; padding:10px 10px 10px 10px">
					<span class="glyphicon glyphicon-search"></span>
					<a href="{{URL}}/similar-images/{{ $imageObj['name'] }}">Find similar images</a>
				</div>
				<div class="small" style="display:inline; padding:10px 10px 10px 10px">
					<span class="glyphicon glyphicon-share"></span>
					<a href="#">Share</a>
				</div>
			@endif
		</div>
        <div class="container text-left" id="div-view-keywords" style="display:inline-block; padding:25px 0 25px 0">{{ $htmlKeywords }}</div>

	</div>

	<div align="center" class="col-md-6 right_column">
		<div  style="text-align:left;">
			<h5><b>{{ $imageObj['name'] }}</b></h5>
            <p class="more">{{ $imageObj['description'] }}</p>
			<p><small>Image ID: </small>{{ $imageObj['image_id'] }}</p>
			<p><small>Copyright: </small><a href="{{URL}}/same-artist/{{$imageObj['author_id']}}">{{ $imageObj['artist'] }}</a></p>
		</div>
		@if (Auth::user()->check())
		<div  style="text-align:left;">
            <div class="panel-body">
                @if($action == 'download')
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills on_off_tab">                    
                        <li class=""><a href="#order-pills" data-toggle="tab" aria-expanded="false">Order</a></li>
                    </ul>                
                    <!-- Tab panes -->
                    <div class="tab-content" style="padding-top:15px">
                        <div class="tab-pane fade" id="order-pills">
                            {{ $htmlOrder }}
                        </div>
                        <div class="tab-pane fade active in" id="download-pills">
                            {{ $htmlChooseDownload }}
                        </div>
                    </div>
            	@else
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills on_off_tab">                    
                        <li class="active"><a href="#order-pills" data-toggle="tab" aria-expanded="true">Order</a></li>
                        <li class=""><a href="#download-pills" data-toggle="tab" aria-expanded="false">Download</a></li>                    
                    </ul>                
                    <!-- Tab panes -->
                    <div class="tab-content" style="padding-top:15px">
                        <div class="tab-pane fade active in" id="order-pills">
                            {{ $htmlOrder }}
                        </div>
                        <div class="tab-pane fade" id="download-pills">
                            {{ $htmlChooseDownload }}
                        </div>
                    </div>                
                @endif    
            </div>
        </div>
		@else
		<div style="text-align:left;">
			<div class="panel-body">
			@if($action == 'download')
                <!-- Nav tabs -->
                <ul class="nav nav-tabs on_off_tab">            	
                    <li><a href="#order" data-toggle="tab">Order</a></li>
                    <li class="active"><a href="#download" data-toggle="tab">Download</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="padding-top:15px">
                    <div class="tab-pane fade" id="order">
                        {{ $htmlOrder }}
                    </div>
                    <div class="tab-pane fade in active" id="download">                    
                        {{ $htmlSignin }}
                    </div>
                </div>
            @else
                <!-- Nav tabs -->
                <ul class="nav nav-tabs on_off_tab">            	
                    <li class="active"><a href="#order" data-toggle="tab">Order</a></li>
                    <li><a href="#download" data-toggle="tab">Download</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="padding-top:15px">
                    <div class="tab-pane fade in active" id="order">
                        {{ $htmlOrder }}
                    </div>
                    <div class="tab-pane fade" id="download">                    
                        {{ $htmlSignin }}
                    </div>
                </div>
			@endif            
        	</div>                	
        </div>
		@endif

	</div>
@endif