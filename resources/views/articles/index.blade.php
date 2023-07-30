@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body text-center">
					<span class="rounded-3 articles-icon"><i class="ti ti-writing"></i></span>
					<h3><b>Article Editor</b></h3>
					<span class="h5">Create Article From Scrath</span>
				</div>
				<div class="card-footer text-center">
					<a href="{{route('article.editor')}}" class="btn btn-danger rounded-3 w-100">Launch</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body text-center">
					<span class="rounded-3 articles-icon"><i class="ti ti-list-search"></i></span>
					<h3><b>Article Keywords</b></h3>
					<span class="h5">Create Article Using Keywords</span>
				</div>
				<div class="card-footer text-center">
					<a href="{{route('article.editor')}}" class="btn btn-danger rounded-3 w-100">Launch</a>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body text-center">
					<span class="rounded-3 articles-icon"><i class="ti ti-heading"></i></span>
					<h3><b>Article Title</b></h3>
					<span class="h5">Create Article Using Title</span>
				</div>
				<div class="card-footer text-center">
					<a href="{{route('article.editor')}}" class="btn btn-danger rounded-3 w-100">Launch</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-lg-12">
			<hr>
			<h4><i class="ti ti-history-toggle"></i> <span class="ms-2">Recent Created</span></h4>
		</div>
	</div>
</div>
@endsection
@push('css')
<style type="text/css">
	.articles-icon{
		font-size:70px;
	}
	.card{
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}
</style>
@endpush

@push('js')
@endpush