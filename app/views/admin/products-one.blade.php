<div id="product-other-options-div" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="overflow-y: auto !important;">
            <div class="modal-body">
                <table class="table table-striped table-hover table-bordered" id="list-product-other-options">
                    <thead>
                        <tr role="row" class="heading">
                        	<th>#</th>
                        	<th>Id</th>
                            <th>Code</th>
                            <th>SKU</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Category</th>
                            <th>OUM</th>
                            <th>Sold by</th>
                            <th>Sell price</th>
                            <th class="text-center" width="3%">
                                 {{'Tools'}}
                            </th>
                        </tr>
                        <tr role="row" class="filter">
                        	<td></td>
                        	<td></td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[code]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[sku]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[name]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[product_type]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[product_category]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[oum]">
                            </td>
                            <td>
                                <input type="text" class="form-control form-filter input-sm" name="search[sell_by]">
                            </td>
                            <td></td>
                            <td class="text-center">
                                <button id="search-button" class="btn btn-sm yellow filter-submit margin-bottom"><i class="fa fa-search"></i>{{ 'Search' }}</button>
                                <button id="cancel-button" class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i>{{ 'Reset' }}</button>
                            </td>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="row">
	<div class="col-md-12">
		{{ Form::open([
				'id'		=> 'product-form',
				'class' 	=> 'form-horizontal form-row-seperated',
				'method' 	=> 'POST',
				'url'		=> URL.'/admin/products/update-product',
				'files'		=> true
			]) }}
			@if( isset($product['id']) )
			<input type="hidden" name="id" value="{{ $product['id'] }}" />
			@endif
			<div class="portlet">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-shopping-cart"></i>Product
					</div>
					<div class="actions btn-set">
						<a class="btn default" href="{{ URL.'/admin/products' }}"><i class="fa fa-angle-left"></i> Back</a>
						<button type="reset" class="btn default"><i class="fa fa-reply"></i> Reset</button>
						<button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
						<button type="submit" name="continue" value="continue" class="btn green"><i class="fa fa-check-circle"></i> Save & Continue Edit</button>
						@if( isset($product['id']) )
						<div class="btn-group">
							<a class="btn yellow dropdown-toggle" href="#" data-toggle="dropdown">
							<i class="fa fa-share"></i> More <i class="fa fa-angle-down"></i>
							</a>
							<ul class="dropdown-menu pull-right">
								<li>
									<a href="javascript:void(0)">
									Duplicate </a>
								</li>
								<li>
									<a href="javascript:void(0)" onclick="deleteRecord({ 'deleteUrl' : '{{ URL.'/admin/products/delete-product/'.$product['id'] }}', returnUrl : '{{ URL.'/admin/products' }}' })">
									    Delete </a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="javascript:void(0)">
									Print </a>
								</li>
							</ul>
						</div>
						@endif
					</div>
				</div>
				<div class="portlet-body">
					<div class="alert alert-danger display-hide">
					    <button class="close" data-close="alert"></button>
					    <div id="content-message">
					    	<i class="fa-lg fa fa-warning"></i>
					        You have some form errors. Please check below.
					    </div>
					</div>
					<div class="tabbable">
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#general" data-toggle="tab">
								General </a>
							</li>
							<li>
								<a href="#meta" data-toggle="tab">
								Meta </a>
							</li>
							<li>
								<a href="#description" data-toggle="tab">
								Description
								</a>
							</li>
							<li>
								<a href="#images" data-toggle="tab">
								Images </a>
							</li>
							<li>
								<a href="#price-lists" data-toggle="tab">
								Price Lists </a>
							</li>
							<li>
								<a href="#main-options" data-toggle="tab">
								Main Options </a>
							</li>
							<li>
								<a href="#other-options" data-toggle="tab">
								Other Options </a>
							</li>
							<li>
								<a href="#price-breaks" data-toggle="tab">
								Price breaks </a>
							</li>
							<li>
								<a href="#others" data-toggle="tab">
								Others </a>
							</li>
						</ul>
						<div class="tab-content no-space">
							<div class="tab-pane active" id="general">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Name<span class="required">
										* </span>
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control" name="name" value="{{ $product['name'] or '' }}" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">SKU<span class="required">
										* </span>
										</label>
										<div class="col-md-10">
											<div class="input-group" style="text-align:left">
												<input type="text" class="form-control" name="sku" value="{{ $product['sku'] or '' }}" placeholder="">
												<span class="input-group-btn">
													<a href="javascript:;" class="btn yellow" id="sku-checker">
													<i class="fa"></i> Check </a>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Categories<span class="required">
										* </span>
										</label>
										<div class="col-md-10">
											{{--
											<div class="form-control height-auto">
												<div class="scroller" style="height:275px;" data-always-visible="1">
													{{ $categories }}
												</div>
											</div>
											<span class="help-block">
											select one or more categories </span>
											--}}
											<select id="categories" class="form-control" multiple name="categories[]">
												@if( isset($arrCategories) )
												@foreach($arrCategories as $category)
												<option value="{{ $category['value'] }}" {{ in_array($category['value'], $arrChosenCategories) ? 'selected' : '' }} >{{ $category['text'] }}</option>
												@endforeach
												@endif
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Price
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control" name="sell_price" value="{{ $product['sell_price'] or '' }}" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Margin (%)
										</label>
										<div class="col-md-10">
											<input type="text" class="form-control" name="margin_up" value="{{ $product['margin_up'] or '' }}" placeholder="">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Custom Size
										</label>
										<div class="col-md-10">
											<input type="checkbox" class="form-control" name="custom_size" value="1" {{ isset($product['custom_size']) && !$product['custom_size'] ? '' : 'checked' }}>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Type
										</label>
										<div class="col-md-10">
											<?php if( !isset($product['product_type_id']) ) $product['product_type_id'] = 0; ?>
											<select class="bs-select form-control" name="product_type_id" data-width="50%">
												@foreach($types as $type)
													<option @if( $product['product_type_id'] == $type['value'] ) selected @endif  value="{{ $type['value'] }}">{{ $type['text'] }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<?php
											if( !isset($product['option_groups']) ) $product['option_groups'] = [];
											if( !isset($product['options']) ) 		$product['options'] = [];
										?>
										<label class="col-md-2 control-label">Option Group
										</label>
										<div class="col-md-10">
											<select id="option_group_id" class="form-control" multiple name="option_group_id[]">
												@foreach( $option_groups as $group )
												<option @if( in_array($group['value'], $product['option_groups']) ) selected @endif  value="{{ $group['value'] }}" >{{ $group['text'] }}</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Order no
										</label>
										<div class="col-md-10">
											<div id="order-spinner">
												<div class="input-group input-small">
													<input type="text" class="spinner-input form-control" minlength="1" value="{{$product['order_no'] or 1 }}" readonly id="order_no" name="order_no">
													<div class="spinner-buttons input-group-btn btn-group-vertical">
														<button type="button" class="btn spinner-up btn-xs red">
														<i class="fa fa-angle-up"></i>
														</button>
														<button type="button" class="btn spinner-down btn-xs red">
														<i class="fa fa-angle-down"></i>
														</button>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Active
										</label>
										<div class="col-md-10">
											<input type="checkbox" class="form-control" name="active" {{ !isset($product['active']) || $product['active'] ? 'checked' : '' }}>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="meta">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Meta Title</label>
										<div class="col-md-10">
											<input type="text" class="form-control maxlength-handler" name="meta_title" value="{{ $product['meta_title'] or '' }}" maxlength="50" placeholder="">
											<span class="help-block">
											max 50 chars </span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Meta Description</label>
										<div class="col-md-10">
											<textarea class="form-control maxlength-handler" rows="8" name="meta_description" maxlength="255">{{ $product['meta_description'] or '' }}</textarea>
											<span class="help-block">
											max 255 chars </span>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="description">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Short Description
										</label>
										<div class="col-md-10">
											<textarea class="form-control" name="short_description">{{ $product['short_description'] or '' }}</textarea>
											<span class="help-block">
											shown in product listing </span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label">Description
										</label>
										<div class="col-md-10">
											<textarea class="form-control" id="description-content" name="description">{{ $product['description'] or '' }}</textarea>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="images">
								<div class="text-align-reverse margin-bottom-10">
			                        <a href="javascript:;" class="btn green" onclick="addImage()">
			                        <i class="fa fa-plus"></i> Add New Image </a>
			                    </div>
								<table class="table table-striped table-bordered table-hover" id="images-table">
								<thead>
		                            <tr role="row" class="heading">
		                                <th width="5%">
		                                    #
		                                </th>
		                                <th width="25%">
		                                    Image
		                                </th>
		                                <th>
		                                    With Options
		                                </th>
		                                <th class="text-center" width="10%">
		                                    Main Image
		                                </th>
		                                <th class="text-center" width="10%">
		                                    Tool
		                                </th>
		                            </tr>
		                        </thead>
								<tbody>
									<?php
										$arrView = [];
									?>
		                            @if( !isset($product['images']) || empty($product['images']) )
		                                <tr class="empty"><td class="text-center" colspan="5">No data available in table</td></tr>
		                            @else
		                            <?php $i = 0; ?>
		                            @foreach($product['images'] as $image)
		                            <?php $key = $image['id'];  ?>
		                            <tr role="row" class="{{ $i%2 == 0 ? 'even' : 'odd' }}" data-id="{{ $key }}">
		                                <td>
		                                    {{ ++$i }}
		                                </td>
		                                <td data-id="{{ $key }}">
		                                    <input type="hidden" class="image-id" name="images[{{ $key }}][id]" value="{{ $key }}" />
		                                    <input type="hidden" class="delete" name="images[{{ $key }}][delete]" value="0" />
		                                    <div class="fileinput fileinput-new" data-provides="fileinput">
		                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
		                                            <?php
		                                            	$image['path'] = '';//str_replace('assets/images/products/', 'assets/images/products/thumbs/', $image['path']);
		                                                $file = $image['path'];
		                                                $file = str_replace('/', DS, $file);
		                                            ?>
		                                            @if(File::exists(public_path().DS.$file))
		                                            <img data-origin-src="{{ URL::asset( $image['path'] ) }}" src="{{ URL::asset( $image['path'] ) }}" style="width: 200px; height: 150px;">
		                                            @else
		                                            <img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" alt=""/>
		                                            @endif
		                                        </div>
		                                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;">
		                                        </div>
		                                        <div>
		                                            <span class="btn default btn-file">
			                                            <span class="fileinput-new">
			                                            	Select image
			                                        	</span>
			                                            <span class="fileinput-exists">
			                                            	Change
			                                        	</span>
			                                            <input name="images[{{ $key }}][file]" id="file" type="file">
		                                            </span>
		                                        	<a href="javascript:void(0)" class="btn green fileinput-new" onclick="openImage(this)">Choose</a>
		                                            <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
		                                            Remove </a>
		                                        </div>
		                                    </div>
		                                </td>
		                                <td>
		                                	<?php
		                                		$main = false;
		                                		$imageView = [];
		                                		if( !empty($image['pivot']['option']) ) {
		                                			$image['pivot']['option'] = json_decode($image['pivot']['option'], true);
		                                			if( $image['pivot']['option']['main'] ) {
		                                				$main = true;
		                                			}
		                                			if( isset($image['pivot']['option']['view']) ) {
		                                				$imageView = $image['pivot']['option']['view'];
		                                			}
		                                		}
		                                		$arrView[$key] = $imageView;
		                                	?>
		                                	<table class="image-view-table" style="width: 100%">
		                                	<tbody>
		                                		@foreach( $option_groups as $group )
		                                		@if( in_array($group['value'], $product['option_groups']) )
		                                		<tr data-option-group-id="{{ $group['value'] }}">
		                                			<td>{{ $group['text']  }}</td>
		                                			<td>
		                                				<select class="form-control" name="images[{{ $key }}][view][]">
		                                					<option value="0" ></option>
		                                					@foreach($group['options'] as $opt)
		                                					@if( in_array($opt['value'], $product['options']) )
		                                					<option value="{{ $opt['value'] }}" {{ in_array($opt['value'], $imageView) ? 'selected' : '' }}>{{ $opt['text'] }}</option>
		                                					@endif
		                                					@endforeach
		                                				</select>
		                                			</td>
		                                		</tr>
		                                		@endif
		                                		@endforeach
		                                	</tbody>
		                                	</table>
		                                </td>
		                                <td class="text-center">
		                                    <input type="checkbox" name="images[{{ $key }}][main]" {{ $main ? 'checked' : '' }} />
		                                </td>
		                                <td class="text-center">
		                                    <a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>
		                                </td>
		                            </tr>
		                            @endforeach
		                            @endif
		                        </tbody>
								</table>
							</div>
							<div class="tab-pane" id="price-lists">
								<div class="text-align-reverse margin-bottom-10">
			                        <a href="javascript:;" class="btn green" onclick="addPriceList()">
			                        <i class="fa fa-plus"></i> Add New Price List </a>
			                    </div>
								<table class="table table-bordered table-striped table-hover" id="price-list-table">
								<thead>
		                            <tr role="row" class="heading">
		                                <th width="5%">
		                                    #
		                                </th>
		                                <th class="text-right">
		                                    Size W
		                                </th>
		                                <th class="text-right">
		                                    Size H
		                                </th>
		                                <th class="text-right">
		                                    Cost Price
		                                </th>
		                                <th class="text-right">
		                                    Sell Price
		                                </th>
		                                <th class="text-right">
		                                    Sell Percent
		                                </th>
		                                <th class="text-right">
		                                    Bigger Price
		                                </th>
		                                <th class="text-right">
		                                    Bigger Percent
		                                </th>
		                                <th class="text-center">
		                                    Default
		                                </th>
		                                <th class="text-center" width="10%">
		                                    Tool
		                                </th>
		                            </tr>
		                        </thead>
		                        <tbody>
		                        	@if( !isset($product['size_lists']) || empty($product['size_lists']) )
		                        	@if( !isset($product['id']) )
		                            <tr class="even" data-id="0">
                                        <td>1</td>
                                        <td>
                                        	<input class="text-right form-control sizew" type="text" name="price_lists[0][sizew]" value="12" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control sizeh" type="text" name="price_lists[0][sizeh]" value="12" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control cost-price" readonly type="text" name="price_lists[0][cost_price]" value="0" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control sell-price" type="text" name="price_lists[0][sell_price]" value="0" />
                                        </td>
                                        <td>
                                        	<div class="input-group" style="text-align:left">
                                        		<input class="text-right form-control sell-percent" style="width: 60%" type="text" name="price_lists[0][sell_percent]" value="0" />
                                        		<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Sell Price = Cost Price * Sell Percent">
                                        		<i class="fa"></i> % </a>
                                        	</div>
                                        </td>
                                        <td>
                                        	<input class="text-right form-control bigger-price" type="text" name="price_lists[0][bigger_price]" value="0" />
                                        </td>
                                        <td>
                        	                <div class="input-group" style="text-align:left">
                        	                	<input class="text-right form-control bigger-percent" style="width: 60%" type="text" name="price_lists[0][bigger_percent]" value="100" />
                        	                	<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Bigger Price = Sell Price * Bigger Percent">
                        	                	<i class="fa"></i> % </a>
                        	                </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="default" name="price_lists[0][default]" value="0" checked />
                                        </td>
                                        <td  class="text-center">
                                            <a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>
                                        </td>
                                    </tr>
		                        	@else
		                            <tr class="empty"><td class="text-center" colspan="10">No data available in table</td></tr>
		                            @endif
		                            @else
		                            <?php $i = 0; ?>
		                            @foreach($product['size_lists'] as $size_list)
		                            <?php $key = $size_list['id'];  ?>
		                            <tr class="{{ $i%2 == 0 ? 'even' : 'odd' }}" data-id="{{ $key }}">
                                        <td>{{ ++$i }}</td>
                                        <td>
                                        	<input type="hidden" class="delete" name="price_lists[{{ $key }}][delete]" value="0" />
                                        	<input type="hidden" name="price_lists[{{ $key }}][id]" value="{{ $key }}" />
                                        	<input class="text-right form-control sizew" type="text" name="price_lists[{{ $key }}][sizew]" value="{{ number_format($size_list['sizew'], 2) }}" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control sizeh" type="text" name="price_lists[{{ $key }}][sizeh]" value="{{ number_format($size_list['sizeh'], 2) }}" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control cost-price" readonly type="text" name="price_lists[{{ $key }}][cost_price]" value="{{ number_format($size_list['cost_price'], 2) }}" />
                                        </td>
                                        <td>
                                        	<input class="text-right form-control sell-price" type="text" name="price_lists[{{ $key }}][sell_price]" value="{{ number_format($size_list['sell_price'], 2) }}" />
                                        </td>
                                        <td>
                                        	<div class="input-group" style="text-align:left">
                                        		<input class="text-right form-control sell-percent" style="width: 60%" type="text" name="price_lists[{{ $key }}][sell_percent]" value="{{ number_format($size_list['sell_percent'], 2) }}" />
                                        		<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Sell Price = Cost Price * Sell Percent">
                                        		<i class="fa"></i> % </a>
                                        	</div>
                                        </td>
                                        <td>
                                        	<input class="text-right form-control bigger-price" type="text" name="price_lists[{{ $key }}][bigger_price]" value="{{ number_format($size_list['bigger_price'], 2) }}" />
                                        </td>
                                        <td>
                        	                <div class="input-group" style="text-align:left">
                        	                	<input class="text-right form-control bigger-percent" style="width: 60%" type="text" name="price_lists[{{ $key }}][bigger_percent]" value="{{ number_format($size_list['bigger_percent'], 2) }}" />
                        	                	<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Bigger Price = Sell Price * Bigger Percent">
                        	                	<i class="fa"></i> % </a>
                        	                </div>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" class="default" name="price_lists[{{ $key }}][default]" value="{{ $key }}" {{ $size_list['default'] ? 'checked' : '' }} />
                                        </td>
                                        <td  class="text-center">
                                            <a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>
                                        </td>
                                    </tr>
		                            @endforeach
		                            @endif
		                        </tbody>
		                    	</table>
							</div>
							<div class="tab-pane" id="other-options">
								<div class="text-align-reverse margin-bottom-10">
			                        <a href="#product-other-options-div" class="btn green" data-toggle="modal">
			                        <i class="fa fa-plus"></i> Add other option </a>
			                        <a href="javascript:;" class="btn red" onclick="deleteOtherOptions()">
			                        <i class="fa fa-remove"></i> Delete selected option </a>
			                    </div>
								<table class="table table-striped table-bordered table-hover dataTable" id="other-options-table">
								<thead>
		                            <tr role="row" class="heading">
		                                <th width="2%">
		                                	<input type="checkbox" id="check-all-options" />
		                                </th>
		                                <th>
		                                    Code
		                                </th>
		                                <th>
		                                    Req
		                                </th>
		                                <th>
		                                    S.P.
		                                </th>
		                                <th>
		                                    Unit cost
		                                </th>
		                                <th>
		                                    %Discount
		                                </th>
		                                <th>
		                                    Quantity
		                                </th>
		                                <th>
		                                    Sub total
		                                </th>
		                                <th width="2%">
		                                    Hidden
		                                </th>
		                                <th class="text-center" width="3%">
		                                </th>
		                            </tr>
		                        </thead>
								<tbody class="main">
									@if( !isset($product['size_lists']) || empty($product['size_lists']) )
		                            <tr class="empty"><td class="text-center" colspan="10">No data available in table</td></tr>
		                            @endif
								</tbody>
								</table>
							</div>
							<div class="tab-pane" id="main-options">
								<div class="form-body">
									<div id="options-content">
									</div>
								</div>
							</div>
							<div class="tab-pane" id="price-breaks">
								<div class="text-align-reverse margin-bottom-10">
			                        <a href="javascript:;" class="btn green" onclick="addPriceBreak()">
			                        <i class="fa fa-plus"></i> Add New Price Break </a>
			                    </div>
								<table class="table table-striped table-bordered table-hover" id="price-break-table">
								<thead>
		                            <tr role="row" class="heading">
		                                <th width="5%">
		                                    #
		                                </th>
		                                <th class="text-right">
		                                    Range From
		                                </th>
		                                <th class="text-right">
		                                    Range To
		                                </th>
		                                <th class="text-right">
		                                    Sell Price
		                                </th>
		                                <th class="text-center" width="10%">
		                                    Tool
		                                </th>
		                            </tr>
		                        </thead>
								<tbody>
		                            @if( !isset($product['price_breaks']) || empty($product['price_breaks']) )
		                                <tr class="empty"><td class="text-center" colspan="5">No data available in table</td></tr>
		                            @else
		                            <?php $i = 0; ?>
		                            @foreach($product['price_breaks'] as $price_break)
		                            <?php $key = $price_break['id'];  ?>
		                            <tr class="{{ $i%2 == 0 ? 'even' : 'odd' }}" data-id="{{ $key }}">
		                                <td>
		                                    {{ ++$i }}
		                                </td>
		                                <td class="text-right">
		                                	<input type="hidden" class="delete" name="price_breaks[{{ $key }}][delete]" value="0" />
		                                	<input type="hidden" class="price-breaks-id" name="price_breaks[{{ $key }}][id]" value="{{ $key }}" />
		                                	<input type="text" class="form-control text-right price-break-range-from" name="price_breaks[{{ $key }}][range_from]" value="{{ $price_break['range_from'] }}" onfocus="storeRange(this)" onchange="changeRange(this)" />
		                                </td>
		                                <td class="text-right">
		                                	<input type="text" class="form-control text-right price-break-range-to" name="price_breaks[{{ $key }}][range_to]" value="{{ $price_break['range_to'] }}" onfocus="storeRange(this)" onchange="changeRange(this)" />
		                                </td>
		                                <td class="text-right">
		                                	<input type="text" class="form-control text-right price-break-sell-price" name="price_breaks[{{ $key }}][sell_price]" value="{{ number_format($price_break['sell_price'],2) }}" onfocus="storeRange(this)" />
		                                </td>
		                                <td class="text-center">
		                                	<a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>
		                                </td>
		                            </tr>
		                            @endforeach
		                            @endif
		                        </tbody>
		                    	</table>
							</div>
							<div class="tab-pane" id="others">
								<div class="form-body">
									<div class="form-group">
										<label class="col-md-2 control-label">Default View
										</label>
										<div class="col-md-10">
											<div id="default-view-content" class="form-control height-auto" style="min-height: 50px;">
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label"> SVG file
										</label>
										<div class="col-md-10">
		                                    <div class="fileinput fileinput-new" data-provides="fileinput">
		                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
		                                        	@if( isset($product['svg_file']) && File::exists(public_path().DS.str_replace('/', DS, $product['svg_file'])) )
		                                        	<img src="{{ URL.'/'.$product['svg_file'] }}" />
		                                        	@else
		                                            <img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}"/>
		                                            @endif
		                                        </div>
		                                        <div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;">
		                                        </div>
		                                        <div>
		                                            <span class="btn default btn-file">
			                                            <span class="fileinput-new">
			                                            	Select SVG
			                                        	</span>
			                                            <span class="fileinput-exists">
			                                            	Change
			                                        	</span>
			                                            <input name="svg_file" id="file" accept="image/svg+xml" type="file">
		                                            </span>
		                                            <a href="javascript:void(0)" class="btn red fileinput-exists" data-dismiss="fileinput">
		                                            Remove </a>
		                                        </div>
		                                    </div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-2 control-label"> SVG Layout
										</label>
										<div class="col-md-10">
											<div class="row">
												<div class="col-md-8" >
													<select id="svg_layout_id" name="svg_layout_id" class="form-control">
														<?php $product['svg_layout_id'] = isset($product['svg_layout_id']) ? $product['svg_layout_id'] : 0;  ?>
														@if( isset($layouts) && !empty($layouts) )
														@foreach($layouts as $layout)
														<option value="{{ $layout['value'] }}" @if($product['svg_layout_id'] == $layout['value']) selected @endif >{{ $layout['text'] }}</option>
														@endforeach
														@endif
													</select>
												</div>
												<div class="col-md-4">
													<a class="btn btn-primary col-md-6" data-toggle="tooltip" title="Add new Layout" href="{{ URL }}/admin/layouts/add-layout" target="_blank"><i class="fa fa-plus"></i></a>
													<a id="edit-layout" class="btn green-meadow col-md-6" data-toggle="tooltip" title="Edit current Layout" href="{{ URL }}/admin/layouts/edit-layout/0" target="_blank"><i class="fa fa-edit"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		{{ Form::close() }}
	</div>
