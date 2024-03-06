@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 m-auto text-center">
			<img src="{{asset('image/pushbot-maintenance.png')}}" width="350" alt="" />
			<h2>Sorry this page is currently not available.</h2>
			<h5>We will notify you once we done with this integration.</h5>
		</div>
	</div>
</div>
@endsection
@push('css')
@endpush

@push('js')
@endpush