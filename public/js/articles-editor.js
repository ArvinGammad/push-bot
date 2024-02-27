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
				$('#btn-template-generate').html('Generate Output');
				$('#btn-template-generate').attr('disabled',false);
				
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
				$('#btn-seo-run').html('Run Crawler');
				$('#btn-seo-run').attr('disabled',false);
				loadSEOData();
				
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
	}if(data == "seo-mode"){
		loadSEOData();
	}else{
		$("#main-wrapper[data-layout=vertical][data-header-position=fixed] .app-header").css('width','calc(100% - 270px)');
		$(".left-sidebar").css('width','270px');
		$(".body-wrapper").css('margin-left','270px');
	}
}

function loadSEOData(){
	$.ajax({
		url: '/seo/get-seo-data',
		method: 'GET',
		success: function(response){
			var data = response.data;

			var html = "";
			html += "<div class='row'>";
			if(data != null){
				data.forEach(function(element) {
					var seo_id = element.id;
					var seo_keywords = JSON.parse(element.keywords);
					var seo_status = element.status;
					var seo_created = element.created_at;

					var seo_keywords_string = seo_keywords.join(', ').substring(0, 40);

					var status_css = "";
					var status_text = "";

					if(seo_status == 0){
						status_css = "danger";
						status_text = "Pending";
					}else if(seo_status == 1){
						status_css = "warning";
						status_text = "Processing";
					}else if(seo_status == 2){
						status_css = "success";
						status_text = "Success";
					}

					html += "<div class='col-lg-12 border-bottom border-"+status_css+" p-2 rounded shadow-sm'>";
					html += "<i class='ti ti-circle-dot-filled me-2 text-"+status_css+"'></i>";
					html += "<a href='javascript:void(0)' class='text-"+status_css+" btn-open-seo-data' data-id='"+seo_id+"'>";
					html += "<b>"+seo_keywords_string+"...</b><br>";
					html += "<span style='color: #bfbaba; font-size: 12px;' class='ms-4'>"+seo_created+" - "+"</span>";
					html += "<span style='font-size: 12px;' class='text-"+status_css+"'>"+status_text+"</span>";
					html += "</a>";
					html += "</div>";
				});
			}
			html += "</div>";

			$(".seo-div-data").html(html);
			
		}
	});
}

var seoIntervalId;

$(document).on('click','.btn-open-seo-data',function(e){
	var seo_id = $(this).attr('data-id');

	clearInterval(seoIntervalId);

	getSEOData(seo_id);

	loadSEOData();
})

function checkSEOStatus(seo_id){
	$.ajax({
		url: '/seo/check-crawled-data',
		method: 'GET',
		data: { seo_id: seo_id },
		success: function(response){
			var data = response.data;
			var url_data_current = response.url_data_current;
			var url_data_count = response.url_data_count;
			var urls_crawled_success = response.urls_crawled_success;

			var html = "";
			if(data.status == "1"){
				var progress_count = (100/url_data_count)*urls_crawled_success;
				html += "<span class='text-center text-warning h2'>Processing</span><br>";
				html += "<span class='text-center text-warning'>We're currently crawling your SEO keywords.</span><br>";
				html += "<span class='text-center text-warning'>"+urls_crawled_success+" out of "+url_data_count+" has been crawled.</span>";
				html += "<div class='progress mt-2'>";
				html += "<div class='progress-bar progress-bar-striped progress-bar-animated seo-progress-bar' role='progressbar' aria-valuenow='"+progress_count+"' aria-valuemin='0' aria-valuemax='100' style='width: "+progress_count+"%'></div>";
				html += "</div>";

				if(url_data_current !== null){
					html += "<span> Gathering SEO content</span><br>";
					html += "<span style='font-size: 12px'>"+url_data_current.url.substring(0, 40)+"....</span>";
				}

				$(".seo-crawled-data").html(html);
			}else if(status=="2"){
				getSEOData(seo_id);
			}

			if(urls_crawled_success == url_data_count){
				clearInterval(seoIntervalId);
			}
		}
	});
}

	
$(document).on('click','.btn-seo-back',function(e){
	$(".seo-main-page").attr('hidden',false);
	$(".seo-data-page").attr('hidden',true);
});

