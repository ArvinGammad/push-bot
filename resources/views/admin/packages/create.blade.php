@extends('layouts.auth')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<form id="form-create-package">
				@csrf
				<div class="card" style="margin-top: 100px;">
					<div class="card-header">
						<h5>Create new package</h5>
					</div>
					<div class="card-body">
						
							<div class="row">
								<div class="col-lg-4 form-group">
									<label for="package-name" class="h6">Name</label>
									<input type="text" name="package_name" id="package_name" required class="form-control">
								</div>
								<div class="col-lg-4 form-group">
									<label for="package_validity" class="h6">Validity</label>
									<select class="form-control" name="package_validity" id="package_validity" required>
										<option value="monthly">Monthly</option>
										<option value="yearly">Yearly</option>
									</select>
								</div>
								<div class="col-lg-4 form-group">
									<label for="package-name" class="h6">Price</label>
									<input type="number" name="package_price" id="package_price" required class="form-control" step="0.01">
								</div>
								<div class="col-lg-12 form-group mt-3">
									<label for="package_description" class="h6">Description</label>
									<textarea class="form-control" id="package_description" name="package_description"></textarea>
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package_credit" class="h6">Credits</label>
									<input type="number" name="package_credit" id="package_credit" required class="form-control">
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package_seo" class="h6">SEO Tokens</label>
									<input type="number" name="package_seo" id="package_seo" required class="form-control">
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package_image" class="h6">Image Tokens</label>
									<input type="number" name="package_image" id="package_image" required class="form-control">
								</div>
								<div class="col-lg-12">
									<hr>
								</div>
								<div class="col-lg-12">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th></th>
												<th style="width: 70%;">Name</th>
												<th class="text-center">Unlimited?</th>
												<th>Limit</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td><input type="checkbox" name="package_wordpress_addon" id="package_wordpress_unlimited" value='1' ></td>
												<td>WordPress Account</td>
												<td class="text-center"><input type="checkbox" name="package_wordpress_unlimited" id="package_wordpress_unlimited" value='1' ></td>
												<td><input type="number" name="package_wordpress_limit" id="package_wordpress_limit" value='0' class="form-control"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						
					</div>
					<div class="card-footer">
						<button type="submit" class="btn btn-success btn-save"><i class="ti ti-device-floppy"></i> Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#form-create-package").on('submit',function(e){
			e.preventDefault();
			var form_data = $(this).serialize();
			$.ajax({
				url: '/admin/packages/create/submit',
				method: 'POST',
				data:form_data,
				beforeSend: function(data){
					$('.btn-save').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Saving');
					$('.btn-save').attr('disabled',true);
				},
				success: function(data){
					$('.btn-save').html('Save');
					$('.btn-save').attr('disabled',false);

					location.replace('/admin/packages');
					
				},
				error: function(xhr, status, error){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: error,
					});
					$('.btn-save').html('Save');
					$('.btn-save').attr('disabled',false);
				}
			});
		})
	});
</script>
@endpush