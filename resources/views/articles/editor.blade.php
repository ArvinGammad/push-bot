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
@endpush

@push('js')
<script src="{{asset('js/articles-editor.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>
@endpush