function getSEOData(seo_id){
	var csrfToken = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		url: '/seo/get-crawled-data',
		method: 'GET',
		data: { seo_id: seo_id },
		headers: {
			'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the request header
		},
		success: function(response){
			var data = response.data;
			var url_data_current = response.url_data_current;
			var url_data_count = response.url_data_count;
			var urls_crawled_success = response.urls_crawled_success;

			$(".seo-main-page").attr('hidden',true);
			$(".seo-data-page").attr('hidden',false);

			var html = "";

			if(data.status == '0'){
				html += "<span class='text-center text-danger h2'>Pending</span><br>";
				html += "<span class='text-center text-danger'>We're still waiting on the crawl to begin for your SEO.</span>";

				seoIntervalId = setInterval(function() {
					checkSEOStatus(seo_id);
				}, 5000);

				$(".seo-crawled-data").html(html);
			}else if(data.status == '1'){

				var progress_count = (100/url_data_count)*urls_crawled_success;
				html += "<span class='text-center text-warning h2'>Processing</span><br>";
				html += "<span class='text-center text-warning'>We're currently crawling your SEO keywords.</span><br>";
				html += "<span class='text-center text-warning'>"+urls_crawled_success+" out of "+url_data_count+" has been crawled.</span>";
				html += "<div class='progress mt-2'>";
				html += "<div class='progress-bar progress-bar-striped progress-bar-animated seo-progress-bar' role='progressbar' aria-valuenow='"+progress_count+"' aria-valuemin='0' aria-valuemax='100' style='width: "+progress_count+"%'></div>";
				html += "</div>";

				if(url_data_current !== null){
					html += "<span> Gathering SEO content</span><br>";
					html += "<span style='font-size: 12px'>"+url_data_current.url.substring(0, 40)+"....</span>";
				}


				seoIntervalId = setInterval(function() {
					checkSEOStatus(seo_id);
				}, 5000);

				$(".seo-crawled-data").html(html);
			}else if(data.status == '2'){
				configureSEOContent(response);
			}

			
		},
		error: function(xhr, status, error){
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: error,
			});
		}
	});
}

let seo_keywords_array;
let seo_nlp_array;
let seo_terms_array;

function configureSEOContent(response){
	seo_keywords_array = JSON.parse(response.data.keywords);
	seo_terms_array = response.seo_terms;
	seo_nlp_array = response.seo_nlp;
	var html = "";
		html += "<div class='row'>";
			html += "<div class='col-lg-12 text-start seo-header-menu' data-name='content'>";
				html += "<h5><i class='ti ti-minus me-2 text-danger'></i>Content</h5>";
			html += "</div>";
		html += "</div>";

		html += "<div class='row' id='seo-data-content'>";
		
		html += "<div class='col-lg-12 text-center border-bottom mb-2'>";
				html += "<figure class='highcharts-figure'>";
					html += "<div id='chart-container'></div>";
				html += "</figure>";
				html += "<h2 class='text-danger'><span class='seo-content-score'>0</span></h2>";
				html += "<h6>SEO Score</h6>";
		html += "</div>";
		html += "<div class='col-lg-6 text-center'>";
			html += "<span class='seo-data-content-title'>WORDS</span>";
			html += "<p class='seo-data-content-words'><span class='seo-data-content-words-count seo-data-content-count'>0</span>/"+response.number_of_words+"</p>";
			html += "<hr>";

		html += "</div>";
		html += "<div class='col-lg-6 text-center'>";
			html += "<span class='seo-data-content-title'>HEADINGS</span>";
			html += "<p class='seo-data-content-headings'><span class='seo-data-content-headings-count seo-data-content-count'>0</span>/"+response.number_of_headings+"</p>";
			html += "<hr>";
		html += "</div>";
		html += "<div class='col-lg-6 text-center'>";
			html += "<span class='seo-data-content-title'>PARAGRAPHS</span>";
			html += "<p class='seo-data-content-paragraphs'><span class='seo-data-content-paragraphs-count seo-data-content-count'>0</span>/"+response.number_of_paragraphs+"</p>";
			html += "<hr>";
		html += "</div>";
		html += "<div class='col-lg-6 text-center'>";
			html += "<span class='seo-data-content-title'>IMAGES</span>";
			html += "<p class='seo-data-content-images'><span class='seo-data-content-images-count seo-data-content-count'>0</span>/"+response.number_of_images+"</p>";
			html += "<hr>";
		html += "</div>";
	html += "</div>";

	html += "<div class='row'>";
		html += "<div class='col-lg-12 text-start seo-header-menu' data-name='headings'>";
			html += "<h5><i class='ti ti-plus me-2 text-success'></i>Headings</h5>";
		html += "</div>";
	html += "</div>";

	html += "<div class='row d-none' id='seo-data-headings'>";
		html += "<div class='col-lg-12 border-bottom mb-2 text-start'>";
		response.recommended_headings.forEach(function(element) {
			html += "<h6><u><i>"+element+"</i></u></h6>";
		});
		html += "</div>";
	html += "</div>";

	html += "<div class='row'>";
		html += "<div class='col-lg-12 text-start seo-header-menu' data-name='keywords'>";
			html += "<h5><i class='ti ti-plus me-2 text-success'></i>Keywods</h5>";
		html += "</div>";
	html += "</div>";

	html += "<div class='row d-none' id='seo-data-keywords'>";
		html += "<div class='col-lg-12 border-bottom mb-2 text-start' style='word-wrap: break-word;'>";
			html += "<ul>";
			html += "<li class='ms-2 seo-header-menu' data-name='titles'><h6><i class='ti ti-plus me-2 text-success'></i>TITLES</h6></li>";
			html += "<li class='ms-2 d-none' id='seo-data-titles'>";
			response.seo_titles.forEach(function(element) {
				html += "<span class='btn btn-danger btn-sm m-1' style='font-size: 10px;'>"+element+"</span></a>";
			});
			html += "</li>";
			html += "</ul>";
		html += "</div>";

		html += "<div class='col-lg-12 border-bottom mb-2 text-start' style='word-wrap: break-word;'>";
			html += "<ul>";
			html += "<li class='ms-2 seo-header-menu' data-name='nlp'><h6><i class='ti ti-plus me-2 text-success'></i>NLP</h6></li>";
			html += "<li class='ms-2 d-none' id='seo-data-nlp'>";
			response.seo_nlp.forEach(function(element) {
				html += "<span class='btn btn-danger btn-sm m-1' style='font-size: 10px;'>"+element+"</span></a>";
			});
			html += "</li>";
			html += "</ul>";
		html += "</div>";

		html += "<div class='col-lg-12 mb-2 text-start' style='word-wrap: break-word;'>";
			html += "<ul>";
			html += "<li class='ms-2 seo-header-menu' data-name='terms'><h6><i class='ti ti-plus me-2 text-success'></i>TERMS</h6></li>";
			html += "<li class='ms-2 d-none' id='seo-data-terms'>";
			response.seo_terms.forEach(function(element) {
				html += "<span class='btn btn-danger btn-sm m-1' style='font-size: 10px;'>"+element+"</span></a>";
			});
			html += "</li>";
			html += "</ul>";
		html += "</div>";
	html += "</div>";

	html += "<div class='row'>";
		html += "<div class='col-lg-12 text-start seo-header-menu' data-name='references'>";
			html += "<h5><i class='ti ti-plus me-2 text-success'></i>References</h5>";
		html += "</div>";
	html += "</div>";

	html += "<div class='row d-none' id='seo-data-references'>";
		html += "<div class='col-lg-12 text-center border-bottom mb-2'>";
			html += "<div class='col-lg-12 border-bottom mb-2 text-start' style='word-wrap: break-word;'>";
				response.seo_urls.forEach(function(element) {
					html += "<h6><a href='"+element+"' target='_BLANK'><i>"+element+"</i></a></h6>";
				});
			html += "</div>";
		html += "</div>";
	html += "</div>";


	$(".seo-crawled-data").html(html);

	calculateScore();
	
}

