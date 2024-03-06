@php
	use App\Models\Wordpress;
	$wordpress = Wordpress::select('*')->where('user_id',auth()->user()->id)->get();
@endphp

<form action="" type="POST" id="form-post-mode">
	@csrf
	<input type="hidden" name="article-id" id="article-id" value="{{@$article->id}}">
	<div class="row mt-3" id="">
		<div class="col-lg-12 form-group mb-3">
			<label for="wp_id">Select WordPress</label>
			<select class="form-control" name="wp_id" id="wp_id">
				<option selected="selected" disabled="disabled">--Select WordPress--</option>
				@foreach(@$wordpress as $key => $wp)
					<option value="{{$wp->id}}">{{$wp->url}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row" id="form-inputs">
	</div>
	<div class="row mt-3 d-none" id="loading-div">
		<div class="col-lg-12 text-center" id="spinner">
			<div class="spinner-border text-primary" role="status">
				<span class="sr-only">Loading...</span>
			</div>
			<br>
			<span>Getting Categories and Tags....</span>
		</div>
	</div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','#wp_id',function(e){
			var wp_id = $(this).val();

			$.ajax({
				url: '/wp/get-wp-detail',
				method: 'GET',
				data:{wp_id: wp_id},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(data){
					$("#loading-div").removeClass('d-none');
				},
				success: function(response){
					$("#loading-div").addClass('d-none');
					var categories = response.categories;
					var html = "";
					html += "<div class='col-lg-12 form-group mb-3'>";
						html += "<label>Post Categories</label>";
						html += "<select class='form-control select-input' name='wp_categories[]' id='wp_categories' multiple='multiple'>";
							categories.forEach(function(element) {
								html += "<option value='"+element['id']+"'>"+element['slug']+"</option>";
							});
						html += "</select>";
					html +="</div>";

					var tags = response.tags;
					html += "<div class='col-lg-12 form-group mb-3'>";
						html += "<label>Post Tags</label>";
						html += "<select class='form-control select-input' name='wp_tags[]' id='wp_tags' multiple='multiple'>";
							tags.forEach(function(element) {
								html += "<option value='"+element['id']+"'>"+element['slug']+"</option>";
							});
						html += "</select>";
					html +="</div>";

					html += "<div class='col-lg-12 form-group mb-3'>";
						html += "<label>Post Status</label>";
						html += "<select class='form-control select-input' name='wp_status' id='wp_status'>";
							html += "<option value='draft'>Draft</option>";
							html += "<option value='publish'>Publish</option>";
							html += "<option value='pending'>Pending Review</option>";
							html += "<option value='private'>Private</option>";
						html += "</select>";
					html +="</div>";
					html += "<div class='col-lg-12 form-group text-end mb-3'>";
					html += "<button type='submit' class='btn btn-danger btn-sm' id='btn-post-to-wordpress'><i class='fa-solid fa-paper-plane me-2'></i>Post to WordPress</button>";
					html +="</div>";

					$("#form-inputs").html(html);

					$('#wp_categories').select2();
					$('#wp_tags').select2();

				},
				error: function(xhr, status, error){
					$("#loading-div").addClass('d-none');
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: xhr.responseJSON.error,
					})
				}
			});
		});

		$(document).on('submit','#form-post-mode',function(e){
			e.preventDefault();
			var form_data = $("#form-post-mode").serialize();

			$.ajax({
				url: '/wp/wp-post',
				method: 'POST',
				data: form_data,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(data){
					Swal.fire({
						text: 'Please wait while we processing your request.',
						showCancelButton: false,
						showConfirmButton: false,
						allowOutsideClick: false,
						didOpen: () => {
							Swal.showLoading()
						}
					});
				},
				success: function(response){
					Swal.close();

					Swal.fire({
						title: 'Success!',
						text: 'Successfully Posted!',
						icon: 'info',
						confirmButtonText: 'Ok',
					}).then((result) => {
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