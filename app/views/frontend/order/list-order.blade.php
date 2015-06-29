@section('pageCSS')
    <link href="{{ URL::asset( 'assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css' ) }}" rel="stylesheet" type="text/css" >
	<style type="text/css">
	div.order-address{
		/*border: 1px solid;*/
		margin-top: -90px;					
	}
	</style>
@stop
@section('content')

@if (Session::has('message'))
   	<div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif

<div class="container-fluid">
	
    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">{{ Auth::user()->get()->first_name }}'s Orders
                </h1>
            </div>
        </div>
        <!-- /.row -->
		@if(count($arr_orders)>0)
            
            <!-- Row -->
            <div class="row">

                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                            @foreach($arr_orders as $key => $order)

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $key }}" class="collapsed" aria-expanded="false">Order #{{ $order['order_id'] }}</a>
                                            <span><b>({{ $order['status'] }})</b></span>
                                            <span class="pull-right"><i>{{ $order['created_at'] }}</i></span>
                                        </h4>
                                    </div>
                                    <div id="collapse{{ $key }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                                        <div class="panel-body">
                                        <?php
                                            $cart_content = $order['order_details']; 
                                        	$cart_total = $order['sum_amount'];
                                        ?>
                                            @include('frontend.order.cart')
                                            <div class="row">
                                            <div class="col-sm-4 left_column order-address small">
                                            	<h6><b>Billing Address</b></h6>
                                                <i>{{ $order['billing_address'] }}</i>
                                            </div>
                                            <div class="col-sm-4 right_column order-address small">
                                            	<h6><b>Shipping Address</b></h6>
                                            	<i>{{ $order['shipping_address'] }}</i>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							@endforeach
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>

            </div>
            <!-- /.row -->
            
            @if($total_order>0 && $total_page>1)    
            <hr>	
            <!-- Pagination -->
            <div class="row">
                <div class="col-lg-12">
                    <ul class="pagination">
                        
                        <li>
                            @if($current > 1)
                            <a href="/order?page={{ $current-1 }}" aria-label="Previous" data-value='prev'>
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                            @endif
                        </li>
                        @for( $i = $from; $i<= $to; $i++)
                            @if($i == $current)
                            <li class="active"><a href="/order?page={{ $i }}" data-value="{{ $i }}">{{ $i }}</a></li>
                            @else
                            <li><a href="/order?page={{ $i }}" data-value="{{ $i }}">{{ $i }}</a></li>
                            @endif
                        @endfor
                        @if($current < $total_page)
                        <li>
                            <a href="/order?page={{ $current+1 }}" aria-label="Next" data-value="next">
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
                There are no items in your order.
            </div>
		@endif
    </div>
    <!-- /.container -->
</div>

@stop

@section('pageJS')
  <script>
  
  </script>
@stop
