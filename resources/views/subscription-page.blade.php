@extends('layouts.subscription')

@section('content')
<div class="m-5">
	<div class="row">
		@foreach($packages as $key =>$pack)
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body text-center">
					<h4 class="price-tag">${{$pack->price}}</h4>
					<hr>
					<h2>{{$pack->name}}</h2>
					<span>{{$pack->description}}</span>
					<br>
					<br>
					<p><b>Text Generation Tokens</b>: {{$pack->credit}}</p>
					<p><b>Image Generation Tokens</b>: {{$pack->image}}</p>
					<p><b>SEO Generation Tokens</b>: {{$pack->seo}}</p>
					<hr>
					<h5>Including</h5>
					<hr>
					<a href="#" class="btn btn-primary">Buy Now</a>
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
		border-radius: 30px;
	}
</style>
@endpush

@push('js')
@endpush