</div>
@section('pageCSS')
<link href="{{ URL::asset( 'assets/global/css/plugins.css' ) }}" rel="stylesheet" type="text/css"/>
<link href="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css' ) }}" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/typeahead/typeahead.css' ) }}" />
<link rel="stylesheet" type="text/css" href="{{ URL::asset( 'assets/global/plugins/select2/select2.css' ) }}" />
<style type="text/css">
div.ms-selection ul.ms-list{
	border-color: #35aa47;
}
#product-other-options-div{
	width: 90%;
	margin-left: -45%;
	overflow-y: auto;
}
#product-other-options-div .modal-dialog{
	width: 100%;
  	margin: 0;
}
#product-other-options-div .modal-body{
	height: 550px;
  	overflow-y: auto !important;
}
</style>
@stop
@section('pageJS')

<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-select/bootstrap-select.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/typeahead/handlebars.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/typeahead/typeahead.bundle.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js' ) }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/jquery-validation/js/jquery.validate.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js' ) }}"></script>
<script src="{{ URL::asset('assets/admin/js/plugin/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/media/js/jquery.dataTables.min.js' ) }}"></script>
<script type="text/javascript" src="{{ URL::asset( 'assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/fuelux/js/spinner.js' ) }}"></script>
<script src="{{ URL::asset( 'assets/global/plugins/select2/select2.min.js' ) }}"></script>
<script type="text/javascript">
$("#product-other-options-div").parent().css("overflow", "scroll !important");
var columnDefs = [
        {
            "targets": 2,
            "name"  : "code",
        },
        {
            "targets": 3,
            "name"  : "sku",
        },
        {
            "targets": 4,
            "name"  : "name",
        },
        {
            "targets": 5,
            "name"  : "product_type",
        },
        {
            "targets": 6,
            "name"  : "product_category",
        },
        {
            "targets": 7,
            "name"  : "oum"
        },
        {
            "targets": 8,
            "name"  : "sell_by"
        },
        {
            "targets": 9,
            "name"  : "sell_price",
            "className": "text-right"
        },
    ];
