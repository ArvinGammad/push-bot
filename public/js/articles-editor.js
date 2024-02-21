let index = 0;
const speed = 5; // typing speed in milliseconds

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
				var inputs = response.inputs
				var html = "<div class='row'>";
				for (var i = 0; i < inputs.length; i++) {
					html += "<div class='col-12 form-group text-start mt-2'>";
					if(inputs[i]['type'] == 'text'){
						html += "<label>"+inputs[i]['label']+"</label>";
						html += "<input type='"+inputs[i]['type']+"' name='"+inputs[i]['name']+"' class='form-control'>";
					}else if(inputs[i]['type'] == 'textarea'){
						html += "<label>"+inputs[i]['label']+"</label>";
						html += "<textarea name='"+inputs[i]['name']+"' class='form-control'></textarea>";
					}
					html += "</div>";
				}

				html += `<div class='col-lg-12 form-group text-start mt-2'>
							<label>Tone of Voice</label>
							<select class="form-control tone" required="required" name="tone">
								<option value="professional">Professional</option>
								<option value="friendly">Friendly</option>
								<option value="witty">Witty</option>
								<option value="persuasive">Persuasive</option>
								<option value="dramatic">Dramatic</option>
								<option value="funny">Funny</option>
								<option value="excited">Excited</option>
							</select>
						</div>`;
				
				html += "</div>";

				html += `<div class='col-lg-12 form-group text-start mt-3'>
							<button type="button" class="btn btn-sm btn-primary" id="btn-template-generate">Generate Output</button>
						</div>`;
				
				html += "</div>";
				$("#slug").val(response.template.slug);
				$('.template-inputs').html(html);
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

	$(document).on('click','#btn-template-clear',function(){
		$("#form-power-mode")[0].reset();
	});

	$(document).on('click','#btn-template-generate',function(e){
		e.preventDefault();
		var form_data = $("#form-power-mode").serialize();

		$.ajax({
			url: '/admin/templates/generate',
			method: 'POST',
			data:form_data,
			beforeSend: function(data){
				$('#btn-template-generate').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Generating URLs');
				$('#btn-template-generate').attr('disabled',true);
			},
			success: function(data){
				$('#generated-output').html('');
				$(".current_p").removeClass("current_p");
				typeWriter(data.response,0);
				$('#btn-template-generate').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Waiting for the application to run your request.');
				$('#btn-template-generate').attr('disabled',true);
				
			},
			error: function(xhr, status, error){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: error,
				});
				$('#btn-template-generate').html('Generate Output');
				$('#btn-template-generate').attr('disabled',false);
			}
		});
	});

	$(document).on('click','#btn-seo-run',function(e){
		var tags = seo_tagify.value.map(tag => tag.value);
		var csrfToken = $('meta[name="csrf-token"]').attr('content');
		$.ajax({
			url: '/seo/generate-urls',
			method: 'POST',
			data: { keywords: JSON.stringify(tags) },
			headers: {
				'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request header
			},
			beforeSend: function(xhr, data){
				$('#btn-seo-run').html('<span id="loading-spinner" class="spinner-border spinner-border-sm me-1"></span> Generating');
				$('#btn-seo-run').attr('disabled',true);
			},
			success: function(data){
				$('#generated-output').html('');
				$('#btn-seo-run').html('Run Crawler');
				$('#btn-seo-run').attr('disabled',false);
				
			},
			error: function(xhr, status, error){
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: error,
				});
				$('#btn-seo-run').html('Run Crawler');
				$('#btn-seo-run').attr('disabled',false);
			}
		});
	})

});
var opened_p = 0;
function typeWriter(text, index = 0) {
	if (index < text.length) {
		if (text.charAt(index) === '\n') {
			$(".editor").append("<p></p>");
			opened_p = 0;
			$(".current_p").removeClass("current_p");
		}else{
			if(opened_p == 0){
				$(".editor").append("<p class='current_p'></p>");
				opened_p = 1;
			}
			$(".editor .current_p").append(text.charAt(index));
		}

		index++;
		setTimeout(() => {
			typeWriter(text, index);
		}, speed);
	}
}

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