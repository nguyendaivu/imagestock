
	
		<div class="panel-body">
			<div class="row">
            @if($cart_total > 0)
				<div class="col-12 col-lg-12" style="text-align:left">
						<table class="table table-striped">
							<thead>
							  <tr>
								<th>Item</th>
                                <th>Item Detail</th>
								<th>Qty</th>
								<th>Price</th>
								<th>Total</th>
							  </tr>
							</thead>
							<tbody>
                            @foreach($cart_content as $row)
							  <tr>
                              	<td>
                                	@if(Route::currentRouteName() == 'order-cart')
                                	<a href="/cart/remove/{{ $row->id }}" class="glyphicon glyphicon-remove-circle"></a>
                                    @endif
                                    <a href="{{URL}}/pic-{{$row->viimage->id}}/{{$row->viimage->short_name}}.html">
                                		<img src="{{URL}}{{ $row->options->path_thumb }}" style="width:100px;"/>
                                    </a>
                                </td>
								<td><h4>{{ $row->name }}</h4>
                                	<small>{{ Str::words($row->viimage->description, 25, '...') }}</small>
                                    @if($row->options->order_type != '')
                                		<div><small><b>Type: {{ $row->options->order_type }}</b></small></div>
                                    @endif
                                    @if($row->options->size != '')
                                    	<div><small>Size: {{ $row->options->size }}</small></div>
                                    @endif
                                    @foreach($row->options->options as $option)
                                    <div><small>{{ $option['type'] }}: {{ $option['value'] }}</small></div>
                                    @endforeach

                                </td>
								<td>
                                	@if(Route::currentRouteName() == 'order-cart')
                                	<input type="number" id="qty_{{ $row->rowid }}" value="{{ $row->qty }}" class="form-control" style="width:75px" onblur="updateQty('{{ $row->rowid }}', this.value, event)" min="1" />
                                    <span id="loading_{{ $row->rowid }}"></span>
                                    <input type="hidden" id="qty_old_{{ $row->rowid }}" value="{{ $row->qty }}" />
                                    @else
                                    	{{ $row->qty }}
                                    @endif
                                </td>
								<td><span id="price_{{ $row->rowid }}">{{ number_format($row->price, 2) }}</span></td>
								<td><span id="subtotal_{{ $row->rowid }}">{{ number_format($row->subtotal, 2) }}</span></td>
							  </tr>
                            @endforeach
							</tbody>
					  </table>
					  <hr>
						<dl class="dl-horizontal pull-right">
						  <dt>Sub-total:</dt>
						  <dd>$<span id="subtotal">{{ number_format($cart_total, 2) }}</span></dd>
						  <dt>Shipping Cost:</dt>
						  <dd>$0.00</dd> 
						  <dt>Total:</dt>
						  <dd>$<span id="total">{{ number_format($cart_total, 2) }}</span></dd>
						</dl>
						<div class="clearfix"></div>						
				</div>
            @else
            	Your cart is empty, please continue shopping.
            @endif
			</div>
		</div>