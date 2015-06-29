@section('pageCSS')
@stop
@if (Session::has('message'))
	<div class="alert alert-warning">{{ Session::get('message') }}</div>
@endif
@if (Session::has('payment_message'))
	<div class="alert alert-warning">{{ Session::get('payment_message') }}</div>
@endif

@section('content')
<!-- MAIN CONTAINER-->
<div class="container">
<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Shoping Cart</h3>
	</div>

		@include('frontend.order.cart')

		<div class="panel-footer">
			<div class="row">
				<div class="col-lg-12" style="text-align:right;">
                @if($cart_total > 0)
                	<a href="/payment"><button type="submit" class="btn btn-success"><i class="icon-ok-sign"></i> Proceed to checkout</button></a>
                @endif
                	<a href="/"><button type="button" class="btn btn-primary"><i class="icon-ok-sign"></i> Continue shopping</button></a>

				</div>
			</div>
		</div>
	</div>
</div> <!-- /container -->
@stop
@section('pageJS')
<script type="text/javascript">

function updateQty(row_id, qty, event)
{
	event.preventDefault();
	//alert(row_id);
	//var x = event.keyCode;
    //if (x == 13) {}  // 13 is the Enter key
	var old_qty = $('#qty_old_'+row_id).val();
	if(qty > 0 && qty != old_qty)
	{
		$('#loading_'+row_id).html('<img src="{{URL}}/assets/images/others/ajax-loader.gif" width="20px">');
		$.post("/cart/update-qty",
		{
			row_id: row_id,
			qty: qty
		},
		function(data, status){
			$('#loading_'+row_id).html('');
			if(data['result'] == 'ok')
			{
				var obj_row = data['data']['cart_row'];
				$('#price_'+row_id).number(obj_row.price, 2);
				$('#subtotal_'+row_id).number(obj_row.subtotal, 2);
				$('#subtotal').number(data['data']['cart_total'], 2);
				$('#total').number(data['data']['cart_total'], 2);
				//set old qty
				$('#qty_old_'+row_id).val(qty);			
			}
		});		
	}
}

$(document).ready(function() {
	
});
</script>
@stop