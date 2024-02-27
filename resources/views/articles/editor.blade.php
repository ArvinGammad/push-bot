@extends('layouts.editor')

@section('content')
<div class="container-fluid">
	<div class="row options-con">
		<div class="col-lg-12 text-center settings-con mb-3">
				<a class="btn btn-success editor-menu active"  data-id="{{@$article->id}}" data-toggle="focus-mode"><i class="ti ti-adjustments-horizontal"></i> <br>Focus Mode</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="power-mode"><i class="ti ti-template"></i> <br>Power Mode</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="seo-mode"><i class="ti ti-seo"></i> <br>SEO Mode</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="image-search"><i class="ti ti-photo-search"></i> <br>Image Search</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="image-generator"><i class="ti ti-photo-edit"></i> <br>Image Generator</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="text-to-speech"><i class="ti ti-microphone"></i> <br>Text To Speech</a>
				<a class="btn btn-success editor-menu" data-id="{{@$article->id}}" data-toggle="post-article"><i class="ti ti-message-2-share"></i> <br>Post Article</a>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-lg-12">
			<div id="w-editor">
				<medium-editor></medium-editor>
			</div>
		</div>
		<div class="col-lg-12">
			<textarea id="article-content" hidden>{{@$article->content}}</textarea>
		</div>
	</div>
</div>
@endsection
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.21.1/tagify.min.css" integrity="sha512-TfYPiHiDtSRYxQL0fM3J+hJuiNvZZloMzG+PHyDgYA5DldpuUOhsfi2WDkGPp8cAV0h2NgaLH1OxZdqw2BbNAA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@vite(['resources/js/app.js'])

<style type="text/css">
	.articles-icon{
		font-size:70px;
	}
	.settings-con a.btn{
		background: none;
		border: none;
		color: #58575adb;
		font-size: 10px;
	}
	.settings-con a.btn.active{
		background: none;
		border: none;
		color: #11a50bfa;
		font-size: 10px;
		box-shadow: none;
	}
	.settings-con a i{
		font-size: 30px;
	}
	.options-con{
		position: fixed;
		width: 100%;
		text-align: center;
		left: 58%;
		transform: translate(-50%, 0);
/*		z-index: 10000;*/
	}
</style>

<style type="text/css">
	#seo-data-one div span.seo-data-one-title{
		font-size: 13px;
		font-weight: bold;
	}

	.seo-header-menu {
		cursor: pointer;
	}
</style>

<style type="text/css">
	.highcharts-figure, .highcharts-data-table table {
		min-width: 250px;
		max-width: 800px;
		margin: 0em auto;
	}

	#chart-container{
		height: 250px;
	}

	.highcharts-data-table table {
		font-family: Verdana, sans-serif;
		border-collapse: collapse;
		border: 1px solid #ebebeb;
		margin: 10px auto;
		text-align: center;
		width: 100%;
		max-width: 500px;
	}

	.highcharts-data-table caption {
		padding: 1em 0;
		font-size: 1em;
		color: #555;
	}
	.highcharts-label text {
		padding: 1em 0;
		font-size: 0.7em !important;
		color: #555;
	}

	.highcharts-credits{
		display: none !important;
	}

	.highcharts-data-table th {
		font-weight: 600;
		padding: 0.5em;
	}

	.highcharts-data-table td,
	.highcharts-data-table th,
	.highcharts-data-table caption {
		padding: 0.5em;
	}

	.highcharts-data-table thead tr,
	.highcharts-data-table tr:nth-child(even) {
		background: #f8f8f8;
	}

	.highcharts-data-table tr:hover {
		background: #f1f7ff;
	}

	input[type="number"] {
		min-width: 50px;
	}

</style>
@endpush

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.21.1/tagify.min.js" integrity="sha512-e1PLou9D3vRJUgA/hH/a+xOasrGwqiIvTmoufWjcb8SNA10X/gKxQW/JMNIJaTHi9JuzCqbO+I2+9EvIfcM7Kw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tagify/4.21.1/jQuery.tagify.min.js" integrity="sha512-oFeYIKFB7IoBKasr/A2okjvrujhixSQTsYMZ1MfX2X09wvTh6kUrCSAInu+2pkHrojvDS9QqMHSaBbDhjosWZg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{asset('js/articles-editor.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>

<script type="text/javascript">
	$(document).ready(function(e){
		$(window).scroll(function(){
			if($(this).scrollTop() > 50){
				$(".options-con").css("z-index","1000");
				$(".options-con a.btn").css("background","white");
				$(".options-con a.btn").css("box-shadow","rgba(0, 0, 0, 0.24) 0px 3px 8px");
			}else{
				$(".options-con").css("z-index","1");
				$(".options-con a.btn").css("background","none");
				$(".options-con a.btn").css("box-shadow","none");
			}
		});
	});
</script>
@endpush