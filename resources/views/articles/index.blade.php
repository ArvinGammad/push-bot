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
					<a href="javascript:void(0)" id="create-article" class="btn btn-danger rounded-3 w-100">Launch</a>
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
					<a href="" class="btn btn-danger rounded-3 w-100">Launch</a>
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
					<a href="" class="btn btn-danger rounded-3 w-100">Launch</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-3">
		<div class="col-lg-12 mb-3">
			<hr>
			<h4><i class="ti ti-history-toggle"></i> <span class="ms-2">Recent Created</span></h4>
		</div>
		<div class="col-lg-12">
			@foreach ($articles as $key => $value)
				<div class="card  bg-danger mb-3">
					<div class="card-body p-3 d-flex">
						<div class="article-detail text-white">
							<h4 class="mt-auto mb-auto text-white">{{$value->title}}</h4>
							<small>{{$value->created_at}}</small>
						</div>
						
						<a href="/article/editor/{{$value->id}}" data-toggle="tooltip" title="Edit Article" class="ms-auto mt-auto mb-auto h4 text-white"><i class="ti ti-edit"></i></a>
						<a href="javascript:void(0)" data-id="{{$value->id}}" class="ms-2 mt-auto mb-auto h4 text-white delete-article" data-toggle="tooltip" title="Delete Article"><i class="ti ti-trash"></i></a>
						<a href="javascript:void(0)" data-id="{{$value->id}}" class="ms-2 mt-auto mb-auto h4 text-white export-article" data-toggle="tooltip" title="Export Article"><i class="ti ti-file-export"></i></a>
					</div>
				</div>
			@endforeach
			
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
<script src="{{asset('js/articles-index.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endpush