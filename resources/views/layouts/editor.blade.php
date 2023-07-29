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

		<link rel="stylesheet" type="text/css" href="{{asset('ui/assets/css/styles.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}?v={{strtotime(date('Y-m-d H:i:s'))}}" />
		<!-- Scripts -->

		@stack('css')
	</head>
	<body>
		<div>
			<div class="page-wrapper" id="main-wrapper">
				<div class="mb-3">
					@include('layouts/components/header')
				</div>
				
				@yield('content')
			</div>
		</div>

		<script src="{{asset('ui/assets/libs/jquery/dist/jquery.min.js')}}"></script>
		<script src="{{asset('ui/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
		<script src="{{asset('ui/assets/js/sidebarmenu.js')}}"></script>
		<script src="{{asset('ui/assets/js/app.min.js')}}"></script>
		<script src="{{asset('ui/assets/libs/simplebar/dist/simplebar.js')}}"></script>
		@stack('js')
	</body>
</html>