$(document).on('click','.seo-header-menu',function(e){
	var data_name = $(this).attr('data-name')

	if($("#seo-data-"+data_name).hasClass('d-none') === false){
		$("#seo-data-"+data_name).addClass('d-none');
		$(".seo-header-menu[data-name="+data_name+"] i").removeClass('ti-minus');
		$(".seo-header-menu[data-name="+data_name+"] i").addClass('ti-plus');
		$(".seo-header-menu[data-name="+data_name+"] i").removeClass('text-danger');
		$(".seo-header-menu[data-name="+data_name+"] i").addClass('text-success');
	}else{
		$("#seo-data-"+data_name).removeClass('d-none');
		$(".seo-header-menu[data-name="+data_name+"] i").addClass('ti-minus');
		$(".seo-header-menu[data-name="+data_name+"] i").removeClass('ti-plus');
		$(".seo-header-menu[data-name="+data_name+"] i").addClass('text-danger');
		$(".seo-header-menu[data-name="+data_name+"] i").removeClass('text-success');
	}
});

var typingTimer;
var doneTypingInterval = 1000; // 1 second (adjust as needed)

$(document).on('keyup','.medium-editor-container .editor', function(){
    clearTimeout(typingTimer);
    typingTimer = setTimeout(calculateScore, doneTypingInterval);
});

