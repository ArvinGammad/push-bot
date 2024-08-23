@extends('layouts.subscription')

@section('content')
<div class="m-5">
	<div class="row">
		@foreach($packages as $key =>$pack)
		<div class="col-lg-4">
			<div class="card">
				<div class="card-header d-flex text-center">
					<h3 class="price-tag ms-auto">${{$pack->price}}</h3><small class="ms-2 me-auto" style="font-size: 15px">/ {{$pack->validity}}</small>
				</div>
				<div class="card-body text-center">
					
					<h2>{{$pack->name}}</h2>
					<span>{{$pack->description}}</span>
					<br>
					<br>
					<p><b>Text Generation Tokens</b>: {{$pack->credit}}</p>
					<p><b>Image Generation Tokens</b>: {{$pack->image}}</p>
					<p><b>SEO Generation Tokens</b>: {{$pack->seo}}</p>
					<hr>
					<h5 class="mb-3">Including</h5>
					@php
						$addons = json_decode($pack->limit);
					@endphp
					@foreach($addons as $key => $addon)
						<tr>
							<td><b>{{strtoupper($key)}}: </b></td>
							<td>{{$addon}}</td>
						</tr>
					@endforeach
					
				</div>
				<div class="card-footer text-center">
					<a href="#" class="btn btn-primary w-50"><i class="fa-solid fa-cart-plus me-2"></i> Buy Now</a>
				</div>
			</div>
		</div>
		@endforeach
	</div>
</div>
@endsection

@push('css')
<style type="text/css">
	.price-tag{
		color: tomato;
	}
	.card{
		border-radius: 10px;
	}
</style>
@endpush

@push('js')
@endpush