listRecord({
    url: "{{ URL.'/admin/products/list-jt-products' }}",
    table_id: "#list-product-other-options",
    columnDefs: columnDefs,
    pageLength: 10,
    fnDrawCallback: function(){
    	$("tr[role=row]", "#list-product-other-options > tbody").click(function(){
    		var row = $("#list-product-other-options").DataTable().row($(this)).data();
    		$("#product-other-options-div").modal("hide");
    		addOtherOptions({_id: row[0], code: row[2], sku: row[3], name: row[4], product_type: row[5], product_category: row[6], oum: row[7], sell_by: row[8], sell_price: row[9]});
    	});
    },
});
var optionGroups = {{ json_encode($option_groups) }};
var chosenOptions = {{ json_encode($product['options']) }};
var defaultview = {{ !empty($product['default_view']) ? $product['default_view'] : json_encode([]) }};
var imageView = {{ json_encode($arrView) }};
var imageViewHTML = "";
var option_group_id = $("#option_group_id");
var layouts = {{ json_encode($layouts) }};
var JTValid = false;
var margin = 0;
$("#categories").select2({
	allowClear: true,
});
var skus = new Bloodhound({
  datumTokenizer: function(d) { return d.tokens; },
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  remote: "{{ URL.'/admin/products/autocomple-sku?sku=%QUERY'; }}",
});
skus.initialize();
$("[name=sku]").typeahead(null, {
	name: "sku",
	displayKey: "sku",
	source: skus.ttAdapter(),
	hint: false,
	templates: {
	suggestion: Handlebars.compile([
	  '<div class="media">',
	        '<div class="media-body">',
	            '<h4 class="media-heading">@{{sku}}</h4>',
	            '<p>@{{name}}</p>',
	        '</div>',
	  '</div>',
	].join(''))
	},

});
$("[name=sku]").on('typeahead:selected', function (e, datum) {
	$("#sku-checker").trigger("click");
}).change(function(){
	$("#sku-checker").trigger("click");
});
$("#sku-checker").click(function(){
	JTValid = false;
	$.ajax({
		url: "{{ URL.'/admin/products/check-sku' }}",
		type: "POST",
		data: {sku: $("[name=sku]").val()},
		success: function(result){
			$("#sku-checker").removeClass("red").removeClass("green").removeClass("yellow");
			$("i", "#sku-checker").removeClass("fa-remove").removeClass("fa-check");
			if( result.check == "ok" ) {
				$("#sku-checker").addClass("green");
				$("i", "#sku-checker").addClass("fa-check");
				JTValid = true;
				$("#price-list-table .sizew").trigger('change');
			} else {
				$("#sku-checker").addClass("red");
				$("i", "#sku-checker").addClass("fa-remove");
			}
		}
	});
}).trigger("click");
$('[name="margin_up"]').change(function(){
	margin = 100 + parseFloat($(this).val());
	$("#price-list-table .sell-percent").val( margin ).trigger('change');
})/*.trigger('change')*/;
$(".bs-select").selectpicker({
    iconBase: 'fa',
    tickIcon: 'fa-check'
});
option_group_id.select2({
	allowClear: true
}).change(function(){
	var values = $(this).val();
	var html = "";
	imageViewHTML = "";
	if( values && values.length ) {
		for(var i in values) {
			for(var j in optionGroups) {
				if( optionGroups[j].value == values[i] ) {
					imageViewHTML += createimageViewHTML(optionGroups[j]);
					html += createOptionsHTML(optionGroups[j]);
					break;
				}
			}
		}
	}
	$(".image-view-table").html(imageViewHTML);
	imageViewTableInit();
	$("#options-content").html(html);
	$("#default-view-content").html(html);
	defaultViewContentInit();
	if( html != "" ) {
		$("select.options", "#options-content").select2({
		    allowClear: true
		}).change(function(){
			if( !$(this).val() ) {
				$(this).select2('val', $("option:first", this).val());
			}
			var optionGroupID = $(this).attr("data-option-group-id");
			var html = '<option value="0"></option>';
			$("option:selected", "select.options[data-option-group-id="+ optionGroupID +"]").each(function(){
				var value = $(this).val();
				var text = $(this).text();
				var selected = "";
				if( imageView[optionGroupID] != undefined && imageView[optionGroupID][value] != undefined ) {
					selected = "selected";
				}
				html += '<option value="'+ value +'" '+ selected +'>'+ text +'</option>';
			});
			$("tr[data-option-group-id="+ optionGroupID +"] select", ".image-view-table").html(html);
			imageViewTableInit();
			$("select[data-option-group-id="+ optionGroupID +"]", "#default-view-content").html(html);
			defaultViewContentInit();
		}).trigger("change");
	}
}).trigger("change");
$(".maxlength-handler").maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});
$(".price-break-range-from, .price-break-range-to", "#price-break-table").inputmask({
    "mask": "9",
    "repeat": 10,
    "greedy": false
});
$(".price-break-sell-price", "#price-break-table").inputmask("decimal", { digits: 2, allowMinus: false, autoGroup: true, groupSeparator: ".", groupSize: 3 });
$("#product-form").validate({
    errorElement: 'span',
    errorClass: 'help-block help-block-error',
    focusInvalid: true,
    ignore: "",
    rules: {
        name: {
            minlength: 6,
            required: true
        },
        sku: {
            minlength:3,
            required: true
        },
        price: {
            number: true
        }
    },
    invalidHandler: function (event, validator) {
        $(".alert-danger","#product-form").show();
        Metronic.scrollTo($(".alert-danger","#product-form"), -200);
    },
    highlight: function (element) {
        $(element)
            .closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
        $(element)
            .closest('.form-group').removeClass('has-error');
    },
    success: function (label) {
        label
            .closest('.form-group').removeClass('has-error');
    },
    submitHandler: function (form) {
        $(".alert-danger","#product-form").hide();
        this.submit();
    }
});

