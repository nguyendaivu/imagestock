@if(!empty($arrProduct))
    <form id="order-form" method="post" action="/cart/add" class="form-horizontal">
    <input type="hidden" name="order-image-id" value="{{ $arrImage['image_id'] }}" />
    <input type="hidden" name="order-image-name" value="{{ $arrImage['name'] }}" />
    <input type="hidden" name="path_thumb" value="{{ $arrImage['path_thumb'] }}" />
    <div style="display:inline-block; width:95%; text-align:left">
    	@for($i=0; $i<count($arrProduct); $i++)
        	@if($i == 0)
                <div class="col-md-4 customize-control-radio-image">
                	<div class="product-title">
                    	<a data-toggle="modal" data-target="#modal-{{ $arrProduct[2]['sku'] }}">{{ $arrProduct[2]['name'] }}</a>
                    </div>
                    <input id="radio_framed_print" type="radio" name="order_type" value="{{ $arrProduct[2]['short_name'] }}_{{ $arrProduct[2]['sku'] }}" checked onclick="setOrderType(this.value, 'framed')">
                    <label for="radio_framed_print">                
                        <img src="{{URL}}/assets/images/others/product-FP.jpg">
                    </label>
                </div>
            @elseif($i == 1)
                <div class="col-md-4 customize-control-radio-image">
                	<div class="product-title">
                    	<a data-toggle="modal" data-target="#modal-{{ $arrProduct[1]['sku'] }}">{{ $arrProduct[1]['name'] }}</a>
                    </div>
                    <input id="radio_art_print" type="radio" name="order_type" value="{{ $arrProduct[1]['short_name'] }}_{{ $arrProduct[1]['sku'] }}" onclick="setOrderType(this.value, 'photo')">
                    <label for="radio_art_print">                
                        <img src="{{URL}}/assets/images/others/product-PO.jpg">    
                    </label>
                </div>                 
            @elseif($i == 2)                        
                <div class="col-md-4 customize-control-radio-image " >
                	<div class="product-title">
                    	<a data-toggle="modal" data-target="#modal-{{ $arrProduct[0]['sku'] }}">{{ $arrProduct[0]['name'] }}</a>
                    </div>
                    <input id="radio_canvas" type="radio" name="order_type" value="{{ $arrProduct[0]['short_name'] }}_{{ $arrProduct[0]['sku'] }}" onclick="setOrderType(this.value, 'canvas')">
                    <label for="radio_canvas">                
                        <img src="{{URL}}/assets/images/others/product-S.jpg">    
                    </label>        
                </div>
            @endif
        @endfor
    </div>
    
    <!--<div class="row" style="height:40px; padding-top:10px;">
        <a href="#modal-products" id="btnModal">See product examples</a>
    </div>
    -->
    <div class="row" style="padding-left:40px; padding-right:60px; text-align:left">
        <div id="div-choose-order">
            <!--load choose order here-->
        </div>
    
        <div class="form-group" style="width:100px;">
        	<div style="display:inline;">
                <label for="order_qty" class="control-label">Quantity</label>            
                <input type="number" name="order_qty" id="order_qty" value="1" min="1" class="form-control" onblur="changeQuantity(this.value)" />
			</div>
            <div class="display-price">
            	<h3>$<span id="display_price" class="number"></span></h3>
            </div>
        </div>
        <input type="hidden" name="old_qty" id="old_qty" value="1" />
        <input type="hidden" name="price" id="price" value="0" />
        <input type="hidden" name="sell_price" id="sell_price" value="0" />

        <div class="form-group">
            <div style="width:150px; display:inline-block">
                <a href="/cart" style="text-decoration:none">
                <button id="add-to-card-btn" type="button" class="btn btn-success btn-block">Add to cart</button>
                </a>
            </div>
            <p><small><a data-toggle="modal" data-target="#guarantee-modal" style="cursor:pointer">100% money back guarantee</a></small></p>
        </div>
    </div>
    </form>
    @include('frontend.order._modals')
    @include('frontend.order.choose-order')
@endif
