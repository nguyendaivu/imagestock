<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		@yield('sideMenu', '<ul id="sidebar-menu" class="page-sidebar-menu '.(isset($currentTheme['sidebar']) && $currentTheme['sidebar'] == 'fixed' ? 'page-sidebar-menu-fixed' : 'page-sidebar-menu-default').'" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">')
			<li class="sidebar-toggler-wrapper">
				<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				<div class="sidebar-toggler">
				</div>
				<!-- END SIDEBAR TOGGLER BUTTON -->
			</li>
			{{ $sideMenu or '' }}
		</ul>
		<!-- END SIDEBAR MENU -->
	</div>
</div>
<!-- END SIDEBAR -->