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
					<div class="table-responsive">
						<table id="table-package" class="table table-striped" style="width: 100%">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Validity</th>
									<th>Price</th>
									<th>Status</th>
									<th class="text-center"></th>
								</tr>
							</thead>
						</table>
					</div>
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

	$(document).ready(function() {
		table_package.DataTable({
			"ajax": "/admin/packages/get-data",
			"lengthChange": false,
			"pageLength": 10,
			"columns": [
				{ 
					"data": null, 
					"className": "dt-center" // Center the incrementing number
				},
				{ "data": "name" },
				{ "data": "validity" },
				{ "data": "price" },
				{ "data": "status" },
				{ 
					"data": null,
					"className": "dt-center",
					"render": function (data, type, row) {
						var html = '';

						html += '<div class="btn-group text-center">';
						html += '<button class="btn btn-sm btn-warning btn-edit" data-id="' + row.id + '">Edit</button>';
						html += '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.id + '">Delete</button>';
						html += '</div>';
						return html;
					}
				}
			],
			"rowCallback": function(row, data, index) {
				// Increment the counter and assign it to the first column
				$('td:eq(0)', row).html(counter + 1);
				counter++;
			},
			"drawCallback": function() {
				// Reset the counter on every draw
				counter = 0;
			}
		});
	});
</script>
@endpush