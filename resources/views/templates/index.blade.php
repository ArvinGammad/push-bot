@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-lg-12">
			<div class="row">
				@foreach($templates as $key => $template)
				<div class="col-md-6 col-lg-4 col-sm-12 mb-4">
					<div class="card h-100">
						<div class="card-header bg-danger text-white"><span><b>{{$template->name}}</b></span></div>
						<div class="card-body " style="padding: 5px 30px;">
							<p>{{substr($template->description, 0, 100) . '...'}}</p>
							<a class="btn btn-primary btn-sm mt-auto" href="/template/editor/{{$template->slug}}"><i class="ti ti-writing-sign"></i> Use Template</a>
						</div>
					</div>
				</div>
				@endforeach
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