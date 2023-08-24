$(document).ready(function(){
	

	$("#create-article").on('click',function(){
		var btn = $(this);
		btn.button('loading');

		var loading_html = '<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Saving';
		var default_html = btn.html();

		$.ajax({
			url: '/article/editor/create',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$(btn).html(loading_html);
			},
			success: function(response) {
				location.replace('/article/editor/'+response.id);
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
})