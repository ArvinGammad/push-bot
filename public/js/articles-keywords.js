$(document).ready(function(){
	let article_count = 0;

	$(".btn-keyword-create").on('click',function(e){
		var btn = $(this);
		btn.button('loading');

		var loading_html = '<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Creating Article';
		var default_html = btn.html();

		var keywords = $("#keywords").val();

		$.ajax({
			url: '/article/keyword/create',
			method: 'POST',
			data: {keywords: keywords},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$(btn).html(loading_html);
			},
			success: function(response) {
				$(btn).html(default_html);
				$("#article-carousel").removeAttr('hidden');
				$(".carousel-indicators").append('<button type="button" data-bs-target="#article-carousel" data-bs-slide-to="'+article_count+'" class="active" aria-current="true"></button>');

				var html = '';

					html +='<div class="carousel-item active mt-3 mb-3">';
						html +='<div class="row">';
							html +='<div class="col-9 ms-auto me-auto">';
								html +='<div class="card">';
									html +='<div class="card-header">';
									html +='</div>';
									html += response.generated;
									html +='<div class="card-body" style="min-height: 500px;">';
									html +='</div>';
								html +='</div>';
							html +='</div>';
						html +='</div>';
					html +='</div>';

					$(".carousel-inner .carousel-item").removeClass('active');
					$(".carousel-inner").append(html);

					article_count++;
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