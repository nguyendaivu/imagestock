
<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>{{ 'Company Listing' }}
                </div>
                <!-- <div class="actions">
                    <a href="{{ URL }}/admin/banners/add-banner" class="btn default yellow-stripe">
                        <i class="fa fa-plus"></i>
                        <span class="hidden-480">{{ 'New Banner' }}</span>
                    </a>
                </div> -->
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-company">
                        <thead>
                            <tr role="row" class="heading">
                                <th>
                                    #
                                </th>
                                <th>
                                    Id
                                </th>
                                <th>
                                     {{'No .'}}
                                </th>
                                <th>
                                     {{'Name'}}
                                </th>
                                <th>
                                     {{'Customer'}}
                                </th>
                                <th>
                                     {{'Supplier'}}
                                </th>
                                <th>
                                     {{'Phone'}}
                                </th>
                                <th class="text-right" width="5%">
                                     {{'Net discount'}}
                                </th>
                                <th class="text-center" width="18%">
                                     {{'Tools'}}
                                </th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[no]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[name]">
                                </td>
                                <td>
                                    <select name="search[is_customer]" class="form-control form-filter input-sm">
                                        <option value="">{{ 'Select' }}...</option>
                                        <option value="yes">{{ 'Yes' }}</option>
                                        <option value="no">{{ 'No' }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select name="search[is_supplier]" class="form-control form-filter input-sm">
                                        <option value="">{{ 'Select' }}...</option>
                                        <option value="yes">{{ 'Yes' }}</option>
                                        <option value="no">{{ 'No' }}</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[phone]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-ex-sm text-right" name="search[net_discount]">
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
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script type="text/javascript">
var columnDefs = [
        {
            "targets": 2,
            "className": "text-center",
            "name"  : "no"
        },
        {
            "targets": 3,
            "name"  : "name"
        },
        {
            "targets": 4,
            "className": "text-center",
            "name"  : "is_customer",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[4] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return html;
            }
        },
        {
            "targets": 5,
            "className": "text-center",
            "name"  : "is_supplier",
            "data" : function(row, type, val, meta) {
                var html = '';
                if( row[5] ) {
                    html = '<span class="label label-sm label-success">Yes</span>';
                } else {
                    html = '<span class="label label-sm label-danger">No</span>';
                }
                return html;
            }
        },
        {
            "targets": 6,
            "name"  : "phone"
        },
        {
            "targets": 7,
            "className": "text-right",
            "name"  : "discount"
        },
    ];
listRecord({
    url: "{{ URL.'/admin/companies/list-company' }}",
    table_id: "#list-company",
    columnDefs: columnDefs,
    pageLength: 20
});
</script>
@stop