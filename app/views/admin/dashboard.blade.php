<div class="clearfix">
</div>
<div class="row">
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue-madison">
			<div class="visual">
				<i class="fa fa-users"></i>
			</div>
			<div class="details">
				<div class="number">
					 {{ number_format($notifications['users']) }}
				</div>
				<div class="desc">
					 New Users
				</div>
			</div>
			<a class="more" href="{{ URL.'/admin/users' }}">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat red-intense">
			<div class="visual">
				<i class="fa fa-photo"></i>
			</div>
			<div class="details">
				<div class="number">
					 {{ number_format($notifications['images']) }}
				</div>
				<div class="desc">
					 New Images
				</div>
			</div>
			<a class="more" href="{{ URL.'/admin/images' }}">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat green-haze">
			<div class="visual">
				<i class="fa fa-shopping-cart"></i>
			</div>
			<div class="details">
				<div class="number">
					 {{ number_format($notifications['orders']) }}
				</div>
				<div class="desc">
					 New Orders
				</div>
			</div>
			<a class="more" href="{{ URL.'/admin/orders' }}">
			View more <i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple-plum">
			<div class="visual">
				<i class="fa fa-clock-o"></i>
			</div>
			<div class="details">
				<div class="clock"></div>
			</div>
			<span class="more pull-right" style="width: 100%;">
				<div class="pull-right caption-subject bold uppercase">{{ $date['current_date']->format('F d, Y') }}</div>
			</span>
		</div>
	</div>
