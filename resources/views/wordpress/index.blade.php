@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		@if(count($wordpress) > 0)
			@foreach($wordpress as $key => $value)
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body d-flex">
							{{$value->site_title}}
						</div>
					</div>
				</div>
			@endforeach
		@else
		<div class="col-lg-12 m-auto text-center">
			<h3>Oops, sorry, you don't have any WordPress connected.</h3>
			<a href="/wp/connect" class="btn btn-primary btn -">Connect WordPress</a>
		</div>
		@endif
	</div>
</div>
@endsection
@push('css')
@endpush

@push('js')
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endpush