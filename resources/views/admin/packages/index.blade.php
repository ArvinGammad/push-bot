@extends('layouts.auth')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="margin-top: 100px;">
				<div class="card-header">
					<a class="btn btn-sm btn-primary" href="/admin/packages/create">+ Create Package</a>
				</div>
				<div class="card-body">
					<table id="table-package" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Validity</th>
								<th>Users Subscribed</th>
								<th>Status</th>
								<th></th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
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