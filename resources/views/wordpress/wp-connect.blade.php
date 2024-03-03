@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8 m-auto mb-3">
			<a href="/wp/list" class="btn btn-sm btn-warning"><i class="fa-solid fa-arrow-left me-2"></i> Go back to WordPress list</a>
		</div>
		<div class="col-lg-8 m-auto">
			<form method="POST" id="form-wordpress-connect">
				@csrf
				<div class="card">
					<div class="card-header bg-danger">
						<h4 class="text-white"><i class="fa-brands fa-wordpress me-2"></i> WordPress Details</h4>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-lg-12 mb-3 form-group">
								<label for="wp_url"><i class="fa-solid fa-link me-2"></i>  WordPress URL</label>
								<input type="text" name="wp_url" id="wp_url" required placeholder="Enter your WordPress URL e.g. htts://example.com" class="form-control">
							</div>
							<div class="col-lg-6 mb-3 form-group">
								<label for="wp_username"><i class="fa-solid fa-circle-user me-2"></i> WordPress Username</label>
								<input type="text" name="wp_username" required id="wp_username" placeholder="Enter your username" class="form-control">
							</div>
							<div class="col-lg-6 mb-3 form-group">
								<label for="wp_password"><i class="fa-solid fa-key me-2"></i> WordPress App Password</label>
								<input type="password" name="wp_password" required id="wp_password" placeholder="Enter your app password" class="form-control">
							</div>
						</div>
					</div>
					<div class="card-footer text-end">
						<button type="submit" class="btn btn-primary" id="btn-wordpress-save">Check and Save WordPress</button>
					</div>
				</div>
			</form>
		</div>
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



	$(document).ready(function(){
		// $(document).on("click","#btn-wordpress-save", function(e) {

		// 	e.preventDefault();
		// 	$("#form-wordpress-connect").submit();
		// });

		$("#form-wordpress-connect").on('submit',function(e){
			e.preventDefault();

			var form_data = $(this).serialize();

			$.ajax({
				url: '/wp/save',
				method: 'POST',
				data: form_data,
				beforeSend: function(data){
					Swal.fire({
						text: 'Checking and Saving your WordPress credentials...',
						allowOutsideClick: false,
						didOpen: () => {
								Swal.showLoading();
						}
					});
				},
				success: function(data){
					Swal.close();
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Successfully Saved!',
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
		});
	});

	
</script>
@endpush