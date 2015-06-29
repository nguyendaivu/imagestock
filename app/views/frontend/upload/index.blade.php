@section('pageCSS')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/jquery-tags-input/jquery.tagsinput.css' ) }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
    <link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}" />
    <link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >
	<style type="text/css">
	.portfolio-item {
		margin-bottom: 25px;
		text-align:left;
		width:250px;		
	}
	
	.portfolio-item .image-overflow {
		overflow:hidden;
		height:200px;
	}
	
	.pdf-thumb-box-overlay {
	  display: none;
	}
	.portfolio-item a:hover .pdf-thumb-box-overlay {
	  display: inline;
	  text-align: center;
	  position: absolute;
	  transition: background 0.2s ease, padding 0.8s linear;
	  background-color: #ECEBE6;
	  width: 96%;
	  height: 40px;
	  text-shadow: 0 1px 2px rgba(0, 0, 0, .6);
	  margin-top: -40px;
	  opacity:0.7;
	  
	}
	.pdf-thumb-box-overlay div{
		display:inline-block; 
		width:50px; 
		margin-top:20px;	
	}
	
	.pdf-thumb-box-overlay span {
		color:#000;
	  position: relative;
	  top: 50%;
	  -webkit-transform: translateY(-50%);
	  -ms-transform: translateY(-50%);
	  transform: translateY(-50%);
	
	}
	
	span.glyphicon.glyphicon-eye-open
	{
		font-size:15px;
	}
	span.glyphicon.glyphicon-remove-sign
	{
		font-size:15px;
	}
	
	/*Upload*/		
	.MultiFile-label
	{
		/*border: 1px solid;*/
		margin-top: 5px;
		background-color:#FCC;
	}
	#div-load-multi-file
	{
		padding:5px;
	}	
	</style>
@stop
@section('content')

@if (Session::has('message'))
	{{--*/ $session_messages = Session::get('message') /*--}}
	@if (is_array($session_messages))
    	<div class="alert alert-warning">
    	@foreach ($session_messages as $sess_message)
        	@if ($sess_message['result'])
    			<div>{{ $sess_message['filename'] }} has been uploaded successfully!</div>
            @else
 				<div>{{ $sess_message['filename'] }} has failed!</div>                   
            @endif
        @endforeach
        </div>
    @else
    	<div class="alert alert-warning">{{ Session::get('message') }}</div>
    @endif	
@endif

<div class="container-fluid">
	
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ Auth::user()->get()->first_name }}'s Images
                    <small>
                        <button type="button" class="btn btn-primary btn-md"
                                data-toggle="modal" data-target="#modal-file-upload">
                          <i class="fa fa-upload"></i> Upload
                        </button>                    
                    </small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
		@if(count($files)>0)
			<?php
				$per_col = 5;
			?>        
            @foreach($files as $key => $file)
            @if($key%$per_col==0)
            <!-- Row -->
            <div class="row">
            @endif
                <div class="col-md-2 portfolio-item" style="padding-left:5px; padding-right:5px;">
                    <div class="image-overflow">
                          <a href="javascript:void(0)" style="cursor:default">                          
                            <img class="img-responsive" src="{{URL}}{{ $file['path'] }}" alt="{{ $file['name'] }}" style="height:100%; width:100%" />
                              <div class="pdf-thumb-box-overlay">
                                <div><span class="glyphicon glyphicon-eye-open" style="cursor:pointer" onclick="preview_image('{{URL}}{{ $file['path'] }}')"></span></div>
                                <div><span class="glyphicon glyphicon-remove-sign" style="cursor:pointer" onclick="delete_file('{{ $file['name'] }}', '{{ $file['image_id'] }}', '{{ $current }}')"></span></div>
                              </div>                            			        
                          </a>                                    
                    </div>
                	<div>
                        <h4>
                            <a href="{{URL}}/pic-{{$file['image_id']}}/{{$file['short_name']}}.html" style="overflow:hidden;">{{ Str::words($file['name'], 3, '...') }}</a>
                        </h4>
                        <p class="small">{{ Str::words($file['description'], 20, '...') }}</p>                    
                    </div>                    
                </div>
    		@if($key%$per_col==$per_col -1 || $key==count($files)-1)
            </div>
            <!-- /.row -->
            @endif
            @endforeach
        
            @if($total_image>0 && $total_page>1)
            <hr>
            <!-- Pagination -->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="pagination">
                        
                        <li>
                            @if($current > 1)
                            <a href="/upload?page={{ $current-1 }}" aria-label="Previous" data-value='prev'>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                            @endif
                        </li>
                        @for( $i = $from; $i<= $to; $i++)
                            @if($i == $current)
                            <li class="active"><a href="/upload?page={{ $i }}" data-value="{{ $i }}">{{ $i }}</a></li>
                            @else
                            <li><a href="/upload?page={{ $i }}" data-value="{{ $i }}">{{ $i }}</a></li>
                            @endif
                        @endfor
                        @if($current < $total_page)
                        <li>
                            <a href="/upload?page={{ $current+1 }}" aria-label="Next" data-value="next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        @endif
                        <li>
                            <span>{{ $current }}/{{ $total_page }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /.row -->
            @endif 
        @else
            <div class="row">
                There are no images in your uploads.
            </div>        
		@endif
    </div>
    <!-- /.container -->
</div>

@include('frontend.upload._modals')
   
@stop

@section('pageJS')
	<script src="{{URL}}/assets/global/plugins/jquery.multifile.js" type="text/javascript" language="javascript"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
    <script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>
    <script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
  
  <script>
  
    // Confirm file delete
    function delete_file(name, image_id, page) {
      $("#delete-file-name1").html(name);
      $("#delete-file-name2").val(name);
      $("#image_id").val(image_id);
	  $("#page").val(page);
      $("#modal-file-delete").modal("show");
    }

    // Preview image
    function preview_image(path) {
      $("#preview-image").attr("src", path);
      $("#modal-image-view").modal("show");
    }

    // Startup code
    $(function() {
      //$("#uploads-table").DataTable();
	  
	  $('.multi-pt').MultiFile({
		accept:'gif|jpg|jpeg|png|bmp|ai|psd|drw|svg', 
		max:4, 
		STRING: { 
		  remove:'x', 
		  selected:'Selecionado: $file', 
		  denied:'Invalid file extension $ext!', 
		  duplicate:'This file is dupplicated:\n$file!'
		},
		list: '#div-load-multi-file'
	  });

		$('#with-human').change(function(){
			if( $(this).is(':checked') ) {
				$('#with-human-div').show();
				$(this).parent().addClass('checked');
			} else {
				$('#with-human-div').hide();
				$(this).parent().removeClass('checked');
			}
		});
			
		
		$('input.tags').tagsInput({
			width: 300
		});
		
		$("#image-form").validate({
		  submitHandler: function(form) {
			// do other things for a valid form
			var myfiles = $("input[type=file]").val();
			if(myfiles)
			{
				$(".alert.alert-danger").hide();
				form.submit();
			}
			else
			{
				$(".alert.alert-danger").show();
			}
			//console.log(myfiles);
			
		  }
		});			
	  
    });
	
  </script>
@stop
