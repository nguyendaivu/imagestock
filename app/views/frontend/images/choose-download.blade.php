<ul class="nav nav-tabs" role="tablist" id="myTab">
  <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">Standard license JPEG</a></li>
  <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">Enhanced License TIFF</a></li>
</ul>

<div>
	<div class="tab-content">
	  <div role="tabpanel" class="tab-pane active" id="tab1">
		  <div class="list-group" style="display:block">
			<table class="size-list">
		  	@for ($i=0; $i<3; $i++)
				@if (isset($arrImageDetails[$i]))
				<tr class="list-group-item {{( !$i ) ? 'active' : '' }}" >
					<td>
						<input id="size-type-{{$i+1}}" type="radio" @if( !$i ) checked @endif value="{{ $arrImageDetails[$i]['detail_id'] }}" name="size_type">
					</td>
					<td>{{$arrImageDetails[$i]['size_name']}}</td>
					<td>{{$arrImageDetails[$i]['width']}}x{{$arrImageDetails[$i]['height']}}</td>
					<td>({{$arrImageDetails[$i]['dpi']}}dpi)</td>
					<td>{{human_filesize($arrImageDetails[$i]['size'])}}</td>
				</tr>
				@endif
		  	@endfor
			</table>
		  </div>
	  </div>
	  <div role="tabpanel" class="tab-pane" id="tab2" style="padding-top:10px">
	  <div class="list-group">
	  <p>Our Enhanced License allows for unlimited runs for merchandising uses as well as high-viewership commercial uses. See our License Comparison page for more info.</p>
	  @for ($i=0; $i<5; $i++)
		@if (isset($arrImageDetails[$i]) && $arrImageDetails[$i]['size_name'] == 'Supper')
			<div style="display:inline-block">
				<input type="radio" value="small_jpg" name="size_type">
			</div>
			<div style="display:inline-block">
				<span style="padding-right: 25px">Large</span>
				<span style="padding:0 25px 0 25px">{{$arrImageDetails[$i]['width']}}x{{$arrImageDetails[$i]['height']}}</span>
				<span style="padding:0 25px 0 25px">({{$arrImageDetails[$i]['dpi']}}dpi)</span>
				<span style="padding:0 25px 0 25px">{{$arrImageDetails[$i]['size']}} KB</span>
			</div>
		@endif
	  @endfor
	  </div>
	  </div>
	</div>
	<div class="col-md-10">
    	<div style="display:inline-block; width:150px">
        	<button id="download-btn" type="button" class="btn btn-primary btn-block">Download</button>
        </div>
	</div>
</div>