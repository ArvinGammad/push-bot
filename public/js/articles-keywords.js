$(document).ready(function(){
	$(".btn-keyword-create").on('click',function(e){
		var btn = $(this);
		btn.button('loading');

		var loading_html = '<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Creating Article';
		var default_html = btn.html();

		$.ajax({
			url: '/article/keyword/create',
			method: 'POST',
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$(btn).html(loading_html);
			},
			success: function(response) {
				$(btn).html(default_html);
				$("#article-carousel").removeAttr('hidden');
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