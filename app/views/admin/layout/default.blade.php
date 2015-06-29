<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8"/>
	<title>{{ $title or 'Admin Control Panel' }}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content="width=device-width, initial-scale=1" name="viewport"/>
	<!-- BEGIN GLOBAL MANDATORY STYLES -->
	<link href="{{ URL::asset( 'assets/global/plugins/pace/themes/pace-theme-flash.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet') }}" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet') }}" type="text/css"/>
	<link href="{{ URL::asset( 'assets/global/plugins/bootstrap-toastr/toastr.min.css' )}}" rel="stylesheet" type="text/css"/>
	<!-- END GLOBAL MANDATORY STYLES -->
	<!-- BEGIN PAGE STYLES -->
	@yield('pageCSS')
	<!-- END PAGE STYLES -->
	<!-- BEGIN THEME STYLES -->
    <link href="{{ URL::asset( 'assets/admin/layout/css/themes/'.( isset($currentTheme['color']) ? $currentTheme['color'] : 'default').'.css') }}" rel="stylesheet" type="text/css" id="style-color"/>
    <link href="{{ URL::asset( 'assets/global/css/'. ( isset($currentTheme['style']) ? $currentTheme['style'] : 'components') .'.css') }}" id="style-components" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/admin/layout/css/google-font.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset( 'assets/global/css/plugins.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset( 'assets/admin/layout/css/layout.css') }}" rel="stylesheet" type="text/css"/>
	<link href="{{ URL::asset( 'assets/admin/layout/css/custom.css') }}" rel="stylesheet" type="text/css"/>
	<!-- END THEME STYLES -->
	<link rel="shortcut icon" href="{{ URL::asset( 'assets/admin/layout/img/favicon.png') }}"/>
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
@yield('body', '<body class="page-header-fixed page-header-fixed-mobile page-quick-sidebar-over-content page-style-square">')
@include('admin.layout.header')
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	@include('admin.layout.sidebar')
	<div class="page-content-wrapper">
		<div class="page-content">
            @include('admin.layout.theme-option')
			@include('admin.layout.breakcum')
			{{ $content or '' }}
			@yield('content')
		</div>
	</div>
	@if(1 == 2)
	@include('admin.layout.quick-sidebar')
	@endif
</div>
<!-- END CONTAINER -->
@include('admin.layout.footer')

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="{{URL::asset( 'assets/global/plugins/respond.min.js') }}"></script>
<script src="{{URL::asset( 'assets/global/plugins/excanvas.min.js') }}"></script>
<![endif]-->
<script src="{{ URL::asset( 'assets/global/plugins/pace/pace.min.js' ) }}" data-pace-options='{ "ajax": false }' type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/global/scripts/node_modules/socket.io/node_modules/socket.io-client/socket.io.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery-migrate.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') }}" type="text/javascript"></script>

<script src="{{URL::asset( 'assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/uniform/jquery.uniform.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/scripts/metronic.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/bootstrap-toastr/toastr.min.js') }}"></script>
<script src="{{URL::asset( 'assets/admin/pages/scripts/ui-toastr.js') }}"></script>
<script src="{{URL::asset( 'assets/admin/layout/scripts/layout.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/admin/layout/scripts/quick-sidebar.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/admin/layout/scripts/backend.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery-idle-timeout/jquery.idletimeout.js' ) }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/plugins/jquery-idle-timeout/jquery.idletimer.js' ) }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/scripts/ion.sound.min.js' ) }}" type="text/javascript"></script>
<script src="{{URL::asset( 'assets/global/scripts/pusher.min.js' ) }}" type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<script type="text/javascript">
$.ajaxSetup({
    beforeSend: function (request, settings) {
        if( settings.url.indexOf('{{ URL }}') != -1 ) {
            request.setRequestHeader("X-CSRF-Token", '{{ csrf_token() }}');
        }
    },
});
function listRecord(object)
{
    Metronic.setAssetsPath("{{ URL.'/assets/' }}");
	var url = object.url;
    if( url == undefined ) {
        alert("Missing url");
        return false;
    }
	var view_url = object.view_url;
	var edit_url = object.edit_url;
    var delete_url = object.delete_url;
	var delete_message = object.delete_message;
	var table_id = object.table_id;
    var columnDefs = object.columnDefs;
	var callBack = object.fnDrawCallback;
    var pageLength = 10;
    if( object.pageLength != undefined )
        pageLength = object.pageLength;
	var errorAjax = function(result, table_id){
		var message = "{{ 'Could not complete request. Please check your internet connection' }}";
    	if($.inArray(result.responseJSON.error.message, [undefined, ""]) == -1)
    		message = result.responseJSON.error.message;
        Metronic.alert({
            type: 'danger',
            icon: 'warning',
            message: message,
            container: ".dataTables_wrapper",
            place: 'prepend'
        });
        Metronic.unblockUI(table_id);
	}
	var originalColumnDefs = [
        	{
                "targets": 0,
        		"orderable": false,
        	},
            {
                "targets": 1,
                "name" : "id",
                "visible": false
            },
        ];
    var found = false;
    for( i in columnDefs) {
        if( columnDefs[i].targets == -1 ) {
            found = true;
            break;
        }
    }
    if( !found ) {
        var lastCell = "";
        if( view_url != undefined ) {
            lastCell += '<a class="btn btn-sm btn-primary yellow btn-view-button" href="javascript:void(0);" data-toggle="tooltip" title=" {{ "View" }} "><i class="fa fa-eye"></i></a>&nbsp;';
        }
        if( edit_url != undefined ) {
            lastCell += '<a class="btn btn-primary btn-edit-button btn-sm" href="javascript:void(0);" data-toggle="tooltip" title=" {{ "Edit" }} "><i class="fa fa-pencil"></i></a>&nbsp;';
        }
        if( delete_url != undefined ) {
            lastCell += '<a class="btn btn-primary red btn-delete-button btn-sm" href="javascript:void(0);" data-toggle="tooltip" title="{{ "Delete" }}"><i class="fa fa-times"></i> </a>';
        }
        originalColumnDefs[2] = {
                "targets": -1,
                "orderable": false,
                "className": "text-center",
                "data": null,
                "defaultContent": lastCell
            };
    }
    columnDefs = originalColumnDefs.concat(columnDefs);
	var table = $(table_id).DataTable({
		"bStateSave": true,
        "lengthMenu": [
            [10, 20, 50, 100, 150],
            [10, 20, 50, 100, 150]
        ],
        "pagingType": "bootstrap_extended",
        "pageLength": pageLength,
        "ajax": {
            url: url,
            type : "POST",
            data: function(data) {
            	delete(data.search);
            	Metronic.blockUI({
                    message: "{{ 'Loading' }}",
                    target: table_id,
                    overlayColor: 'none',
                    cenrerY: true,
                    boxed: true
                });
                $("input, select", $("thead > tr:eq(1)",table_id)).each(function(){
                	data[$(this).attr("name")] = $(this).val();
                });
            	return data;
            },
            dataSrc: function(result){
                Metronic.unblockUI(table_id);
                return result.data;
            },
            error: function(result) {
            	errorAjax(result, table_id);
            },
        },
        "dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r><'table-scrollable't><'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",
        "language": {
            "lengthMenu": "<span class='seperator'>|</span>{{'View'}} _MENU_ {{'records'}}",
            "info": "<span class='seperator'>|</span>{{'Found total'}} _TOTAL_ {{'records'}}",
            "infoEmpty": "No records found to show",
            "emptyTable": "No data available in table",
            "zeroRecords": "No matching records found",
            "paginate": {
                "previous": "Prev",
                "next": "Next",
                "last": "Last",
                "first": "First",
                "page": "{{'Page'}}",
                "pageOf": "{{'of'}}"
            }
        },
        "autoWidth": false,
        "processing": false,
        "serverSide": true,
        "orderCellsTop": true,
        "columnDefs": columnDefs,
        "order": [[ 1, "desc" ]],
        "fnDrawCallback": function(){
            if( typeof callBack == "function"  )
                callBack();
            $('[data-toggle="tooltip"]',table_id).tooltip();
        }
    });
	$("#cancel-button", table_id).click(function(){
		$("input,select", $(this).closest("tr")).val("");
		table.ajax.reload();
	});
	$("#search-button", table_id).click(function(){
		table.ajax.reload();
	});
    $("[name^='search[']", table_id).change(function() {
        $("#search-button", table_id).trigger("click");
    }).keypress(function(event) {
        if( event.which == 13 ) {
            $("#search-button", table_id).trigger("click");
        }
    });
    if( edit_url != undefined ) {
        $(table_id).on( 'click', '.btn-edit-button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            window.location = edit_url+"/"+data[1];
        });
    }
    if( view_url != undefined ) {
        $(table_id).on( 'click', '.btn-view-button', function () {
            var data = table.row( $(this).parents('tr') ).data();
            window.location = view_url+"/"+data[1];
        });
    }
    if( delete_url != undefined ) {
        $(table_id).on( 'click', '.btn-delete-button', function () {
            var TR = $(this).parents('tr');
            var data = table.row( TR ).data();
            var message = delete_message || "{{ 'Are you sure to delete this record?' }}";
            bootbox.confirm(message, function(result) {
                if(result){
                    $.ajax({
                        url : delete_url+"/"+data[1],
                        success: function(result){
                            if(result.status != "ok") {
                                Metronic.alert({
                                    type: 'danger',
                                    icon: 'warning',
                                    message: result.message,
                                    container: ".dataTables_wrapper",
                                    place: 'prepend'
                                });
                            } else {
                                toastr.success(result.message, 'Message');
                                $(TR).fadeOut().remove();
                            }
                        },
                        error : function(result){
                            errorAjax(result, table_id);
                        }
                    });
                }
            });
        } );
    }
}

