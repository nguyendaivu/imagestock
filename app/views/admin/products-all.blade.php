
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa icon-bag"></i>{{ 'Product Listing' }}
                </div>
                <div class="actions">
                    <a href="{{ URL }}/admin/products/add-product" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">{{ 'New Product' }}</span>
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-product">
                        <thead>
                            <tr role="row" class="heading">
                                <th>#</th>
                                <td>Id</td>
                                <th width="20%">Name</th>
                                <th>SKU</th>
                                <th width="15%" class="text-right">Cost price</th>
                                <th class="text-center">Main Image</th>
                                <th width="5%" class="text-center"><i class="fa fa-book" data-toggle="tooltip" title="Short Description"></i></th>
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
                                    <input type="text" class="form-control form-filter input-sm" name="search[sku]">
                                </td>
                                <td>
                                </td>
                                <td>
                                    <select data-toggle="tooltip" title="Search Category" class="form-control form-filter input-sm" name="search[category][]" multiple>
                                        @if( isset($arrCategories) )
                                        @foreach($arrCategories as $category)
                                        <option value="{{ $category['value'] }}">{{ $category['text'] }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[short_description]">
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
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/select2/select2.css' ) }}" />
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/select2/select2.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js' ) }}"></script>
<script type="text/javascript">
var columnDefs = [
        {
            "targets": 2,
            "name"  : "name",
            "data" : function(row, type, val, meta) {
                if( row[2].indexOf('|') != -1 ) {
                    var data = row[2].split('|');
                    return '<a data-toggle="tooltip" title="Click to edit" href="{{ URL }}/admin/products/edit-product/'+ row[1] +'">'+ data[0] +'</a>' + data[1];
                }
                return '<a data-toggle="tooltip" title="Click to edit" href="{{ URL }}/admin/products/edit-product/'+ row[1] +'">'+ row[2] +'</a>';
            }
        },
        {
            "targets": 3,
            "name"  : "sku"
        },
        {
            "targets": 4,
            "sortable"  : false,
            "data" : function(row, type, val, meta) {
                var value = row[4].split("|");
                return '<span style="float: left" data-toggle="tooltip" title="Smallest size">'+ value[0] +'</span><span style="float: right;">'+ value[1] +'</span>';
            }
        },
        {
            "targets": 5,
            "className" : "text-center",
            "sortable"  : false,
            "data" : function(row, type, val, meta) {
                return '<img style="max-height: 110px;" src="'+ row[5] +'" />';
            }
        },
        {
            "targets": 6,
            "name"  : "short_description",
            "className" : "text-center",
            "data" : function(row, type, val, meta) {
                return '<i class="fa fa-book" data-placement="right" data-toggle="tooltip" title="'+ row[6] +'"></i>';
            }
        },
        {
            "targets": 7,
            "className" : "text-center",
            "name"  : "active",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[7] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="active" data-type="select" data-value="'+row[7]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/products/update-product' }}" data-title="Active">'+html+'</a>';
            }
        },
    ];
listRecord({
    url: "{{ URL.'/admin/products/list-product' }}",
    edit_url: "{{ URL.'/admin/products/edit-product' }}",
    delete_url: "{{ URL.'/admin/products/delete-product' }}",
    table_id: "#list-product",
    columnDefs: columnDefs,
    pageLength: 20,
    fnDrawCallback: function(){
        $("[data-toggle=tooltip]").tooltip();
        $(".xeditable-select[data-name=active]","#list-product").editable({
            source: [{value: 1, text: "Yes"},{value: 0, text: "No"}],
            success: function(response, newValue){
                if( response.status == "ok" ) {
                    toastr.success(response.message, 'Message');
                } else {
                    return response.message;
                }
            }
        });
    },
});
$("select[name='search[category][]']","#list-product").select2({
    allowClear: true
});
</script>
@stop