</div>
@section('pageCSS')
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css' ) }}"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/flipclock/css/flipclock.css' ) }}"/>
<style type="text/css">
.flip-clock-wrapper {
	margin: 20px 0px 0px 30px !important
}
.flip-clock-wrapper ul.flip {
	height: 40px !important;
	width: 40px !important;
	line-height: 40px !important;
}
.flip-clock-wrapper ul li {
	line-height: 40px !important;
}
.flip-clock-wrapper div.inn {
	font-size: 20px !important;
}
.flip-clock-wrapper ul.flip:nth-child(7), .flip-clock-wrapper ul[class~='flip']:last-of-type {
	display: none !important;
}
.flip-clock-wrapper span[class~='flip-clock-divider']:last-of-type  {
	display: none !important;
}
.flip-clock-wrapper span.flip-clock-divider {
	height: 55px !important;
}
.chart-tooltip span.label {
	display: inline !important;
}
</style>
@stop
@section('pageJS')
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-daterangepicker/moment.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/flot/jquery.flot.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/flot/jquery.flot.resize.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/flot/jquery.flot.categories.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/flipclock/js/flipclock.min.js' ) }}"></script>
<script type="text/javascript">
$('.clock').FlipClock({
	clockFace: 'TwentyFourHourClock'
});
$('#order-statistics-range').daterangepicker({
	    startDate: '{{ $date['start_date']->format('m/d/Y') }}',
	    endDate: '{{ $date['max_date'] }}',
	    minDate: '{{ $date['min_date'] }}',
	    maxDate: '{{ $date['max_date'] }}',
	    showWeekNumbers: true,
	    buttonClasses: ['btn btn-sm'],
	    applyClass: ' blue',
	    cancelClass: 'default',
	    format: 'MM/DD/YYYY',
	    separator: ' to ',
	    locale: {
	        applyLabel: 'Apply',
	        fromLabel: 'From',
	        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
	        monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
	        firstDay: 1
	    }
	},
	function (start, end) {
	    $('#order-statistics-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	    updateChart(true);
	}
);
$("#order-statistics-container select").change(function(){
	updateChart(true);
});
$("#order-statistics-container select:first").trigger("change");
$('#order-statistics-range span').html('{{ $date['start_date']->format('F d, Y') }} - {{ $date['current_date']->format('F d, Y') }}');
$('#order-statistics-range').show();

var previousPoint2 = null;
$('#order-statistics-loading').hide();
$('#order-statistics-content').show();

var previousPoint = null;
$("#order-statistics").bind("plothover", function (event, pos, item) {
    $("#x").text(pos.x.toFixed(2));
    $("#y").text(pos.y.toFixed(2));
    if (item) {
        if (previousPoint != item.dataIndex) {
            previousPoint = item.dataIndex;

            $("#tooltip").remove();
            var x = item.datapoint[0].toFixed(2),
                y = item.datapoint[1].toFixed(2);
                data = item.series.data[item.dataIndex][2];
            showChartTooltip(item.pageX, item.pageY, x, '<b>' + y + ' $</b>' + data );
        }
    } else {
        $("#tooltip").remove();
        previousPoint = null;
    }
});
$("[data-toggle=tooltip]").tooltip();
$('.bs-select').selectpicker({
    iconBase: 'fa',
    tickIcon: 'fa-check'
});

function updateChart(data)
{
	if( data == true ) {
		var dataPost = {};
		$("select", "#order-statistics-container").each(function(){
			dataPost[ $(this).attr("name") ] = $(this).val();
		});
		dataPost["date_start"] = $("[name=daterangepicker_start]").val();
		dataPost["date_end"] = $("[name=daterangepicker_end]").val();
		$.ajax({
			url: "{{ URL.'/admin/dashboards/get-order-statistic' }}",
			data: dataPost,
			type: "POST",
			async: false,
			success: function(result){
				if( result.status == "ok" ) {
					data = result.data;
				}
			}
		});
	}
	var newData = [{
				    data: data,
				    lines: {
				        fill: 0.2,
				        lineWidth: 0,
				    },
				    color: ['#BAD9F5']
				}, {
				    data: data,
				    points: {
				        show: true,
				        fill: true,
				        radius: 4,
				        fillColor: "#9ACAE6",
				        lineWidth: 2
				    },
				    color: '#9ACAE6',
				    shadowSize: 1
				}, {
				    data: data,
				    lines: {
				        show: true,
				        fill: false,
				        lineWidth: 3
				    },
				    color: '#9ACAE6',
				    shadowSize: 0
				}];
	var options = {
        		xaxis: {
		            tickLength: 0,
		            tickDecimals: 0,
		            mode: "categories",
		            min: 0,
		            font: {
		                lineHeight: 18,
		                style: "normal",
		                variant: "small-caps",
		                color: "#6F7B8A"
		            }
		        },
		        yaxis: {
		            ticks: 5,
		            tickDecimals: 0,
		            min: 0,
		            tickColor: "#eee",
		            font: {
		                lineHeight: 14,
		                style: "normal",
		                variant: "small-caps",
		                color: "#6F7B8A"
		            }
		        },
		        grid: {
		            hoverable: true,
		            clickable: true,
		            tickColor: "#eee",
		            borderColor: "#eee",
		            borderWidth: 1
		        }
		    };
	$.plot("#order-statistics", newData, options);
}

function showChartTooltip(x, y, xValue, yValue)
{
    $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 40,
        border: '0px solid #ccc',
        padding: '2px 6px',
        'background-color': '#fff'
    }).appendTo("body").fadeIn(200);
}
function syncData()
{
	var synchronize = localStorage.getItem("synchronize");
	var callBack = function(repeat){
    	toastr.options.timeOut = 60000;
    	toastr.clear();
    	if( repeat ) {
			toastr.info("The data synchronization has been actived. <br />An alert will be shown whenever this process is done.", "Info");
    	} else {
			toastr.info("Data will be synchronized in background.<br />An alert will be shown whenever this process is done.", "Info");
    	}
	}
	if( synchronize == undefined ) {
		localStorage.setItem("synchronize", true);
		$.ajax({
			url : "{{ URL.'/admin/synchronize' }}",
			success: function(){
				callBack();
			}
		});
	} else {
		callBack(true);
	}
}
</script>
@append