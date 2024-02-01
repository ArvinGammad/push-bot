@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-lg-12">
			<div class="row">
				@php
					$bg_header_array = ['bg-primary','bg-danger','bg-warning','bg-secondary','bg-success'];
					$i=0;
				@endphp
				@foreach($templates as $key => $template)
				<div class="col-md-6 col-lg-4 col-sm-12 mb-4">
					<div class="card h-100">
						@if($i != 4)
							@php
								$i++;
							@endphp
						@else
							@php
								$i=0
							@endphp
						@endif
						<div class="card-header {{$bg_header_array[$i]}} text-white text-center">
							<img src="{{$template->icon}}" style="width: 10%; margin-right: 10px;">
							<span><b>{{$template->name}}</b></span>
						</div>
						<div class="card-body " style="padding: 5px 30px;">
							<p class="h4 text-center" style="display: flex; align-items: center; height: 100%;">{{substr($template->description, 0, 50) . '...'}}</p>
						</div>
						<div class="card-footer text-center"><a class="btn btn-primary btn-sm m-auto" href="/template/editor/{{$template->slug}}"><i class="ti ti-writing-sign"></i> Use Template</a></div>
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