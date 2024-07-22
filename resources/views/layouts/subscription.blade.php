<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="height: 100%;">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

		<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="{{asset('ui/assets/css/styles.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<link href="{{asset('/fontawesome/css/all.min.css')}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('css/editor.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<!-- Scripts -->

		@stack('css')
	</head>
	<body style="height: 100%;">
		<div style="height: 100%;">
			<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" style="height: 100%;">
				<header class="app-header">
					<nav class="navbar navbar-expand-lg navbar-light">
						<ul class="navbar-nav w-100">
							<li class="nav-item d-block d-xl-none">
								<a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
									<i class="ti ti-menu-2"></i>
								</a>
							</li>
							<li class="nav-item">
								<a href="/dashboard" class="btn  me-2 w-100">Dashboard</a>
							</li>
						</ul>
						<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
							<ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
								
								<li class="nav-item dropdown">
									<a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
										<img src="{{asset('ui/assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
									</a>
									<div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
										<div class="message-body">
											<a href="/profile" class="d-flex align-items-center gap-2 dropdown-item">
												<i class="fa-solid fa-user fs-6 me-2"></i>
												<p class="mb-0 fs-3">My Profile</p>
											</a>
											<a href="/usage" class="d-flex align-items-center gap-2 dropdown-item">
												<i class="fa-solid fa-chart-simple fs-6 me-2"></i>
												<p class="mb-0 fs-3">My Usage</p>
											</a>
											<a href="javascript:void(0)" id="btn-logout" class="btn btn-outline-primary mx-3 mt-2 d-block"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</nav>
				</header>
				@yield('content')
			</div>

			<div class="toast-container position-absolute p-3 bottom-0 end-0">
				<div class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" aria-atomic="true" data-bs-autohide="true" data-bs-delay="3000">
					<div class="d-flex">
						<div class="toast-body" id="toast-text">
						</div>
						<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
					</div>
				</div>
			</div>
			
		</div>

		<script src="{{asset('ui/assets/libs/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('ui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="{{asset('ui/assets/js/sidebarmenu.js')}}"></script>
		<script src="{{asset('ui/assets/js/app.min.js')}}"></script>
		<script src="{{asset('ui/assets/libs/simplebar/dist/simplebar.js')}}"></script>
		<script src="{{asset('js/editor.js')}}"></script>

		@stack('js')
	</body>
</html>