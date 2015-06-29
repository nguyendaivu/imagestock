<!--BEGIN QUICK SIDEBAR -->
<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
<div class="page-quick-sidebar-wrapper">
	<div class="page-quick-sidebar">
		<div class="nav-justified">
			<ul class="nav nav-tabs nav-justified">
				<li class="active">
					<a href="#chatbox" data-toggle="tab">
					Chat Box
					</a>
				</li>
				<!--
				<li>
					<a href="#quick_sidebar_tab_2" data-toggle="tab">
					Alerts <span class="badge badge-success">7</span>
					</a>
				</li>
				-->
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					More<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu pull-right" role="menu">
						<li>
							<a href="#quick_sidebar_tab_3" data-toggle="tab">
							<i class="icon-bell"></i> Alerts </a>
						</li>
						<li>
							<a href="#quick_sidebar_tab_3" data-toggle="tab">
							<i class="icon-info"></i> Notifications </a>
						</li>
						<li>
							<a href="#quick_sidebar_tab_3" data-toggle="tab">
							<i class="icon-speech"></i> Activities </a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="#quick_sidebar_tab_3" data-toggle="tab">
							<i class="icon-settings"></i> Settings </a>
						</li>
					</ul>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active page-quick-sidebar-chat" id="chatbox">
					<div class="page-quick-sidebar-chat-users" data-rail-color="#ddd" data-wrapper-class="page-quick-sidebar-list">
						<?php $messages = Chat::messages(); ?>
						<h3 class="list-heading">Staffs</h3>
						<ul id="staff-chatters" class="media-list list-items">
							@if( isset($messages['admin']) )
							@foreach($messages['admin'] as $message)
							<li class="media" data-chatter-id="{{ $message['from_id'] }}">
								<div class="media-status">
									@if($message['new_message'])
									<span class="badge badge-success">{{ $message['new_message'] }}</span>
									@endif
								</div>
								<img class="media-object" src="{{ URL.'/'.$message['avatar'] }}" alt="...">
								<div class="media-body">
									<h4 class="media-heading">
										{{ $message['from'] }}
									</h4>
									<div class="media-heading-sub">
										{{ $message['position'] }}
									</div>
									<div class="media-heading-small">
										{{ date('h:i d M, Y', $message['time']) }}
									</div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
						<h3 class="list-heading">Customers</h3>
						<ul id="customer-chatters" class="media-list list-items">
							@if( isset($messages['customer']) )
							@foreach($messages['customer'] as $message)
							<li class="media" data-chatter-id="{{ $message['from_id'] }}">
								<div class="media-status">
									@if($message['new_message'])
									<span class="badge badge-success">{{ $message['new_message'] }}</span>
									@endif
								</div>
								<img class="media-object" src="{{ URL.'/'.$message['avatar'] }}" alt="...">
								<div class="media-body">
									<h4 class="media-heading">
										{{ $message['from'] }}
									</h4>
									<div class="media-heading-sub">
										{{ $message['company'] }}
									</div>
									<div class="media-heading-small">
										{{ date('h:i d M, Y', $message['time']) }}
									</div>
								</div>
							</li>
							@endforeach
							@endif
						</ul>
					</div>
					<div class="page-quick-sidebar-item">
						<div class="page-quick-sidebar-chat-user">
							<div class="page-quick-sidebar-nav">
								<a href="javascript:;" class="page-quick-sidebar-back-to-list"><i class="icon-arrow-left"></i>Back</a>
							</div>
							<div class="page-quick-sidebar-chat-user-form">
								<div class="input-group">
									<textarea id="message-content" class="form-control" placeholder="Type a message here..." style="resize: none;"></textarea>
									<div class="input-group-btn">
										<button type="button" class="btn blue" style="height: 50px;width: 15px;"></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--
				<div class="tab-pane page-quick-sidebar-alerts" id="quick_sidebar_tab_2">
					<div class="page-quick-sidebar-alerts-list">
						<h3 class="list-heading">General</h3>
						<ul class="feeds list-items">
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-check"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 4 pending tasks. <span class="label label-sm label-warning ">
												Take action <i class="fa fa-share"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 Just now
									</div>
								</div>
							</li>
							<li>
								<a href="#">
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-success">
												<i class="fa fa-bar-chart-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 Finance Report for year 2013 has been released.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 20 mins
									</div>
								</div>
								</a>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-danger">
												<i class="fa fa-user"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 5 pending membership that requires a quick review.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 24 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-shopping-cart"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 New order received with <span class="label label-sm label-success">
												Reference Number: DR23923 </span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 30 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-success">
												<i class="fa fa-user"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 5 pending membership that requires a quick review.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 24 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-bell-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 Web server hardware needs to be upgraded. <span class="label label-sm label-warning">
												Overdue </span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 2 hours
									</div>
								</div>
							</li>
							<li>
								<a href="#">
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-default">
												<i class="fa fa-briefcase"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 IPO Report for year 2013 has been released.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 20 mins
									</div>
								</div>
								</a>
							</li>
						</ul>
						<h3 class="list-heading">System</h3>
						<ul class="feeds list-items">
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-check"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 4 pending tasks. <span class="label label-sm label-warning ">
												Take action <i class="fa fa-share"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 Just now
									</div>
								</div>
							</li>
							<li>
								<a href="#">
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-danger">
												<i class="fa fa-bar-chart-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 Finance Report for year 2013 has been released.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 20 mins
									</div>
								</div>
								</a>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-default">
												<i class="fa fa-user"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 5 pending membership that requires a quick review.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 24 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-shopping-cart"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 New order received with <span class="label label-sm label-success">
												Reference Number: DR23923 </span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 30 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-success">
												<i class="fa fa-user"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 You have 5 pending membership that requires a quick review.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 24 mins
									</div>
								</div>
							</li>
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-warning">
												<i class="fa fa-bell-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 Web server hardware needs to be upgraded. <span class="label label-sm label-default ">
												Overdue </span>
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 2 hours
									</div>
								</div>
							</li>
							<li>
								<a href="#">
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-info">
												<i class="fa fa-briefcase"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc">
												 IPO Report for year 2013 has been released.
											</div>
										</div>
									</div>
								</div>
								<div class="col2">
									<div class="date">
										 20 mins
									</div>
								</div>
								</a>
							</li>
						</ul>
					</div>
				</div>
				-->
				<div class="tab-pane page-quick-sidebar-settings" id="quick_sidebar_tab_3">
					<div class="page-quick-sidebar-settings-list">
						<h3 class="list-heading">General Settings</h3>
						<ul class="list-items borderless">
							<li>
								 Enable Notifications <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
							<li>
								 Allow Tracking <input type="checkbox" class="make-switch" data-size="small" data-on-color="info" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
							<li>
								 Log Errors <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
							<li>
								 Auto Sumbit Issues <input type="checkbox" class="make-switch" data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
							<li>
								 Enable SMS Alerts <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="success" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
						</ul>
						<h3 class="list-heading">System Settings</h3>
						<ul class="list-items borderless">
							<li>
								 Security Level
								<select class="form-control input-inline input-sm input-small">
									<option value="1">Normal</option>
									<option value="2" selected>Medium</option>
									<option value="e">High</option>
								</select>
							</li>
							<li>
								 Failed Email Attempts <input class="form-control input-inline input-sm input-small" value="5"/>
							</li>
							<li>
								 Secondary SMTP Port <input class="form-control input-inline input-sm input-small" value="3560"/>
							</li>
							<li>
								 Notify On System Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="danger" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
							<li>
								 Notify On SMTP Error <input type="checkbox" class="make-switch" checked data-size="small" data-on-color="warning" data-on-text="ON" data-off-color="default" data-off-text="OFF">
							</li>
						</ul>
						<div class="inner-content">
							<button class="btn btn-success"><i class="icon-settings"></i> Save Changes</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END QUICK SIDEBAR