CKEDITOR.replace("description-content");

$("input[type=checkbox]", "#images-table").click(function(){
	if( $(this).is(":checked") ) {
		$("input[type=checkbox]", "#images-table").prop("checked", false);
		$("input[type=checkbox]", "#images-table").parent().removeClass("checked");
		$(this).prop("checked", true);
		$(this).parent().addClass("checked");
	}
});
$("input.price", "#product-options-table").inputmask({
    "mask": "9",
    "repeat": 10,
    "greedy": false
});
$("#other-options-table").on("change", "input.price", function(){
	var parent = $(this).closest("tr");
	var sell_price 	= parseFloat($(".sell_price", parent).val().replace(/,/g, ""));
	var discount 	= parseFloat($(".discount", parent).val().replace(/,/g, ""));
	var quantity 	= parseFloat($(".quantity", parent).val().replace(/,/g, ""));
	var total = sell_price * quantity;
		total -= (total * discount) / 100;
	$(".sub-total", parent).text(total.toFixed(2));
});
$("#other-options-table").on("click", ".row-details", function(){
	var parent = $(this).closest("tr");
	var id = parent.attr("data-id");
	if( $(this).hasClass("row-details-open") ) {
		$("tr.details[data-id="+id+"]", "#other-options-table").hide();
		$(this).removeClass("row-details-open").addClass("row-details-close");
	} else {
		if( $("tr.details[data-id="+id+"]", "#other-options-table").length ) {
			$("tr.details[data-id="+id+"]", "#other-options-table").show();
		} else {
			var detail = $(".detail-data", parent).val();
				detail = JSON.parse(detail);
			var html = '<tr class="details" data-id="'+ id +'">'	+
							'<td colspan="10">'	+
								'<table style="width: 100%;">' +
									'<tr>'	+
										'<td style="width: 20%">SKU</td>'	+
										'<td>'+ detail.sku +'</td>'	+
									'</tr>'	+
									'<tr>'	+
										'<td>Name</td>'	+
										'<td>'+ detail.name +'</td>'	+
									'</tr>'	+
									'<tr>'	+
										'<td>Type</td>'	+
										'<td>'+ detail.product_type +'</td>'	+
									'</tr>'	+
									'<tr>'	+
										'<td>Category</td>'	+
										'<td>'+ detail.product_category +'</td>'	+
									'</tr>'	+
									'<tr>'	+
										'<td>OUM</td>'	+
										'<td>'+ detail.oum +'</td>'	+
									'</tr>'	+
									'<tr>'	+
										'<td>Sold by</td>'	+
										'<td>'+ detail.sell_by +'</td>'	+
									'</tr>'	+
								'</table>'	+
							'</td>'	+
						'</tr>';
			parent.after(html);
		}
		$(this).removeClass("row-details-close").addClass("row-details-open");
	}

});

