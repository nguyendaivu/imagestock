@section('pageCSS')
@stop
@if (Session::has('payment_message'))
	<div class="alert alert-warning">{{ Session::get('payment_message') }}</div>
@endif

<!-- MAIN CONTAINER-->
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			
			<div class="panel-group" id="accordion">
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion">
                       STEP 1: CHECKOUT OPTIONS
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse">
                   <div class="panel-body">
                          <div class="row">
                          @if(!Auth::user()->check())
							@include('frontend.account.create-signin')                            
                          @else
                          	<span>You are logged in as {{ Auth::user()->get()->first_name }} </span>
                          @endif
                          </div>
                          <div class="row"><button type="button" id="skip-login-btn" class="btn btn-link">Skip this step</button></div>
                   </div>
                </div>
              </div>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion">
                      STEP 2: ACCOUNT &amp; BILLING DETAILS
                    </a>
                  </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                   <div class="panel-body">
                          <div class="row">
                            <div class="col-12 col-lg-12">
                                <!-- FORM -->
                                    <form name="billing-form" action="/payment/add-address" method="post">
                                    	<input type="hidden" name="address_type" id="address_type" value="billing" />
                                      <fieldset>
                                        <legend>Enter your billing details</legend>
                                        <div class="form-group">
                                          <label for="FirstName">First Name</label>
                                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="{{ isset($billing_address['first_name']) ? $billing_address['first_name'] : '' }}" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="LastName">Last Name</label>
                                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="{{ isset($billing_address['last_name']) ? $billing_address['last_name'] : '' }}" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="Company">Company</label>
                                          <input type="text" class="form-control" name="organization" id="organization" placeholder="Enter Company" value="{{ isset($billing_address['organization']) ? $billing_address['organization'] : '' }}">
                                        </div>
                                        <div class="form-group">
                                          <label for="Adress1">Adress 1</label>
                                          <input type="text" class="form-control" name="street" id="street" placeholder="Enter Adress 1" value="{{ isset($billing_address['street']) ? $billing_address['street'] : '' }}"  required >
                                        </div>	
                                        
                                        <div class="form-group">
                                          <label for="Adress2">Adress 2</label>
                                          <input type="text" class="form-control" name="street_extra" id="street_extra" placeholder="Enter Adress 2" value="{{ isset($billing_address['street_extra']) ? $billing_address['street_extra'] : '' }}">
                                        </div>
                                        <div class="form-group">
                                          <label for="City">City</label>
                                          <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" value="{{ isset($billing_address['city']) ? $billing_address['city'] : '' }}"  required >
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="PostCode">Post Code</label>
                                          <input type="text" class="form-control" name="post_code" id="post_code" placeholder="Enter Post Code" value="{{ isset($billing_address['post_code']) ? $billing_address['post_code'] : '' }}" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="CountrySelect">Country</label>
                                          <select class="form-control" name="country_a2" id="country_a2" onchange="getStates(this.value, 'div-load-billing-states')"  required >
                                            <option value=""> - Select Country - </option>
                                            
                                            <?php $country_a2 = isset($billing_address['country_a2']) ? $billing_address['country_a2'] : ''; ?>
                                            @foreach($countries as $value)
                                            @if($country_a2 == $value->a2)
                                                <option value="{{ $value->a2 }}" selected="selected">{{ $value['name'] }}</option>
                                            @else
                                                <option value="{{ $value->a2 }}">{{ $value->name }}</option>
                                            @endif
                                            @endforeach
                                          </select>
                                        </div>							
                                        <div class="form-group" id="div-load-billing-states">
                                            <label for="RegionSelect">Region/State</label>
                                            <select class="form-control" name="state_a2" id="state_a2" >
                                                <option value=""> - Select Region/State - </option>
                                                @if($country_a2 != '')
													<?php $state_a2 = isset($billing_address['state_a2']) ? $billing_address['state_a2'] : ''; ?>
                                                    @foreach($billing_states as $value)
                                                    @if($state_a2 == $value->a2)
                                                        <option value="{{ $value->a2 }}" selected="selected">{{ $value['name'] }}</option>
                                                    @else
                                                        <option value="{{ $value->a2 }}">{{ $value->name }}</option>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info">Continue</button>
                                      </fieldset>
                                    </form>
                                <!-- /FORM -->
                            </div>
                          </div>
                        </div>
                </div>
              </div>
  
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion">
                      STEP 3: SHIPPING DETAILS
                    </a>
                  </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                   <div class="panel-body">
                          <div class="row">
                            <div class="col-12 col-lg-12">
                                <!-- FORM -->
                                    <form name="shipping-form" action="/payment/add-address" method="post">
                                    	<input type="hidden" name="address_type" id="address_type" value="shipping" />
                                      <fieldset>
                                        <legend>Enter your shipping details</legend>
                                        <div class="form-group">
                                          <label for="FirstName">First Name</label>
                                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter First Name" value="{{ isset($shipping_address['first_name']) ? $shipping_address['first_name'] : '' }}" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="LastName">Last Name</label>
                                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter Last Name" value="{{ isset($shipping_address['last_name']) ? $shipping_address['last_name'] : '' }}" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="Company">Company</label>
                                          <input type="text" class="form-control" name="organization" id="organization" placeholder="Enter Company" value="{{ isset($shipping_address['organization']) ? $shipping_address['organization'] : '' }}">
                                        </div>
                                        <div class="form-group">
                                          <label for="Adress1">Adress 1</label>
                                          <input type="text" class="form-control" name="street" id="street" placeholder="Enter Adress 1" value="{{ isset($shipping_address['street']) ? $shipping_address['street'] : '' }}"  required >
                                        </div>	
                                        
                                        <div class="form-group">
                                          <label for="Adress2">Adress 2</label>
                                          <input type="text" class="form-control" name="street_extra" id="street_extra" placeholder="Enter Adress 2" value="{{ isset($shipping_address['street_extra']) ? $shipping_address['street_extra'] : '' }}">
                                        </div>
                                        <div class="form-group">
                                          <label for="City">City</label>
                                          <input type="text" class="form-control" name="city" id="city" placeholder="Enter City" value="{{ isset($shipping_address['city']) ? $shipping_address['city'] : '' }}"  required >
                                        </div>
                                        
                                        <div class="form-group">
                                          <label for="PostCode">Post Code</label>
                                          <input type="text" class="form-control" name="post_code" id="post_code" placeholder="Enter Post Code" value="{{ isset($shipping_address['post_code']) ? $shipping_address['post_code'] : '' }}" required maxlength="10" >
                                        </div>
                                        <div class="form-group">
                                          <label for="CountrySelect">Country</label>
                                          <select class="form-control" name="country_a2" id="country_a2" onchange="getStates(this.value, 'div-load-shipping-states')"  required >
                                            <option value=""> - Select Country - </option>
                                            
                                            <?php $country_a2 = isset($shipping_address['country_a2']) ? $shipping_address['country_a2'] : ''; ?>
                                            @foreach($countries as $value)
                                            @if($country_a2 == $value->a2)
                                                <option value="{{ $value->a2 }}" selected="selected">{{ $value['name'] }}</option>
                                            @else
                                                <option value="{{ $value->a2 }}">{{ $value->name }}</option>
                                            @endif
                                            @endforeach
                                          </select>
                                        </div>							
                                        <div class="form-group" id="div-load-shipping-states">
                                            <label for="RegionSelect">Region/State</label>
                                            <select class="form-control" name="state_a2" id="state_a2" >
                                                <option value=""> - Select Region/State - </option>
                                                @if($country_a2 != '')
													<?php $state_a2 = isset($shipping_address['state_a2']) ? $shipping_address['state_a2'] : ''; ?>
                                                    @foreach($shipping_states as $value)
                                                    @if($state_a2 == $value->a2)
                                                        <option value="{{ $value->a2 }}" selected="selected">{{ $value['name'] }}</option>
                                                    @else
                                                        <option value="{{ $value->a2 }}">{{ $value->name }}</option>
                                                    @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-info">Continue</button>
                                      </fieldset>
                                    </form>
                                <!-- /FORM -->
                            </div>
                          </div>
                        </div>
                </div>
              </div> 
  
