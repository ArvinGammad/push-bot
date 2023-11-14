@extends('layouts.auth')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="card" style="margin-top: 100px;">
				<div class="card-header">
					<button class="btn btn-sm btn-primary">+ Create Template</button>
				</div>
				<div class="card-body">
					<table id="table-templates" class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Status</th>
								<th>Action</th>
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
<script src="{{asset('js/admin-templates.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	let table_template = $('#table-templates');

	$(document).ready(function() {
		table_template.DataTable({
			"ajax": "/admin/templates/get",
			"columns": [
				{ "data": "id" },
				{ "data": "name" },
				{ "data": "status" },
				{ "data": "settings" }
			]
		});
	});
</script>
@endpush