function calculateScore(){
	var editor_text = $(".editor").text();

	var editor_h2Count = $('.editor h2').length;
	var editor_h1Count = $('.editor h1').length;

	var editor_headings = [];
	$('.editor h2').each(function(e){
		editor_headings.push($(this).text());
	});

	$('.editor h1').each(function(e){
		editor_headings.push($(this).text());
	});

	var editor_imageCount = $('.editor img').length;
	var nonEmptyParagraphs = $('.editor p').filter(function() {
		return $(this).text().trim().length > 0;
	});
	var editor_paragraphCount = nonEmptyParagraphs.length;

	var headings_count = editor_h2Count + editor_h1Count;

	var words = editor_text.match(/\S+/g); // Split text into words
	var wordCount = words ? words.length : 0; // Count words

	$(".seo-data-content-words-count").text(wordCount);
	$(".seo-data-content-headings-count").text(headings_count);
	$(".seo-data-content-paragraphs-count").text(editor_paragraphCount);
	$(".seo-data-content-images-count").text(editor_imageCount);

	 const criteria = {
        words: { min: 500, weight: 10 },
        headings: { min: 3, weight: 5 },
        paragraphs: { min: 5, weight: 5 },
        images: { min: 5, weight: 10 }
    };

    // Calculate format_score for each criterion
    let format_score = 0;
    let nlp_score = calculateNLPSEOScore(seo_nlp_array, editor_text);
    let keywords_score = 0;
    let total_score = 0;

    let titles_score = calculateTitleSEOScore(headings_count,seo_keywords_array,editor_headings);

    if (wordCount >= criteria.words.min) {
        format_score += criteria.words.weight;
    }
    if (headings_count >= criteria.headings.min) {
        format_score += criteria.headings.weight;
    }
    if (editor_paragraphCount >= criteria.paragraphs.min) {
        format_score += criteria.paragraphs.weight;
    }
    if (editor_imageCount >= criteria.images.min) {
        format_score += criteria.images.weight;
    }



	initializeHighchart(format_score, nlp_score, keywords_score, titles_score);

	total_score = format_score+nlp_score+keywords_score+titles_score;

	if(total_score <= 60){
		$(".seo-content-score").parent('h2').removeClass('text-success');
		$(".seo-content-score").parent('h2').removeClass('text-warning');
		$(".seo-content-score").parent('h2').removeClass('text-danger');
		$(".seo-content-score").parent('h2').addClass('text-danger');
	}else if(total_score <= 80){
		$(".seo-content-score").parent('h2').removeClass('text-success');
		$(".seo-content-score").parent('h2').removeClass('text-warning');
		$(".seo-content-score").parent('h2').removeClass('text-danger');
		$(".seo-content-score").parent('h2').addClass('text-warning');
	}else if(total_score <= 100){
		$(".seo-content-score").parent('h2').removeClass('text-success');
		$(".seo-content-score").parent('h2').removeClass('text-warning');
		$(".seo-content-score").parent('h2').removeClass('text-danger');
		$(".seo-content-score").parent('h2').addClass('text-success');
	}

	$(".seo-content-score").text(total_score);
}

function calculateNLPSEOScore(nlp_data, content){

	let nlp_total_score = 0;
	nlp_data.forEach(nlp => {
        if (nlp.match(content)) {
            nlp_total_score += 1;
        }
    });

    return nlp_total_score;

}

function calculateTitleSEOScore(numHeadings, keywords, headings) {

    // Define weights
    const headingWeight = 10;
    const keywordWeight = 10;

    // Calculate score for number of headings
    let headingScore = 0;
    if (numHeadings < 10) {
        headingScore = numHeadings;
    }else{
    	headingScore = 10;
    }

    // Calculate score for relatedness to keywords
    let keywordScore = 0;
    if (keywords.length > 0 && headings.length > 0) {
        const keywordRegex = new RegExp(keywords.join('|'), 'i');
        headings.forEach(heading => {
            if (heading.match(keywordRegex)) {
                keywordScore += 1;
            }
        });

        keywordScore = Math.min(keywordScore, 1) * keywordWeight;
    }

    // Calculate total score
    const totalScore = headingScore + keywordScore;

    return totalScore;
}

function  initializeHighchart(format_score, nlp_score, keywords_score, titles_score){
	var non_seo_score = 100-(format_score+nlp_score+keywords_score+titles_score);
	Highcharts.chart('chart-container', {
		chart: {
			type: 'pie'
		},
		exporting: {
			enabled: false // Disable exporting options
		},
		title: {
			text: '',
			enabled: false
		},
		tooltip: {
			valueSuffix: '%'
		},
		subtitle: {
			text: ''
		},
		plotOptions: {
			series: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: [{
					enabled: true,
					distance: 10
				}, {
					enabled: true,
					distance: -40,
					format: '{point.percentage:.1f}%',
					style: {
						fontSize: '1.2em',
						textOutline: 'none',
						opacity: 0.7
					},
					filter: {
						operator: '>',
						property: 'percentage',
						value: 10
					}
				}]
			}
		},
		colors: ['#166816', '#c93c0c', '#0b30a4','#c89b15','#e6e6e6'],
		series: [
			{
				name: 'Percentage',
				colorByPoint: true,
				data: [
					{
						name: 'Formats',
						y: format_score
					},
					{
						name: 'Keywords',
						y: keywords_score
					},
					{
						name: 'Titles',
						y: titles_score
					},
					{
						name: 'NLP',
						y: nlp_score
					},
					{
						name: 'No Score',
						y: non_seo_score
					}
				]
			}
		]
	});
}