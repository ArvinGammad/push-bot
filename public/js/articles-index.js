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
	});

	$(document).on('click','.delete-article', function(e){
		var article_id = $(this).data('id');

		Swal.fire({
			icon: 'warning',
			title: 'Delete Article',
			text: 'Your about to delete the selected article, Do you want to proceed?',
			showCancelButton: true,
			confirmButtonText: 'Delete Article',
		}).then((result) => {
			if (result.isConfirmed) {

				$.ajax({
					url: '/article/delete',
					method: 'DELETE',
					data: {article_id: article_id},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					beforeSend: function(xhr) {
						Swal.fire({
							text: 'Please wait while we deleting your article.',
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false,
							didOpen: () => {
								Swal.showLoading()
							}
						});


					},
					success: function(response) {
						// Swal.fire('Successfully Deleted!', '', 'success');

						Swal.fire({
							title: 'Success!',
							text: 'Successfully Deleted!',
							icon: 'info',
							confirmButtonText: 'Ok',
						}).then((result) => {
							location.reload();
						});

					},
					error: function(xhr, status, error) {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: error,
						});
					}
				});

			}
		})
	});

})