function deleteRecord(obj)
{
    var deleteUrl = obj.deleteUrl;
    var returnUrl = obj.returnUrl;
    if( deleteUrl == undefined || returnUrl == undefined )
        return false;
    bootbox.confirm("Are you sure you want to delete current record?", function(result){
        if(result) {
            $.ajax({
                url : deleteUrl,
                success : function(result){
                    if(result.status != "ok") {
                        Metronic.alert({
                            type: 'danger',
                            icon: 'warning',
                            message: result.message,
                            place: 'prepend'
                        });
                    } else {
                        toastr.success("{{ 'The record has been deleted successful.<br/> This page will be redirected after 5 secs.' }}", 'Message');
                        setTimeout(function(){
                            window.location = returnUrl;
                        }, 5000);
                    }
                }
            })
        }
    });
}

function activeSidebar()
{
    var replaceArr = ["{{URL}}/admin/","{{URL}}/admin","{{URL}}/","{{URL}}"];
    var currentURL = location.href.replace("{{URL}}/admin/","").replace("{{URL}}/admin","");
    var found = false;
    $("#sidebar-menu").find("a").each(function(){
        var href = $(this).attr("href");
        for(i in replaceArr) {
            href = href.replace(replaceArr[i],"");
        }
        href = href.replace(["{{URL}}","{{URL}}/","{{URL}}/admin","{{URL}}/admin/"]);
        if( $.inArray(href,['javascript:;','javascript:void(0)','#','undefined',null]) != -1 ) return;
        if( href == "" && currentURL == "" ){
            found = true;
        }
        if( href && currentURL.indexOf(href) != -1 ) {
            found = true;
        }
        if( found ) {
            $(".title",this).after('<span class="selected"></span>');
            var li = $(this).closest("li");
            $(li).addClass("active");
            while( $(li).closest("ul.sub-menu").length ) {
                $(li).closest("ul.sub-menu").show();
                li = $(li).closest("ul.sub-menu").closest("li");
            }
            $(li).addClass("active open");
            return false;
        }
    });
}

