<div class="row">
    <div class="col-md-12">
        <div class="portlet">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa icon-orders"></i>{{ 'Order Listing' }}
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-container">
                    <table class="table table-striped table-hover table-bordered" id="list-order">
                        <thead>
                            <tr role="row" class="heading">
                                <th>
                                    #
                                </th>
                                <th>Id</th>
                                <th>
                                   Name
                                </th>
                                <th>
                                    Billing address
                                </th>
                                <th>
                                    Shipping address
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Sum sub total
                                </th>
                                <th>
                                    Discount
                                </th>
                                <th>
                                    Sum tax
                                </th>
                                <th>
                                    Note
                                </th>
                                <th class="text-center" width="18%">
                                     {{'Tools'}}
                                </th>
                            </tr>
                            <tr role="row" class="filter">
                                <td></td>
                                <td></td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[full_name]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[billing_address_id]">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-filter input-sm" name="search[shipping_address_id]">
                                </td>
                                <td>
                                    <select name="search[status]" class="form-control form-filter input-sm">
                                        <option value=""></option>
                                        <option value="New">{{ 'New' }}</option>
                                        <option value="Submitted">{{ 'Submitted' }}</option>
                                        <option value="In production">{{ 'In production' }}</option>
                                        <option value="Partly shipped">{{ 'Partly shipped' }}</option>
                                        <option value="Completed">{{ 'Completed' }}</option>
                                        <option value="Cancelled">{{ 'Cancelled' }}</option>
                                    </select>
                                </td>
                                <td>
                                   <input type="text" class="form-control form-filter input-sm" name="search[sum_sub_total]">
                                </td>
                                <td>
                                   <input type="text" class="form-control form-filter input-sm" name="search[discount]">
                                </td>
                                <td>
                                   <input type="text" class="form-control form-filter input-sm" name="search[sum_tax]">
                                </td>
                                <td>
                                   <input type="text" class="form-control form-filter input-sm" name="search[note]">
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
            "name"  : "user_id"
        },
        {
            "targets": 3,
            "name"  : "billing_address_id",
            "className" : "limit-text",
            "data" : function(row, type, val, meta) {
                var html = '';
                html='<span data-title="'+row[8]+'">'+row[3].replace("<br />"," ")+'</span>'
                return html;
            }
        },
        {
            "targets": 4,
            "name"  : "shipping_address_id",
            "className" : "limit-text",
            "data" : function(row, type, val, meta) {
                var html = '';
                html='<span data-title="'+row[9]+'">'+row[4].replace("<br />"," ")+'</span>'
                return html;
            }
        },
        {
            "targets": 5,
            "className" : "text-center",
            "name"  : "status",
            "data" : function(row, type, val, meta) {
                var html = '';
                var label = {
                        'New' : 'label-default',
                        'Submitted' : 'label-info',
                        'In production' : 'label-primary',
                        'Partly shipped' : 'label-warning',
                        'Completed' : 'label-success',
                        'Cancelled' : 'label-danger'
                };
                html = '<span class="label '+ label[row[5]] +'">'+ row[5] +'</span>';
                return '<a href="javascript:void(0)" class="xeditable-select" data-escape="true" data-name="status" data-type="select" data-value="'+row[5]+'" data-pk="'+row[1]+'" data-url="{{ URL.'/admin/orders/update-order'}}" data-title="On Menu">'+html+'</a>';
            }
        },
        {
            "targets": 6,
            "className" : "text-center",
            "name"  : "sum_sub_total",
        },
    ];
listRecord({
    url: "{{ URL.'/admin/orders/list-order' }}",
    //edit_url: "{{ URL.'/admin/orders/edit-order' }}",
    table_id: "#list-order",
    columnDefs: columnDefs,
    pageLength: 20,
    fnDrawCallback: function(){
        $("tbody td.limit-text","#list-order").tooltip({
                placement:"top",
                html:true,
                title: function(){
                    return $(this).find('span').attr("data-title");
                },
                container: 'body'
        });
        $(".xeditable-select","#list-order").editable({
            source: [{value: "New", text: "New"},{value: "Submitted", text: "Submitted"},{value: "In production", text: "In production"},{value: "Partly shipped", text: "Partly shipped"},{value: "Completed", text: "Completed"},{value: "Cancelled", text: "Cancelled"}],
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
</script>
@stop