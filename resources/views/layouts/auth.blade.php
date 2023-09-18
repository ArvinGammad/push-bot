<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="//fonts.bunny.net">
		<link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

		<link rel="stylesheet" type="text/css" href="{{asset('sweetalert/sweetalert2.min.css')}}?v={{strtotime(date('Y-m-d h:i:s'))}}">

		<link rel="stylesheet" type="text/css" href="{{asset('ui/assets/css/styles.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<!-- Scripts -->

		<!-- <style type="text/css">
			.scroll-sidebar::-webkit-scrollbar-track
			{

			}

			.scroll-sidebar::-webkit-scrollbar
			{
				width: 10px;
				background-color: #F5F5F5;
			}

			.scroll-sidebar::-webkit-scrollbar-thumb
			{
				background-color: #dfdfdf;
			}
		</style> -->

		@stack('css')
	</head>
	<body>
		<div id="app">
			<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"data-sidebar-position="fixed" data-header-position="fixed">


				@include('layouts/components/sidebar')

				<div class="body-wrapper">
					@include('layouts/components/header')
					@yield('content')
				</div>
			</div>
		</div>

		<script src="{{asset('ui/assets/libs/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('ui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>

		<script src="{{asset('sweetalert/sweetalert2.min.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>
		
		<script src="{{asset('ui/assets/js/sidebarmenu.js')}}"></script>
		<script src="{{asset('ui/assets/libs/simplebar/dist/simplebar.js')}}"></script>
		@stack('js')
	</body>
</html>