$("#check-all-options", "#other-options-table").click(function(){
	$(".check-options", "#other-options-table").prop("checked", $(this).is(":checked"));
});

$('#order-spinner').spinner({value: {{ $product['order_no'] or 1 }}, min: 1});

$("#svg_layout_id").select2({
    placeholder: "Select a Layout",
    allowClear: true,
    formatResult: format,
    formatSelection: format,
    escapeMarkup: function (m) {
        return m;
    }
}).change(function(){
	var value = $(this).val();
	if( value != 0 ) {
		$("#edit-layout", "#others").removeClass("disabled disabled-link").attr("href", "{{ URL }}/admin/layouts/edit-layout/" + value);
	} else {
		$("#edit-layout", "#others").addClass("disabled disabled-link");
	}
}).trigger("change");

$("[data-toggle=tooltip]", "#others").tooltip();

function format(layout)
{
    if (!layouts[layout.id].svg) return '<span style="width: 35px; height: 35px">&nbsp;</span>'+layout.text;
    return '<img style="height: 35px; width: 35px;" src="{{ URL }}/'+ layouts[layout.id].svg +'"/>&nbsp;&nbsp;' + layout.text;
}

function createimageViewHTML(object)
{
	var optionsData = object.options,
		options = '';
	if( $("[data-option-group-id="+object.id+"] option:selected",  "#options-content").length ) {
		var chosen = $("[data-option-group-id="+object.id+"] option:selected",  "#options-content").val();
		for( var i in optionsData ) {
			if( $.inArray(optionsData[i].value, chosen) ) {
				options += '<option value="'+ optionsData[i].value +'">'+ optionsData[i].text +'</option>';
			}
		}
	} else {
		for( var i in optionsData ) {
			options += '<option value="'+ optionsData[i].value +'">'+ optionsData[i].text +'</option>';
		}
	}
	var html = '<tr data-option-group-id="'+ object.value +'">' +
					'<td>'+ object.text +'</td>' +
					'<td>' +
						'<select class="form-control">' +
						'<option value="0"></option>' +
						options+
						'</select>' +
					'</td>' +
				'</tr>';
	return html;
}
function createOptionsHTML(object)
{
	if( !Object.keys(object.options).length ) {
		return "Option Group was empty!";
	}
	var id = object.value,
		text = object.text,
		optionsData = object.options,
		options = '',
		selected,
		count = 0;
	for( var i in optionsData ) {
		selected = "";
		if( $.inArray(optionsData[i].value, chosenOptions)!== -1 ) {
			selected = "selected";
			count++;
		}
		options += '<option '+selected+' value="'+ optionsData[i].value +'">'+ optionsData[i].text +'</option>';
	}
	if( options && !count ) {
		options = options.replace(/<option/g, '<option selected');
	}
	var html = '<div class="form-group">' +
					'<label class="col-md-2 control-label">'+ text +'</label>' +
					'<div class="col-md-10">' +
						'<select class="options form-control" data-option-group-id="'+ id +'" id="option_group_id" multiple name="option_id[]" data-width="90%">' +
						options+
						'</select>' +
					'</div>' +
				'</div>';
	return html;
}

