
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa icon-grid"></i>{{ 'Page Listing' }}
                </div>
                <div class="actions">
                    <a href="{{ URL }}/admin/pages/add-page" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">{{ 'New Page' }}</span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-page">
                        <thead>
                            <tr role="row" class="heading">
                                <th>#</th>
                                <td>Id</td>
                                <th>Name</th>
                                <th>Type</th>
                                <th class="text-center">Include on Menu</th>
                                <th class="text-center">Active</th>
                                <th class="text-center" width="18%">
                                     {{'Tools'}}
                                </th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[name]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[type]">
                                </td>
                                <td>
                                    <select name="search[on_menu]" class="form-control form-filter input-sm">
                                        <option value=""></option>
                                        <option value="yes">{{ 'Yes' }}</option>
                                        <option value="no">{{ 'No' }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="search[active]" class="form-control form-filter input-sm">
                                        <option value=""></option>
                                        <option value="yes">{{ 'Yes' }}</option>
                                        <option value="no">{{ 'No' }}</option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <button id="search-button" class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i>{{ 'Search' }}</button>
                                    <button id="cancel-button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i>{{ 'Reset' }}</button>
                                </td>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js' ) }}"></script>
<script type="text/javascript">
var columnDefs = [
        {
            "targets": 2,
            "name"  : "name"
        },
        {
            "targets": 3,
            "name"  : "type",
        },
        {
            "targets": 4,
            "className" : "text-center",
            "name"  : "active",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[4] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="on_menu" data-type="select" data-value="'+row[4]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/pages/update-page' }}" data-title="On Menu">'+html+'</a>';
            }
        },
        {
            "targets": 5,
            "className" : "text-center",
            "name"  : "active",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[5] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[5]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/pages/update-page' }}" data-title="Active">'+html+'</a>';
            }
        },
    ];
listRecord({
    url: "{{ URL.'/admin/pages/list-page' }}",
    edit_url: "{{ URL.'/admin/pages/edit-page' }}",
    delete_url: "{{ URL.'/admin/pages/delete-page' }}",
    table_id: "#list-page",
    columnDefs: columnDefs,
    pageLength: 20,
    fnDrawCallback: function(){
        $(".xeditable-select","#list-page").editable({
            source: [{value: 1, text: "Yes"},{value: 0, text: "No"}]
        });
    },
});
</script>
@stop