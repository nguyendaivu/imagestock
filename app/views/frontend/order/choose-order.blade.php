@foreach($arrProduct as $key => $product)

    <div id="div-choose-order-{{ $product['sku'] }}" style="display:none">
    	
        @if(!empty($product['size_lists']) || $product['custom_size'])
        <div class="form-group">        	
            <label for="img_sizing_{{ $product['sku'] }}" class="control-label">Size</label>    
            <select class="form-control" name="img_sizing" id="img_sizing_{{ $product['sku'] }}" onchange="changeSize(this.value, '{{ $product['sku'] }}')"> 
                @if( isset($product['size_lists']) && !empty($product['size_lists']) )
                    @foreach($product['size_lists'] as $sizeList)
                    <option value="{{ $sizeList['sizew'] }}|{{ $sizeList['sizeh'] }}" {{ $sizeList['default'] ? 'selected' : '' }}  >{{ $sizeList['sizew'] }} x {{ $sizeList['sizeh'] }}</option>
                    @endforeach
                @endif
                @if( $product['custom_size'] )
                <option value="">Custom...</option>
                @endif                
            </select>
            <input type="hidden" id="default-sizew-{{ $product['sku'] }}" value="{{ isset($product['size_lists'][0]) ? $product['size_lists'][0]['sizew'] : 0 }}" />
            <input type="hidden" id="default-sizeh-{{ $product['sku'] }}" value="{{ isset($product['size_lists'][0]) ? $product['size_lists'][0]['sizeh'] : 0 }}" />
            <div id="div-custom-sizing-{{ $product['sku'] }}" style="display:none;">
                <div style="display:inline-block">
                    <label for="img_width_{{ $product['sku'] }}" class="control-label">Width</label>
                    <input type="number" name="img_width" id="img_width_{{ $product['sku'] }}" class="form-control" min="1" style="width:70px" onblur="caculatePrice()" />            
                </div>
                <div style="display:inline-block">
                    <label for="img_height_{{ $product['sku'] }}" class="control-label">Height</label>
                    <input type="number" name="img_height" id="img_height_{{ $product['sku'] }}" class="form-control" min="1" style="width:70px" onblur="caculatePrice()" />            
                </div>
            </div>
        </div>
        @endif
        
        @foreach($product['option_groups'] as $group)
        <div class="form-group" style="text-align:left;">
            <label for="option_{{ $product['sku'] }}_{{ $group['key'] }}">{{ $group['name'] }}</label>
            <select name="option_{{ $group['key'] }}" id="option_{{ $product['sku'] }}_{{ $group['key'] }}" class="form-control" onchange="changeOption(this, '{{ $group['key'] }}', '{{ $product['sku'] }}')">
                @foreach($product['options'] as $option)
                    @if( $option['option_group_id'] == $group['id'] )
                    <option value="{{ $option['key'] }}" data-description="{{ $option['id'] }}">{{ $option['name'] }}</option>
                    @endif
                @endforeach
            </select>
            <input type="hidden" id="default-{{ $group['key'] }}-{{ $product['sku'] }}" value="{{ isset($product['options'][0]) ? $product['options'][0]['name'] : '' }}" />
        </div>
        @endforeach
        
    </div>

@endforeach