function idleTime()
{
    var countdown;
    $('body').append('<div class="modal fade" id="idle-timeout-dialog" data-backdrop="static"><div class="modal-dialog modal-small"><div class="modal-content"><div class="modal-header"><h4 class="modal-title">Your session is about to expire.</h4></div><div class="modal-body"><p><i class="fa fa-warning"></i> You session will be locked in <span id="idle-timeout-counter"></span> seconds.</p><p>Do you want to continue your session?</p></div><div class="modal-footer"><button id="idle-timeout-dialog-logout" type="button" class="btn btn-default">No, Logout</button><button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-primary" data-dismiss="modal">Yes, Keep Working</button></div></div></div></div>');
    $.idleTimeout('#idle-timeout-dialog', '.modal-content button:last', {
        idleAfter: 15*60*60, // 15 min
        pollingInterval: 15*60*60,
        keepAliveURL: "{{ URL.'/admin/touch' }}",
        serverResponseEquals: 'OK',
        timeout: 30000, //30 seconds to timeout
        onTimeout: function(){
            window.location = "{{ URL.'/admin/lock' }}";
        },
        onIdle: function(){
            $('#idle-timeout-dialog').modal('show');
            countdown = $('#idle-timeout-counter');
            $('#idle-timeout-dialog-keepalive').on('click', function () {
                $('#idle-timeout-dialog').modal('hide');
            });
            $('#idle-timeout-dialog-logout').on('click', function () {
                $('#idle-timeout-dialog').modal('hide');
                $.idleTimeout.options.onTimeout.call(this);
            });
        },
        onCountdown: function(counter){
            countdown.html(counter);
        }
    });
}

