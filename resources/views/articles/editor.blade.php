@extends('layouts.editor')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4">
			<div class="card">
				<div class="card-body text-center">
					<span class="rounded-3 articles-icon"><i class="ti ti-writing"></i></span>
					<h2>Article Editor</h2>
					<span class="h5">Create Article From Scrath</span>
				</div>
				<div class="card-footer text-center">
					<a href="{{route('article.editor')}}" class="btn btn-danger rounded-3 w-100">Launch</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('css')
<style type="text/css">
	.articles-icon{
		font-size:70px;
	}
</style>
@endpush

@push('js')
@endpush