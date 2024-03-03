<aside class="left-sidebar">
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
			<ul id="sidebarnav">
				<li class="nav-small-cap">
					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
					<span class="hide-menu">Home</span>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{route('member.dashboard')}}" aria-expanded="false">
						<span>
							<i class="ti ti-layout-dashboard"></i>
						</span>
						<span class="hide-menu">Dashboard</span>
					</a>
				</li>
				<!-- <li class="nav-small-cap">
					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
					<span class="hide-menu">ADMIN</span>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{route('admin.templates')}}" aria-expanded="false">
						<span>
							<i class="ti ti-clipboard-data"></i>
						</span>
						<span class="hide-menu">Create Templates</span>
					</a>
				</li> -->
				<li class="nav-small-cap">
					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
					<span class="hide-menu">Tools</span>
				</li>
				@php
					$article_array = [
						route('article.index'),
						route('article.keywords'),
						route('article.title')
					]
				@endphp
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-article"></i>
						</span>
						<span class="hide-menu">Article Creator</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(request()->fullUrl() == 'template.list') active @endif" href="{{route('template.list')}}" aria-expanded="false">
						<span>
							<i class="ti ti-clipboard-data"></i>
						</span>
						<span class="hide-menu">Templates</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(request()->fullUrl() == 'image.editor') active @endif" href="{{route('image.editor')}}" aria-expanded="false">
						<span>
							<i class="ti ti-palette"></i>
						</span>
						<span class="hide-menu">Image Editor</span>
					</a>
				</li>
				<li class="nav-small-cap">
					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
					<span class="hide-menu">Integrations</span>
				</li>
				@php
					$wp_array = [
						route('wp.index'),
					]
				@endphp
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $wp_array)) active @endif" href="{{route('wp.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-brand-wordpress"></i>
						</span>
						<span class="hide-menu">WordPress</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-brand-shopee"></i>
						</span>
						<span class="hide-menu">Shopify</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-brand-wix"></i>
						</span>
						<span class="hide-menu">Wix</span>
					</a>
				</li>
				<li class="nav-small-cap">
					<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
					<span class="hide-menu">Facecbook</span>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-brand-facebook"></i>
						</span>
						<span class="hide-menu">Account Manger</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-settings-automation"></i>
						</span>
						<span class="hide-menu">Facebook Automation</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link @if(in_array(request()->fullUrl(), $article_array)) active @endif" href="{{route('article.index')}}" aria-expanded="false">
						<span>
							<i class="ti ti-message-chatbot"></i>
						</span>
						<span class="hide-menu">Facebook Chat Bot</span>
					</a>
				</li>
			</ul>
			<div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">
				<div class="d-flex">
					<div class="unlimited-access-title me-3">
						<h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Upgrade Account</h6>
						<a href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Plan</a>
					</div>
					<div class="unlimited-access-img">
						<img src="{{asset('ui/assets/images/backgrounds/rocket.png')}}" alt="" class="img-fluid">
					</div>
				</div>
			</div>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>