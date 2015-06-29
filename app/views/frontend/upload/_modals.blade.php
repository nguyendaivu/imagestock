
{{-- Upload File Modal --}}
<div class="modal fade" id="modal-file-upload">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" id="image-form" action="/upload"
            class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            &times;
          </button>
          <h4 class="modal-title">Upload New File</h4>
        </div>
        <div class="modal-body">
        
            <div class="alert alert-danger" style="display:none;">
                <button class="close" data-close="alert"></button>
                <div id="content-message">
                    <i class="fa-lg fa fa-warning"></i>
                    Please choose at least one image!.
                </div>
            </div>
        
          <div class="form-group">
          	<label for="name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-8">
            	<input type="text" name="name" value="{{ Input::old('name') }}" class="form-control" data-minlength="6" placeholder="Your image's name" required autofocus/>
            </div>
          </div>

          <div class="form-group">
          	<label for="description" class="col-sm-3 control-label">Description</label>
            <div class="col-sm-8">
              <textarea type="text" name="description" value="{{ Input::old('description') }}" data-minlength="3" class="form-control" required></textarea>
            </div>
          </div>

          <div class="form-group">
            <label for="file" class="col-sm-3 control-label">
              File
            </label>
            <div class="col-sm-8">
              <input type="file" name="myfiles[]" class="multi-pt" />
              <span class="help-block"><small>Maximum 4 files, First Image for Small, The second for Medium, The third for Large and The last is for Enhanced License.</small></span>
              <div id="div-load-multi-file"></div>
            </div>
          </div>
          
            <div class="form-group">
                <label class="col-sm-3 control-label">Image Type</label>
                <div class="col-sm-4">
                    <select class="form-control" id="type_id" name="type_id" required>
                        <option value="1">Photos</option>
                        <option value="2">Vectors</option>
                        <option value="3">Illustrations</option>
                    </select>
                </div>
            </div>
          
            <div class="form-group">
                <label class="col-sm-3 control-label">Category</label>
                <div class="col-sm-5">
                    <select class="form-control" id="categories" multiple name="category_id[]" required>
                        @foreach($categories as $category)
                        @if( $category['value'] )
                        <option value="{{ $category['value'] }}">{{ $category['text'] }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Keywords</label>
                <div class="col-sm-8">
                    <input type="text" name="keywords" value="{{ Input::old('keywords') }}" class="form-control tags" required/>
                    <span class="help-block with-errors">This field is required.</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label">Artist</label>
                <div class="col-sm-8">
                    <input type="text" name="artist" value="{{ Input::old('artist') }}" class="form-control"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Model</label>
                <div class="col-sm-8">
                    <input type="text" name="model" value="{{ Input::old('model') }}" class="form-control tags"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">With human</label>
                <div class="col-sm-1">
                    <input type="checkbox" id="with-human" class="form-control"/>
                </div>
            </div>
            <div class="form-group" id="with-human-div" style="display: none;">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="col-sm-6 control-label">Gender</label>
                        <div class="col-sm-5">
                            <select name="gender" class="form-control">
                                <option value="any">Any</option>
                                <option value="men">Men</option>
                                <option value="women">Women</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-sm-6 control-label">No of people</label>
                        <div class="col-sm-4">
                                <input type="number" name="number_people" value="" class="form-control "/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="col-md-6 control-label">Age from</label>
                        <div class="col-md-5">
                                <input type="number" name="age_from" value="" class="form-control "/>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="col-md-6 control-label">Age to</label>
                        <div class="col-sm-4">
                                <input type="number" name="age_to" value="" class="form-control "/>
                        </div>
                    </div>
                </div>
            </div>
                            
                                        
          
          <div class="form-group">
            <label for="file_name" class="col-sm-3 control-label">
              Choose destination
            </label>
            <div class="col-sm-4">
              <select name="destination_store" id="destination_store" class="form-control">
                <option value="">Current</option>
                <option value="dropbox">Dropbox</option>
              </select>
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-primary">
            Upload File
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete File Modal --}}
<div class="modal fade" id="modal-file-delete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">Please Confirm</h4>
      </div>
      <div class="modal-body">
        <p class="lead">
          <i class="fa fa-question-circle fa-lg"></i> &nbsp;
          Are you sure you want to delete the
          <kbd><span id="delete-file-name1">file</span></kbd>
          file?
        </p>
      </div>
      <div class="modal-footer">
        <form method="POST" action="/image/remove">
          <input type="hidden" name="del_file" id="delete-file-name2">
          <input type="hidden" name="image_id" id="image_id">
          <input type="hidden" name="page" id="page" value="1">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-danger">
            Delete File
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- View Image Modal --}}
<div class="modal fade" id="modal-image-view">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">
          &times;
        </button>
        <h4 class="modal-title">Image Preview</h4>
      </div>
      <div class="modal-body">
        <img id="preview-image" src="x" class="img-responsive" style="width:100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
          Cancel
        </button>
      </div>
    </div>
  </div>
</div>