@extends('layouts.auth')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-lg-12 mb-3" style="margin-top: 100px;">
			<a class="btn btn-sm btn-success btn-template-save" href="javascript:void(0)">Save Changes</a>
		</div>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4>Create Template</h4>
				</div>
				<div class="card-body">
					<form id="form-template">
						<div class="row">
							<div class="col-lg-12 mb-3">
								<label for="template_name">Template Name</label>
								<input type="text" name="template_name" id="template_name" class="form-control" placeholder="Enter Template Name...">
							</div>
							<div class="col-lg-12">
								<label for="template_description">Template Description</label>
								<textarea name="template_description" id="template_description" class="form-control" rows='5'></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4>Template Inputs</h4>
				</div>
				<div class="card-body">
					<form id="form-template">
						<a class="btn btn-sm btn-primary" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal-template-input">+ Add New Input</a>
						<hr>
						<div class="row">
							<div class="col-lg-12 mb-3 template-inputs-container">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<a class="btn btn-sm btn-success btn-template-save" href="javascript:void(0)">Save Changes</a>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-template-input" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Input Details</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-6 form-group mb-3">
						<label for="template-input-label">Input Label</label>
						<input type="text" name="template-input-label" class="form-control" id="template-input-label">
					</div>
					<div class="col-lg-6 form-group mb-3">
						<label for="template-input-id">Input ID</label>
						<input type="text" name="template-input-id" class="form-control" id="template-input-id">
					</div>
					<div class="col-lg-12 form-group mb-3">
						<label for="template-input-type">Input Type</label>
						<select class="form-control" id="template-input-type" name="template-input-type">
							<option value="text">Text</option>
							<option value="select">Select</option>
							<option value="textarea">Textarea</option>
						</select>
					</div>
					<div class="col-lg-12 input-type-select">
						<hr>
						<div class="row">
							<div class="col-lg-6 form-group">
								<label for="template-input-select-option-value">Value</label>
								<input type="text" name="template-input-select-option-value[]" class="form-control template-input-select-option-value">
							</div>
							<div class="col-lg-6 form-group">
								<label for="template-input-select-option-text">Text</label>
								<input type="text" name="template-input-select-option-text[]" class="form-control template-input-select-option-text">
							</div>
						</div>
						<a class="btn btn-sm btn-primary btn-input-type-select mt-3 mb-3" href="javascript:void(0)" >+ Add More Option</a>
						<hr>
					</div>
					<div class="col-lg-6 form-group mb-3">
						<label for="template-input-placeholder">Input Placeholder</label>
						<textarea name="template-input-placeholder" class="form-control" id="template-input-placeholder"></textarea>
					</div>
					<div class="col-lg-6 form-group mb-3">
						<label for="template-input-help">Input Help Text</label>
						<textarea name="template-input-help" class="form-control" id="template-input-help"></textarea>
					</div>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-input-save">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
	let data_id = 0;
	let input_data = [];
	$(document).ready(function(){
		$(".btn-input-type-select").on('click',function(){
			var html = "";
			html += '<div class="col-lg-5 form-group mt-3" data-id="'+data_id+'">';
				html += '<label for="template-input-select-option-value">Value</label>';
				html += '<input type="text" name="template-input-select-option-value[]" class="form-control template-input-select-option-value">';
			html += '</div>';
			html += '<div class="col-lg-5 form-group mt-3" data-id="'+data_id+'">';
				html += '<label for="template-input-select-option-text">Text</label>';
				html += '<input type="text" name="template-input-select-option-text[]" class="form-control template-input-select-option-text">';
			html += '</div>';
			html += '<div class="col-lg-2 form-group mt-auto" data-id="'+data_id+'">';
				html += '<button class="btn btn-danger  ms-auto btn-input-select-option-remove" data-id="'+data_id+'">Remove</button>';
			html += '</div>';

			data_id++;

			$(".input-type-select .row").append(html);
		});

		$(document).on('click','.btn-input-select-option-remove', function(){
			var select_data_id = $(this).attr('data-id');

			$('[data-id="'+select_data_id+'"]').remove();
		});

		$("#template-input-label").on('keyup',function(){
			var input_label_value = $(this).val();
			input_label_value = input_label_value.replace(/ /g, '_').toLowerCase();;

			$("#template-input-id").val(input_label_value);
		});

		$(".btn-input-save").on('click',function(){
			var template_input_label = $("#template-input-label").val();
			var template_input_id = $("#template-input-id").val();
			var template_input_type = $("#template-input-type").val();
			var template_input_placeholder = $("#template-input-placeholder").val();
			var template_input_help = $("#template-input-help").val();

			

			if(template_input_type == "select"){
				var template_select_option = [];
				var input_option_count = 0;
				var template_select_option_value = "";
				$(".input-type-select input").each(function(){
					if(input_option_count == 1){
						template_select_option.push({
							'value': template_select_option_value,
							'text': $(this).val()
						});

						template_select_option_value = "";
						input_option_count=0;
					}else{
						template_select_option_value = $(this).val();
						input_option_count++;
					}
				});

				input_data.push({
					'template_input_label': template_input_label,
					'template_input_id': template_input_id,
					'template_input_label': template_input_label,
					'template_input_type': template_input_type,
					'template_input_placeholder': template_input_placeholder,
					'template_select_option': template_select_option
				});

			}else{
				input_data.push({
					'template_input_label': template_input_label,
					'template_input_id': template_input_id,
					'template_input_label': template_input_label,
					'template_input_type': template_input_type,
					'template_input_placeholder': template_input_placeholder,
				});
			}

			var lastIndex = input_data.length - 1;

			var html = `<div class="card bg-danger mb-3" data-input-id='`+lastIndex+`'>
							<div class="card-body p-3 d-flex">
								<div class="article-detail text-white">
									<h4 class="mt-auto mb-auto text-white">`+template_input_label+`</h4>
									<small>`+template_input_help+`</small>
								</div>
								
								<a href="javascript:void(0)" data-id="" data-input-id='`+lastIndex+`' class="ms-auto mt-auto mb-auto h4 text-white delete-temple-input"><i class="ti ti-trash"></i></a>
							</div>
						</div>`;

			$(".template-inputs-container").append(html);
			$("#modal-template-input").modal('hide');

		});

		$(document).on('click','.delete-temple-input', function(){
			var data_input_id = $(this).attr('data-input-id');
			input_data.splice(data_input_id, 1);

			console.log(input_data);

			$('[data-input-id="'+data_input_id+'"]').remove();
		})
	});
</script>
@endpush