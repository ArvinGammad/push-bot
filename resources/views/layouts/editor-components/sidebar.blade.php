<aside class="left-sidebar" style="">
	<!-- Sidebar scroll-->
	<div>
		<div class="brand-logo d-flex align-items-center justify-content-between">
			<a href="./index.html" class="text-nowrap logo-img">
				<img src="{{asset('ui/assets/images/logos/dark-logo.svg')}}" width="180" alt="" />
			</a>
			<div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
				<i class="ti ti-x fs-8"></i>
			</div>
			
		</div>
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
			<div class="row mt-3">
				<div class="col-lg-12 form-group mb-3">
					<a href="/article" class="btn btn-danger me-2 w-100"><i class="ti ti-arrow-back-up"></i> Exit Editor</a>
				</div>
			</div>
			<hr>
			<div id="editor-modes">
				@include('layouts/editor-components/focus-mode')
			</div>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>