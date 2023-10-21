$(document).ready(function(){
	$(".settings-con a").on('click',function(){
		$(".editor-menu").removeClass('active');
		$(this).addClass('active');

		var target = $(this).attr('data-toggle');
		var id = $(this).attr('data-id');

		get_target_data(target,id);
	});

	$(document).on('change','#template-name', function(){
		var template_id = $(this).val();

		$.ajax({
			url: '/template/inputs',
			method: 'GET',
			data: {template_id: template_id},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			beforeSend: function(xhr) {
				$('.template-inputs').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span>');
			},
			success: function(response) {
			},
			error: function(xhr, status, error) {
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: error,
				});
			}
		});
	});

	const textToType = "Hello, this is a typing effect!";
	const typingSpeed = 50; // Speed in milliseconds (adjust as needed)

	function appendTextWithTyping() {
		let currentIndex = 0;
		const typingInterval = setInterval(function () {
			$('#w-editor .editor').append(textToType[currentIndex]);
			currentIndex++;
			if (currentIndex === textToType.length) {
				clearInterval(typingInterval);
			}
		}, typingSpeed);
	}
});

function get_target_data(data,id){
	$("#editor-modes").html('');
	$("#editor-modes").load('/'+data+'/'+id);

	if(data != "focus-mode"){
		$("#main-wrapper[data-layout=vertical][data-header-position=fixed] .app-header").css('width','calc(100% - 360px)');
		$(".left-sidebar").css('width','360px');
		$(".body-wrapper").css('margin-left','360px');
	}else{
		$("#main-wrapper[data-layout=vertical][data-header-position=fixed] .app-header").css('width','calc(100% - 270px)');
		$(".left-sidebar").css('width','270px');
		$(".body-wrapper").css('margin-left','270px');
	}
}