@extends('layouts.auth')

@section('content')
<div class="container-fluid pe-5 ps-5 w-100" style="max-width: 100%;">
	<div class="row mt-3">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-10">
					<h3>{{$template->name}}</h3>
					<h6>{{$template->description}}</h6>
				</div>
				<div class="col-lg-2 " style="align-items: center; display: inline-flex;">
					<a href="/templates" class="ms-auto btn btn-sm btn-warning"><i class="fa-solid fa-arrow-left-long"></i> Change Template</a>
				</div>
			</div>
			<hr>
		</div>
		<div class="col-lg-5" id="div-template" style="height: 500px;">
			<form method="POST" id="form-template-generate" style="height: 100%;">
				@csrf
				<div class="card" style="height: 100%;">
					<div class="card-header bg-danger text-white"><span><b>Your Input</b></span></div>
					<div class="card-body">
						<div class="row">
							<input type="hidden" name="slug" id="template_slug" value="{{$template->slug}}">
							@foreach ($template_inputs as $key => $input)
								<div class='col-lg-12 form-group mb-2'>
									@if($input->type == 'text')
										<label>{{$input->label}}</label>
										<input type='{{$input->type}}' name='{{$input->name}}' placeholder='' class='form-control' required>
									@elseif($input->type == 'textarea')
										<label>{{$input->label}}</label>
										<textarea name='{{$input->name}}' class="form-control" placeholder=''></textarea>
									@endif
								</div>
							@endforeach
							<div class='col-lg-6 form-group'>
								<label>Tone of Voice</label>
								<select class="form-control tone" required="required" name="tone">
									<option value="professional">Professional</option><option value="friendly">Friendly</option><option value="witty">Witty</option><option value="persuasive">Persuasive</option><option value="dramatic">Dramatic</option><option value="funny">Funny</option><option value="excited">Excited</option>
								</select>
							</div>
						</div>
					</div>
					<div class="card-footer w-100">
						<button class="btn btn-primary" id="btn-generate">Generate Output</button>
						<button type="button" class="btn btn-warning float-end" id="btn-clear">Clear Input</button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-lg-7" style="height: 500px;">
			<div class="card h-100">
				<div class="card-header bg-success text-white"><span><b>Generated Output</b></span></div>
				<div class="card-body scroll-sidebar" style="overflow-y: auto;">
					<div></div>
					<p id="generated-output" style="font-size: 16px; text-align: justify;"></p>
				</div>
				<div class="card-footer"></div>
			</div>
		</div>
		<div class="col-lg-12 mt-3">
			<div class="card">
				<div class="card-header">
					<span><b>Generated Content History</b></span>
				</div>
				<div class="card-body">
					<table class="table table-striped" id="table-history">
						<thead>
							<tr>
								<th>#</th>
								<th>Output</th>
								<th class="text-center">Token Charge</th>
								<th>Date Generaed</th>
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
<style type="text/css">
	.articles-icon{
		font-size:70px;
	}
	.card{
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}

	.typing-container {
		padding: 20px;
		font-family: Arial, sans-serif;
		font-size: 24px;
		border: 2px solid #333;
		width: 400px;
		margin: 50px auto;
	}

	#typing-text {
		border-right: 2px solid #333;
		white-space: nowrap;
		overflow: hidden;
		margin: 0;
		padding: 0;
		display: inline-block;
		vertical-align: top;
		animation: typing 2s steps(40, end);
	}

	@keyframes typing {
		from {
			width: 0;
		}
		to {
			width: 100%;
		}
	}
	.dataTables_filter{
		float: left;
		text-align: left;
		margin-left: 10px
	}

	.tooltip-inner {
		max-width: 500px; /* Adjust the width as needed */
		text-align: justify;
	}
	.paginate_button{
		border: 1px solid #fa896b;
		color: #fa896b;
		padding: 5px 10px;
		border-radius: 100%;
		margin: 1px;
	}
	.paginate_button.current{
		background: #fa896b;
		color: white;
	}

	.paginate_button:hover{
		background: #fa896b;
		color: white;
	}
	
</style>
@endpush

