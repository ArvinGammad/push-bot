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
								<div class="col-lg-6 form-group">
									<label for="package-name" class="h6">Name</label>
									<input type="text" name="package-name" id="package-name" required class="form-control">
								</div>
								<div class="col-lg-6 form-group">
									<label for="package-validity" class="h6">Validity</label>
									<select class="form-control" name="package-validity" id="package-validity" required>
										<option value="monthly">Monthly</option>
										<option value="yearly">Yearly</option>
									</select>
								</div>
								<div class="col-lg-12 form-group mt-3">
									<label for="package-description" class="h6">Description</label>
									<textarea class="form-control" id="package-description" name="package-description"></textarea>
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package-credit" class="h6">Credits</label>
									<input type="number" name="package-credit" id="package-credit" required class="form-control">
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package-seo" class="h6">SEO Tokens</label>
									<input type="number" name="package-seo" id="package-seo" required class="form-control">
								</div>
								<div class="col-lg-4 form-group mt-2">
									<label for="package-image" class="h6">Image Tokens</label>
									<input type="number" name="package-image" id="package-image" required class="form-control">
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
												<td><input type="checkbox" name="package-wordpress-addon" id="package-wordpress-unlimited" value='1' ></td>
												<td>WordPress Account</td>
												<td class="text-center"><input type="checkbox" name="package-wordpress-unlimited" id="package-wordpress-unlimited" value='1' ></td>
												<td><input type="number" name="package-wordpress-limit" id="package-wordpress-limit" value='0' class="form-control"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						
					</div>
					<div class="card-footer">
						<button class="btn btn-success"><i class="ti ti-device-floppy"></i> Save</button>
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
	let table_package = $('#table-package');
</script>
@endpush