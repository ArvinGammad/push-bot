$(document).ready(function(){
	// Select the toast element
	var toastElement = $('.toast');
	// Initialize the toast
	var toast = new bootstrap.Toast(toastElement);

	$(document).on('click','#btn-save-article',function(e){
		e.preventDefault();

		var btn = $(this);
		btn.button('loading');

		var loading_html = '<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Saving';
		var default_html = btn.html();

		var article_title = $("#article-title-field").val();
		var article_description = $("#article-description").val();
		var article_content = $(".editor").html();
		var id = $("#article-id").val();

		var form_data = "article_title="+article_title+"&article_description="+article_description+"&article_content="+article_content+"&id="+id;

		$.ajax({
			url: '/article/editor/save',
			method: 'POST',
			data: form_data,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$(btn).html(loading_html);
			},
			success: function(response) {
				$(".toast").removeClass("bg-danger");
				$(".toast").addClass("bg-success");
				$("#toast-text").text("Successfully saved article!");

				toast.show();

				$(btn).html(default_html);
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: error,
				});
				$(btn).html(default_html);
			}
		});
	});

	$(".btn-compose").on('click',function(){
		var btn = $(".btn-compose");
		btn.button('loading');

		var loading_html = '<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Saving';
		var default_html = btn.html();

		var article_title = $("#article-title-field").val();
		var article_description = $("#article-description").val();
		var article_content = $(".editor").html();
		var id = $("#article-id").val();

		var form_data = "article_title="+article_title+"&article_description="+article_description+"&article_content="+article_content+"&id="+id;

		$.ajax({
			url: '/article/editor/compose',
			method: 'POST',
			data: form_data,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$(btn).html(loading_html);
			},
			success: function(response) {
				$(".toast").removeClass("bg-danger");
				$(".toast").addClass("bg-success");
				$("#toast-text").text("Successfully generated!");

				toast.show();

				$(btn).html(default_html);
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: error,
				});
				$(btn).html(default_html);
			}
		});
	})

});