function addPriceList()
{
	var index = $("tbody > tr[class!=empty]", "#price-list-table").length;
    if( !index ){
        $("tr.empty", "#price-list-table").remove();
    }
    var key = $("tbody > tr:last", "#price-list-table").attr("data-id");
    if( key == undefined )
        key = 0;
    else
        key++;
    var className = "odd";
    if( index%2 == 0 )
        className = "even";
    var html = [
            '<tr class="'+className+'" data-id="'+key+'">',
                "<td>"+(index + 1)+"</td>",
                '<td>',
                	'<input class="text-right form-control sizew" type="text" name="price_lists['+key+'][sizew]" value="0" />',
                "</td>",
                '<td>',
                	'<input class="text-right form-control sizeh" type="text" name="price_lists['+key+'][sizeh]" value="0" />',
                "</td>",
                '<td>',
                	'<input class="text-right form-control cost-price" readonly type="text" name="price_lists['+key+'][cost_price]" value="0" />',
                "</td>",
                '<td>',
                	'<input class="text-right form-control sell-price" type="text" name="price_lists['+key+'][sell_price]" value="0" />',
                "</td>",
                '<td>',
                	'<div class="input-group" style="text-align:left">',
                		'<input class="text-right form-control sell-percent" style="width: 60%" type="text" name="price_lists['+key+'][sell_percent]" value="'+ margin +'" />',
                		'<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Sell Price = Cost Price * Sell Percent">',
                		'<i class="fa"></i> % </a>',
                	'</div>',
                "</td>",
                '<td>',
                	'<input class="text-right form-control bigger-price" type="text" name="price_lists['+key+'][bigger_price]" value="0" />',
                "</td>",
                '<td>',
	                '<div class="input-group" style="text-align:left">',
	                	'<input class="text-right form-control bigger-percent" style="width: 60%" type="text" name="price_lists['+key+'][bigger_percent]" value="100" />',
	                	'<a href="javascript:;" data-toggle="tooltip" class="btn blue percent-calculator" title="Bigger Price = Sell Price * Bigger Percent">',
	                	'<i class="fa"></i> % </a>',
	                '</div>',
                "</td>",
                '<td class="text-center">',
                    '<input type="checkbox" class="default" name="price_lists['+key+'][default]" value="'+key+'" '+(!index ? 'checked' : '')+' />',
                "</td>",
                '<td  class="text-center">',
                    '<a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>',
                "</td>",
            "</tr>"
    ].join("");
    $("tbody", "#price-list-table").append(html);
    $("[data-toggle=tooltip]", "#price-list-table tr:last").tooltip();
    $("[type=text]", "#price-list-table tr:last").inputmask("decimal", { digits: 2, allowMinus: false, autoGroup: true, groupSeparator: ".", groupSize: 3 });
}

function priceListInit()
{
	var priceBreakTable = $("#price-list-table");
	$(priceBreakTable).on("change", ".sizew, .sizeh", function(){
		var tr = $(this).closest("tr");
		if( JTValid ) {
			var data = {};
			data["sku"]   = $("[name=sku]").val();
			data["sizew"] = $(".sizew", tr).val();
			data["sizeh"] = $(".sizeh", tr).val();
			$.ajax({
				url: "{{ URL }}/admin/products/get-cost-price",
				type: "POST",
				data: data,
				success: function( result ) {
					var costPrice = 0;
					if( result.status == "ok" ) {
						costPrice = result.cost_price;
					}
					$(".cost-price", tr).val(costPrice).trigger("change");
				}
			});
		} else {
			$(".cost-price", tr).val("0.00").trigger("change");
		}
	});

	$(priceBreakTable).on("change", ".cost-price", function(){
		var tr 		= $(this).closest("tr");
		var value 	= parseFloat($(this).val().replace(/,/g, ""));
		var percent = parseFloat($(".sell-percent", tr).val() || 0);
		$(".sell-price", tr).val( (value * percent / 100).toFixed(2) ).trigger("change");
	});

	$(priceBreakTable).on("change", ".sell-price", function(){
		var tr 		= $(this).closest("tr");
		var value 	= parseFloat($(this).val().replace(/,/g, ""));
		var newPercent = value / parseFloat($('.cost-price', tr).val() || 1) * 100;
		$('.sell-percent', tr).val(newPercent.toFixed(2));
		var percent = parseFloat($(".bigger-percent", tr).val() || 0);
		$(".bigger-price", tr).val( (value * percent / 100).toFixed(2) );
	});

	$(priceBreakTable).on("change", ".bigger-price", function(){
		var tr 		= $(this).closest("tr");
		var value 	= parseFloat($(this).val().replace(/,/g, ""));
		var newPercent = value / parseFloat($('.sell-price', tr).val() || 1) * 100;
		$('.bigger-percent', tr).val(newPercent.toFixed(2));
	});

	$(priceBreakTable).on("change", ".bigger-percent, .sell-percent", function(){
		var tr 		= $(this).closest("tr");
		if( $(this).hasClass("sell-percent") ) {
			$(".cost-price", tr).trigger("change");
		} else {
			$(".sell-price", tr).trigger("change");
		}
	});

	$(priceBreakTable).on("click", ".percent-calculator", function(){
		var tr 		= $(this).closest("tr");
		if( $(this).prev().hasClass("bigger-percent") ) {
			$(".cost-price", tr).trigger("change");
		} else {
			$(".bigger-price", tr).trigger("change");
		}
	});

	$(priceBreakTable).on("change", ".default", function(){
		if( $(this).is(":checked") ) {
			$(".default", priceBreakTable).prop("checked", false);
			$(this).prop("checked", true);
		} else {
			if( $(".default", priceBreakTable).length == 1 ) {
				$(this).prop("checked", true);
			} else {
				$(".default", priceBreakTable).not(this).each(function(){
					$(this).prop("checked", true);
					return false;
				});
			}
		}
	});
}

priceListInit();

function deleteRow(object)
{
	var message, tableID;
	switch( $(object).closest("table").attr("id") ) {
		case "images-table":
			message = "Are you sure you want to delete this image?";
			tableID = "#images-table";
			break;
		case "price-break-table":
			message = "Are you sure you want to delete this price break?";
			tableID = "#price-break-table";
			break;
		case "other-options-table":
			message = "Are you sure you want to delete this option?";
			tableID = "#other-options-table";
			break;
		case "price-list-table":
			message = "Are you sure you want to delete this size?";
			tableID = "#price-list-table";
			break;
	}
    var parent = $(object).parent().parent();
    if($(".delete", parent).length) {
        bootbox.confirm(message, function(result){
            if(result) {
                $("input.delete", parent).val(1);
                $(parent).hide();
            	if( tableID == "#other-options-table" ) {
            		$("tr.details[data-id="+ $(object).closest("tr").attr("data-id") +"]", tableID).remove();
                	resetIndexTable(tableID, true);
            	} else {
                	resetIndexTable(tableID);
            	}
            }
        });
    } else {
        $(parent).fadeOut().remove();
	    if( tableID == "#other-options-table" ) {
			$("tr.details[data-id="+ $(object).closest("tr").attr("data-id") +"]", tableID).remove();
        	resetIndexTable(tableID, true);
		} else {
        	resetIndexTable(tableID);
		}
    }
}

