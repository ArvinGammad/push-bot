@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		@if(count($wordpress) > 0)
			<div class="col-lg-12 mb-3">
				<a href="/wp/connect" class="btn btn-success"><i class="fa-solid fa-plus me-1"></i> Connect WordPress</a>
			</div>
			@foreach($wordpress as $key => $value)

				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-lg-3">
									@if($value->site_logo == '')
									<img src="{{asset('image/WordPress_blue_logo.svg.png')}}"  style="width: 100%;">
									@else
									<img src="{{$value->site_logo}}"  style="width: 100%;">
									@endif
								</div>
								<div class="col-lg-9 m-auto">
									<h5>{{$value->site_title}}</h5>
									<a href="{{$value->url}}" target="_BLANK">{{$value->url}}</a>
								</div>
							</div>
						</div>
						<div class="card-footer text-start">
							<button class="btn btn-sm btn-danger" data-id="{{$value->id}}" id="btn-wp-delete">
								<i class="fa-solid fa-trash me-1"></i> Delete WordPress
							</button>
							<a href="/wp/edit/{{$value->id}}" class="btn btn-sm btn-warning float-end">
								<i class="fa-solid fa-pen me-1"></i> Edit WordPress
							</a>
						</div>
					</div>
				</div>
			@endforeach
		@else
		<div class="col-lg-12 m-auto text-center">
			<img src="{{asset('image/pushbot-error.png')}}" width="350" alt="" />
			<h3>Oops, sorry, you don't have any WordPress connected.</h3>
			<a href="/wp/connect" class="btn btn-primary">Connect WordPress</a>
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

		$(document).on('click','#btn-wp-delete',function(e){
			var wp_id = $(this).attr('data-id');
			$.ajax({
				url: '/wp/delete',
				method: 'DELETE',
				data:{wp_id: wp_id},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(data){
					Swal.fire({
					text: 'Please wait while we deleting your wordpress.',
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false,
					didOpen: () => {
						Swal.showLoading()
					}
				});
				},
				success: function(data){
					Swal.close();
					Swal.fire({
						title: 'Success!',
						text: 'Successfully Deleted!',
						icon: 'info',
						confirmButtonText: 'Ok',
					}).then((result) => {
						location.reload();
					});
				},
				error: function(xhr, status, error){
					Swal.close();
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: xhr.responseJSON.error,
					});
				}
			});
		})
	});
</script>
@endpush