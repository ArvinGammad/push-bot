@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row mt-3">
		<div class="col-lg-12">
			
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