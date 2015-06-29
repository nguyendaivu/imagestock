<div class="row">
	<div class="col-md-12">
		<div class="portlet">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-users"></i>Role Listing
				</div>
				<div class="actions">
					<a href="{{URL.'/admin/roles/add-role'}}" class="btn default yellow-stripe">
						<i class="fa fa-plus"></i>
						<span class="hidden-480">New Role</span>
					</a>
				</div>
			</div>
			<div class="portlet-body">
				<div class="table-container">
					<table class="table table-striped table-bordered table-hover middle-text" id="list-table">
					<thead>
					<tr role="row" class="heading">
						<th width="3%">
							 #
						</th>
						<th>ID</th>
						<th width="20%">
							 Name
						</th>
						<th width="10%">
							 Actions
						</th>
					</tr>
					<tr role="row" class="filter">
						<td></td>
						<td></td>
						<td>
							<input type="text" class="form-control form-filter input-sm" name="search[name]">
						</td>
						<td>
							<div style="text-align: center;">
								<button id="search-button" class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i> Search</button>
								<button id="cancel-button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
							</div>
						</td>
					</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' ) }}" rel="stylesheet" type="text/css"/>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript">
    var columnDefs = [
	        	{
	                "targets": 2,
	                "name": "name",
	        	},
	        	{
	                "targets": 3,
	                "name": "created_at",
	                "className": "text-center",
	        	}];
    listRecord({
    	url : "{{ URL.'/admin/roles/list-role' }}",
    	edit_url :  "{{ URL.'/admin/roles/edit-role' }}",
    	delete_url :  "{{ URL.'/admin/roles/delete-role' }}",
    	table_id : "#list-table",
    	columnDefs : columnDefs
    });
</script>
@stop