<!--              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                      STEP 4: SHIPPING METHOD
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="panel-body">
                          <div class="row">
                            <div class="col-12 col-lg-12">
                            <form>
                                <fieldset>
                                        <legend>CHOOSE SHIPPING METHOD</legend>
                                <div class="radio">
                                      <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
                                        Free Shipping 
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Flat Shipping Rate
                                      </label>
                                    </div>
                                    <button type="submit" class="btn btn-info">Continue</button>
                                </fieldset>
                            </form>
                            </div>
                          </div>
                        </div>
                </div>
              </div> -->
  
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion">
                       STEP 4: PAYMENT METHOD
                    </a>
                  </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                   <div class="panel-body">
                          <div class="row">
                            <div class="col-12 col-lg-12">

                                <fieldset>
                                        <legend>CHOOSE PAYMENT METHOD</legend>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="options_payment_method" value="credit-card" checked="">
                                        Credit Card 
                                      </label>
                                    </div>
                                    <div class="radio">
                                      <label>
                                        <input type="radio" name="options_payment_method" value="cash">
                                        Cash on Delivery
                                      </label>
                                    </div>
                                    <button type="button" id="payment-method-btn" class="btn btn-info">Continue</button>
                                </fieldset>

                          </div>
                        </div>
                      </div>
                </div>
              </div> 
  
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion">
                      STEP 5: CONFIRM ORDER
                    </a>
                  </h4>
                </div>
                <div id="collapseFive" class="panel-collapse collapse" style="text-align:right">
					@include('frontend.order.cart')
                    <div id="div-pay-with-card">
                        <form action="/payment/checkout-with-card" method="post">
                            <input type="hidden" name="description" value="{{ $description }}" />
                            
                            <script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
                              data-key="{{ $publishable_key }}"
                              data-amount="{{ $cart_total * 100 }}" data-description="{{ $description }}"></script>
                        </form>                                                    
                    </div>
                    <div id="div-confirm-order-btn" style="display:none;">
                        <form action="/payment/confirm" method="post">
                            <input type="hidden" name="description" value="{{ $description }}" />                                                                                    
                            <button id="confirm-checkout-btn" type="submit" class="btn btn-success">Confirm Order</button>                            
                        </form>                                                    
                    </div>
                                
                </div>
              </div>
            </div>
            <a href="/">
             <button type="button" class="btn btn-primary pull-right"><i class="icon-ok-sign"></i> Continue shopping</button>
             </a>
		
		</div>
	</div>