function changeTheme(theme)
{
    $.ajax({
        url: "{{ URL.'/admin/admins/change-theme' }}",
        data: { theme: theme },
        type: "POST",
        success: function(result){
            if( result.status == "error" ) {
                toastr.error(result.message, "Error");
            }
        }
    });
}

ion.sound({
    sounds: [
        {
            name: "notification"
        },
    ],
    volume: 1,
    path: "{{ URL }}/assets/global/sounds/",
    preload: true
});
function playSound(){
    ion.sound.play("notification");
}
Metronic.init(); // init metronic core componets
Layout.init(); // init layout
@if( 1 == 2 )
QuickSidebar.init({admin : "{{ $admin->id }}", url : "{{ URL }}", socket_url : "{{ SOCKET_URL }}" }); // init quick sidebar
@endif
Backend.init(); // init backend features
UIToastr.init();
activeSidebar();
idleTime();
toastr.options = {
    "closeButton": true,
    "debug": false,
    "positionClass": "toast-top-right",
    "onclick": null,
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
@if(Session::has('flash_success'))
toastr.success("{{Session::get('flash_success')}}", 'Message');
@elseif(Session::has('flash_error'))
<?php
    $errorArr = (array)Session::get('flash_error');
    $error = '';
    foreach($errorArr as $err){
        $error .= '<p>'.$err.'</p>';
    }
?>
Metronic.alert({
    type: 'danger',
    icon: 'warning',
    block: true,
    title: 'Error',
    message: "{{ $error }}",
    place: 'append',
    focus: true
});
@endif
@if(Session::has('flash_info'))
toastr.info("{{Session::get('flash_info')}}", 'Info');
@endif
@if(Session::has('flash_warning'))
toastr.warning("{{Session::get('flash_warning')}}", 'Warning');
@endif
var pusher = new Pusher('8eecabfcb277a78c45a4');
var channel = pusher.subscribe('notification');
channel.bind('get', function(data) {
    localStorage.removeItem("synchronize");
    toastr.options.timeOut = 60000;
    toastr.clear();
    if( data.status == "success" ){
        toastr.success(data.message, 'Message');
        $("#updated-at").text(data.updated_at);
        $("#updated-time").text(data.updated_time);
    } else {
        toastr.info(data.message, 'Info');
    }
});
</script>
<!-- END JAVASCRIPTS -->
<!-- BEGIN PAGE JS -->
@yield('pageJS')
<!-- END PAGE JS -->
</body>
<!-- END BODY -->
</html>