function resetIndexTable(tableID, noOrder)
{
	var i = 0;
	$(tableID +" > tbody > tr[class!=details]").not(":hidden").each(function(){
	    $(this).removeClass("odd").removeClass("even");
	    className = "odd";
	    if( i%2 == 0 )
	        className = "even";
	    $(this).addClass(className);
	    if( noOrder != true ) {
	    	$("td:first", this).text(++i);
	    }
	});
}

function showError(message)
{
	Metronic.alert({
	    type: 'danger',
	    icon: 'warning',
	    block: true,
	    title: 'Error',
	    message: message,
	    place: 'append',
	    focus: true,
	    closeInSeconds: 3
	});
}

function findMaxKey()
{
	var key = 0;
	var max = 0;
	$("tr", "#price-break-table").not(":hidden").each(function(){
		var id = parseInt($(this).attr("data-id"));
		var range_to = parseInt($(".price-break-range-to", this).val());
		if( id > key ) {
			key = id;
		}
		if( range_to > max ) {
			max = range_to;
		}
	});
	return {max: max, key: key};
}

function addPriceBreak(object)
{
	var index, key, found,
		range_from, range_to,
		sell_price, className,
		newInput, extraInput, html;
	if( object == undefined ) {
		object = {};
	}
	if( object.index == undefined ) {
		index = $("tbody > tr[class!=empty]", "#price-break-table").not(":hidden").length;
		if( !index ){
		    $("tr.empty", "#price-break-table").remove();
		}
	} else {
		index = object.index;
	}
    if( object.key == undefined ) {
    	found = findMaxKey();
    	key = found.key;
    } else {
    	key = object.key;
    }
    if( object.range_from == undefined ) {
    	range_from = found.max;
    		range_from++;
    } else {
    	range_from = object.range_from;
    }
    if( object.range_to == undefined ) {
    	range_to = range_from + 4;
    } else {
    	range_to = object.range_to;
    }
    if( object.sell_price == undefined ) {
    	sell_price = "0.00";
    } else {
    	sell_price = object.sell_price;
    }
    if( object.key == undefined ) {
    	if( key == undefined )
    	    key = 0;
    	else
    	    key++;
    }
    className = "odd";
    if( index%2 == 0 )
        className = "even";
    extraInput = "";
    if( object.extraInput != undefined ) {
    	extraInput = object.extraInput;
    }
    html = [
            '<tr class="'+className+'" data-id="'+key+'"'+(object.isHidden == true ? ' style="display:none;"' : '')+'>',
                "<td>"+(index + 1)+"</td>",
                '<td class="text-right">',
                    extraInput,
                    '<input type="text" class="form-control text-right price-break-range-from" name="price_breaks['+key+'][range_from]" value="'+range_from+'" onfocus="storeRange(this)" onchange="changeRange(this)" />',
                "</td>",
                '<td class="text-right">',
                    '<input type="text" class="form-control text-right price-break-range-to" name="price_breaks['+key+'][range_to]" value="'+range_to+'" onfocus="storeRange(this)" onchange="changeRange(this)" />',
                "</td>",
                '<td class="text-right">',
                    '<input type="text" class="form-control text-right price-break-sell-price" name="price_breaks['+key+'][sell_price]" value="'+sell_price+'" />',
                "</td>",
                '<td  class="text-center">',
                    '<a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>',
                "</td>",
            "</tr>"
    ].join("");
    if( object.isReturn ) {
    	return html;
    }
    $("tbody", "#price-break-table").append(html);
    $(".price-break-range-from, .price-break-range-to", "#price-break-table tr[data-id="+key+"]").inputmask({
        "mask": "9",
        "repeat": 10,
        "greedy": false
    });
    $(".price-break-sell-price", "#price-break-table tr[data-id="+key+"]").inputmask("decimal", { digits: 2, allowMinus: false, autoGroup: true, groupSeparator: ".", groupSize: 3 });
}

function storeRange(object)
{
	$(object).attr("data-value", $(object).val());
}

function restoreRange(object)
{
	$(object).val( $(object).attr("data-value") ).focus();
}

function changeRange(object)
{
	var tr = $(object).closest("tr");
	var id = tr.attr("data-id");
	var value = parseInt($(object).val());
	var error = false,
		message = "";
	if( $(object).hasClass("price-break-range-from") ) {
		if( value >= parseInt($(".price-break-range-to", tr).val()) ) {
			message = 'The "range to" value must be greater than the "range from" value.';
			error = true;
		} else {
			$("tr[data-id!="+id+"]", "#price-break-table tbody").not(":hidden").each(function(){
				if( value >= parseInt($(".price-break-range-from", this).val())
					&& value <= parseInt($(".price-break-range-to", this).val()) ) {
					message = 'The "range from" value must not in range of any existed "range from" to "range to".';
					error = true;
					return false;
				}
			});
		}
	} else {
		if( value <= parseInt($(".price-break-range-from", tr).val()) ) {
			message = 'The "range from" value must be lesser than the "range to" value.';
			error = true;
		} else {
			$("tr[data-id!="+id+"]", "#price-break-table tbody").not(":hidden").each(function(){
				if( value >= parseInt($(".price-break-range-from", this).val())
					&& value <= parseInt($(".price-break-range-to", this).val()) ) {
					message = 'The "range to" value must not in range of any existed "range from" to "range to".';
					error = true;
					return false;
				}
			});
		}
	}
	if( error ) {
		restoreRange(object);
		showError(message);
		return false;
	} else {
		var lastTR = $("tr[data-id!="+id+"]:last", "#price-break-table tbody");
		if( parseInt($(".price-break-range-to", tr).val()) > parseInt($(".price-break-range-to", lastTR).val()) ) {
			$(".price-break-range-from", tr).val($(".price-break-range-to", lastTR).val());
		}
	}
	storeRange(object);
	reArrangeRange();
}

function reArrangeRange()
{
	var arr = {}, id, tr, html = "";
	$("tr", "#price-break-table tbody").each(function(){
		id = parseInt($(this).attr("data-id"));
		arr[id] = parseInt($(".price-break-range-from", this).val() || 0);
	});
	arrSorted = Object.keys(arr).sort(function(a,b){return arr[a]-arr[b]});
	var index = 0;
	for( var i in arrSorted ) {
		tr = $("tr[data-id="+arrSorted[i]+"]", "#price-break-table");
		arrNew = {};
		arrNew["index"]			= index;
		arrNew["key"]			= arrSorted[i];
		arrNew["range_from"] 	= parseInt($(".price-break-range-from", tr).val());
		arrNew["range_to"] 		= parseInt($(".price-break-range-to", tr).val());
		arrNew["sell_price"] 	= $(".price-break-sell_price", tr).val();
		arrNew["isHidden"] 		= $("tr[data-id="+arrSorted[i]+"]", "#price-break-table").is(":hidden") ? true : false;
		arrNew["isReturn"]		= true;
		arrNew["extraInput"]    = '';
		if( $(".delete", tr).length  ) {
			arrNew["extraInput"] += '<input type="hidden" class="delete" name="price_breaks['+arrNew["key"]+'][delete]" value="'+$(".delete", tr).val()+'" />';
		}
		if( $(".price-breaks-id", tr).length  ) {
			arrNew["extraInput"] += '<input type="hidden" class="price-breaks-id" name="price_breaks['+arrNew["key"]+'][id]" value="'+$(".price-breaks-id", tr).val()+'" />';
		}
		html += addPriceBreak(arrNew);
		index++;
	}
	$("tbody", "#price-break-table").html(html);
	$(".price-break-range-from, .price-break-range-to", "#price-break-table").inputmask({
	    "mask": "9",
	    "repeat": 10,
	    "greedy": false
	});
	$(".price-break-sell-price", "#price-break-table").inputmask("decimal", { digits: 2, allowMinus: false, autoGroup: true, groupSeparator: ".", groupSize: 3 });
}