@push('js')
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>

<script type="text/javascript">

	let index = 0;
	const speed = 5; // typing speed in milliseconds

	let table_template_history = $('#table-history');


	table_template_history.DataTable({
		"ajax": {
			"url": "/templates/editor/history/get",
			"data": { "slug": $("#template_slug").val() }
		},
		"language": {
			"paginate": {
				"previous": "<i class='fas fa-chevron-left'></i>",
				"next": "<i class='fas fa-chevron-right'></i>"
			}
		},
		"pageLength": 5,
		"columnDefs": [
			{ "className": "text-center", "targets": 2 },
			{ "className": "text-center", "targets": 4 }
		],
		"lengthChange": false,
		"columns": [
			{
				"targets": 0, // First column
				"render": function (data, type, row, meta) {
					return meta.row + 1; // Add 1 to row index for numbering
				}
			},
			{ 
				"data": "output",
				"render": function(data, type, row) {
					if (data) {
						if (data.length > 30) {
							$('[data-toggle="tooltip"]').tooltip({
								html: true
							});

							var data_text = data.replaceAll("'","&#39;");
							var data_text = data_text.replaceAll("\n","<br>");

							return "<span class='tooltip-span' data-toggle='tooltip' data-html='true' data-placement='top' title='"+data_text+"'>"+data.substr(0, 70) + '...'+"</span>";;
						} else {
							return data;
						}
					} else {
						return '';
					}
				}
			},
			{ "data": "charge" },
			{ "data": "created_at" },
			{ 
				"data": null,
				"orderable": false,
				"render": function(data, type, row) {
					$('[data-toggle="tooltip"]').tooltip({
						html: true
					});
					return `<div class="btn-group">
						<button class="btn btn-info btn-template-view" data-toggle='tooltip' data-html='true' data-placement='top' title='View generated output' data-id="`+data.id+`"><i class="fa-solid fa-eye"></i></button>
					</div>`;
				}
			}
		]
	});

	$(function () {

		$('.dataTables_filter input').addClass('form-control');
		$("#form-template-generate").on('submit',function(e){
			e.preventDefault();
			var form_data = $("#form-template-generate").serialize();

			$.ajax({
				url: '/admin/templates/generate',
				method: 'POST',
				data:form_data,
				beforeSend: function(data){
					$('#btn-generate').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Generating');
					$('#btn-generate').attr('disabled',true);
				},
				success: function(data){
					$('#generated-output').html('');
					typeWriter(data.response,0);
					$('#btn-generate').html('Generate Output');
					$('#btn-generate').attr('disabled',false);

					table_template_history.DataTable().ajax.reload();
					
				},
				error: function(xhr, status, error){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: error,
					});
					$('#btn-generate').html('Generate Output');
					$('#btn-generate').attr('disabled',false);
				}
			});
		});

		$("#btn-clear").on('click',function(){
			$("#form-template-generate")[0].reset();
		});

		$(document).on("click",".btn-template-view", function(e){
			var data_id = $(this).attr("data-id");

			$.ajax({
				url: '/get/templates/generated/'+data_id,
				method: 'GET',
				success: function(data){
					var output = data.output.replaceAll("\n","<br>");
					var inputs = Object.values(data.input);
					document.getElementById("generated-output").innerHTML = output;
					var i = 0;
					$("#form-template-generate .col-lg-12 input, #form-template-generate .col-lg-12 select, #form-template-generate .col-lg-12 textarea").each(function(){
						$(this).val(inputs[i]);
						i++;
					});

					$('html, body').animate({
						scrollTop: $('body').offset().top
					}, 100);
				},
				error: function(xhr, status, error){
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: error,
					});
				}
			});
		});
	});

	

	function typeWriter(text, index = 0) {
		if (index < text.length) {
			if (text.charAt(index) === '\n') {
				document.getElementById("generated-output").innerHTML += '<br>';
			}else{
				document.getElementById("generated-output").innerHTML += text.charAt(index);
			}

			index++;
			setTimeout(() => {
				typeWriter(text, index);
			}, speed);
		}
	}
</script>
@endpush