</div> <!-- /container -->

@section('pageJS')
<script type="text/javascript">
function getStates(country_a2, div_load)
{
	$.get("/payment/get-states/"+country_a2,
	{},
	function(data, status){
		if(data['result'] == 'ok')
		{
			$('#'+div_load).html(data['html']);
		}
	});			
}
$(document).ready(function() {
	
	@if($step == 'shipping')
		//$('#collapseTwo').collapse('hide');
		$('#collapseThree').collapse('show');
	@elseif($step == 'payment-method')
		//$('#collapseThree').collapse('hide');
		$('#collapseFour').collapse('show');
	@elseif(!Auth::user()->check())
		$('#collapseOne').collapse('show');
	@else		
		$('#collapseTwo').collapse('show');
	@endif
	
	$("#skip-login-btn").click(function(event){
		event.preventDefault();
		$('#collapseOne').collapse('hide');
		$('#collapseTwo').collapse('show');
	});
		
	$("#payment-method-btn").click(function(event){
		event.preventDefault();

		if($('input[name=options_payment_method]:checked').val() == 'cash')	
		{
			$('#div-pay-with-card').hide();
			$('#div-confirm-order-btn').show();			
		}
		else
		{
			$('#div-confirm-order-btn').hide();			
			$('#div-pay-with-card').show();			
		}
		$('#collapseFour').collapse('hide');
		$('#collapseFive').collapse('show');
	});
});
</script>
@stop