function imageViewTableInit()
{
	$(".image-view-table", "#images-table").each(function(){
		var id = $(this).closest("tr").attr("data-id");
		$("select", this).each(function(){
			$(this).attr("name", "images["+ id +"][view][]");
			if( imageView[id] !== undefined && imageView[id].length ) {
				for( var i in imageView[id] ) {
					if( $("option[value="+ imageView[id][i] +"]", this).length ) {
						$(this).val(imageView[id][i]);
						break;
					}
				}
			}
		});
	});
}

function addImage()
{
    var index = $("tbody > tr[class!=empty][role=row]", "#images-table").length;
    if( !index ){
        $("tr.empty", "#images-table").remove();
    }
    var key = $(".image-id:last", "#images-table").val();
    if( key == undefined )
        key = 0;
    else
        key++;
    var className = "odd";
    if( index%2 == 0 )
        className = "even";
    var html = [
            '<tr role="row" class="'+className+'" data-id="'+key+'">',
                "<td>"+(index + 1)+"</td>",
                '<td data-id="'+key+'">',
                    '<input type="hidden" class="image-id" name="images['+key+'][new]" value="'+key+'" />',
                    '<div class="fileinput fileinput-new" data-provides="fileinput">',
                        '<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">',
                            '<img data-origin-src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" src="{{ URL::asset( 'assets/images/noimage/247x185.gif' ) }}" alt=""/>',
                        '</div>',
                        '<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px; height: 150px;">',
                        '</div>',
                        '<div>',
                            '<span class="btn default btn-file">',
                            '<span class="fileinput-new">',
                            'Select image </span>',
                            '<span class="fileinput-exists">',
                            'Change </span>',
                            '<input name="images['+key+'][file]" id="file" accept="image/*" type="file">',
                            '</span>',
		                    '<a href="javascript:void(0)" class="btn green fileinput-new" onclick="openImage(this)" >Choose</a>',
                            '<a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">',
                            'Remove </a>',
                        '</div>',
                    '</div>',
                "</td>",
                '<td>',
                	'<table class="image-view-table" style="width: 100%">',
                	'<tbody>',
                		imageViewHTML,
                	'</tbody>',
                	'</table>',
                '</td>',
                '<td class="text-center">',
                    '<input type="checkbox" name="images['+key+'][main]" value="'+key+'" />',
                "</td>",
                '<td  class="text-center">',
                    '<a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>',
                "</td>",
            "</tr>"
    ].join("");
    if( $("tbody > tr[role=row]:last", "#images-table").length) {
    	$("tbody > tr[role=row]:last", "#images-table").after(html);
    } else {
    	$("tbody", "#images-table").append(html);
    	imageViewTableInit();
    }
	$("tr[data-id="+ key +"] .image-view-table select", "#images-table").each(function(){
		$(this).attr("name", "images["+ key +"][view][]");
	});
}

function restoreImageState(object)
{
	var parent = $(object).closest("td");
	$("[name*='[choose_image]']", parent).remove();
	$(".thumbnail > img", parent).attr("src", $(".thumbnail > img", parent).attr("data-origin-src"));
}

function chooseImage(object)
{
	var parent = $(currentObject).closest("td");
	var id = parent.attr("data-id");
	if( $("images["+id+"][choose_image]", parent).length ) {
		$("images["+id+"][choose_image]", parent).val($(object).attr("data-id"));
	} else {
		parent.prepend('<input type="hidden" name="images['+id+'][choose_image]" value="'+$(object).attr("data-id")+'" />');
	}
	var src = $("img", object).attr("src");
	$(".thumbnail > img", parent).attr("src", src);
	$(modal).modal("hide");

}

function addOtherOptions(object)
{
    var index = $("tbody > tr[class!=empty]", "#other-options-table").length;
    if( !index ){
        $("tr.empty", "#other-options-table").remove();
    }
    var key = $("tbody.main > tr[class!=details]:last", "#other-options-table").attr("data-id");
    if( key == undefined )
        key = 0;
    else
        key++;
    var className = "odd";
    if( index%2 == 0 )
        className = "even";
    var html = [
            '<tr class="'+className+'" data-id="'+key+'">',
                '<td>',
                	'<input class="check-options" type="checkbox" value="'+key+'" />',
                	'<span class="row-details row-details-close"></span>',
                	'<input type="hidden" class="detail-data" value="'+htmlEntities(JSON.stringify(object))+'" />',
                '</td>',
                '<td>',
                	'<input type="hidden" name="product_options['+key+'][product_id]" value="'+object._id+'" />',
                	object.code,
                "</td>",
                '<td class="text-center">',
                    '<input type="checkbox" name="product_options['+key+'][require]" value="'+key+'" />',
                "</td>",
                '<td class="text-center">',
                    '<input type="checkbox" name="product_options['+key+'][same_parent]" value="'+key+'" />',
                "</td>",
                '<td>',
                    '<input class="price sell_price form-control text-right" type="text" name="product_options['+key+'][unit_cost]" value="'+object.sell_price+'" />',
                "</td>",
                '<td>',
                    '<input class="price discount form-control text-right" type="text" name="product_options['+key+'][discount]" value="0" />',
                "</td>",
                '<td>',
                    '<input class="price quantity form-control text-right" type="text" name="product_options['+key+'][quantity]" value="1" />',
                "</td>",
                '<td class="text-right">',
                    '<span class="sub-total">' + object.sell_price + '</span>',
                "</td>",
                '<td class="text-center">',
                    '<input type="checkbox" name="product_options['+key+'][hidden]" value="'+key+'" />',
                "</td>",
                '<td  class="text-center">',
                    '<a class="btn btn-primary red btn-delete-button btn-sm" onclick="deleteRow(this)" href="javascript:void(0);" title="Delete"><i class="fa fa-times"></i>Delete </a>',
                "</td>",
            "</tr>"
    ].join("");
    $("tbody.main", "#other-options-table").append(html);
    $("tr[data-id="+key+"] input.price", "#other-options-table").inputmask("decimal", {digits: 2, allowMinus: false, autoGroup: true, groupSeparator: ".", groupSize: 3 });
}

function htmlEntities(str) {
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function deleteOtherOptions()
{
	if( !$(".check-options:checked", "#other-options-table").length ) {
		toastr.warning("Please choose at least one option to delete!", 'Message');
	} else {
		bootbox.confirm("Are you sure you want to delete these options?", function(result){
            if(result) {
            	$(".check-options:checked", "#other-options-table").each(function(){
            		var parent = $(this).closest("tr");
            		var id = parent.attr("data-id");
            		if( $("input.delete", parent).length ) {
            			$("input.delete", parent).val(1);
                		$(parent).hide();
            		} else {
            			$(parent).remove();
            		}
            		$("tr.details[data-id="+ id +"]").remove();
            	});
            	$("#check-all-options", "#other-options-table").prop("checked", false);
                resetIndexTable("#other-options-table", true);
            }
        });
	}
}

function defaultViewContentInit()
{
	$(".col-md-2", "#default-view-content").removeClass("col-md-2").addClass("col-md-4");
	$(".col-md-10", "#default-view-content").removeClass("col-md-10").addClass("col-md-8");
	$("option[value=0]", "#default-view-content select").remove();
	$("select", "#default-view-content").removeAttr("id").removeClass("options").addClass("form-control").removeAttr("multiple").attr("name", 'default_view[]').each(function(){
		var select = this;
		$("option", select).each(function(){
			var value = $(this).val();
			if( $.inArray(value, defaultview) != -1 ) {
				$(select).val(value);
				return;
			}
		});
	});
}

</script>
@stop

@extends('admin.layout.image-browser',['controller' => 'products', 'holder' => '#images-table'])