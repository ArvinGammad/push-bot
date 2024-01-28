@extends('layouts.auth')

@section('content')
<div class="container-fluid pe-5 ps-5 w-100" style="max-width: 100%;">
	<div class="row mt-3">
		<div class="col-lg-5">
			<div class="card">
				<div class="card-header"><span><b>Template Inputs</b></span></div>
				<div class="card-body">
					<div class="row">
						@foreach ($template_inputs as $key => $input)
							<div class='col-lg-12 form-group mb-3'>
								@if($input->type == 'text')
									<label>{{$input->label}}</label>
									<input type='{{$input->type}}' name='{{$input->name}}' placeholder='' class='form-control' required>
								@elseif($input->type == 'textarea')
									<label>{{$input->label}}</label>
									<textarea name='{{$input->name}}' class="form-control" placeholder=''></textarea>
								@endif
							</div>
						@endforeach
					</div>
				</div>
				<div class="card-footer"></div>
			</div>
		</div>
		<div class="col-lg-7">
			<div class="card">
				<div class="card-header"><span><b>Template Outputs</b></span></div>
				<div class="card-body"></div>
				<div class="card-footer"></div>
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
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
@endpush