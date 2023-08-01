@extends('layouts.editor')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 text-center settings-con mb-3">
				<a class="btn btn-success active"><i class="ti ti-adjustments-horizontal"></i> <br>Focus Mode</a>
				<a class="btn btn-success"><i class="ti ti-template"></i> <br>Power Mode</a>
				<a class="btn btn-success"><i class="ti ti-seo"></i> <br>SEO Mode</a>
				<a class="btn btn-success"><i class="ti ti-photo-search"></i> <br>Image Search</a>
				<a class="btn btn-success"><i class="ti ti-photo-edit"></i> <br>Image Generator</a>
				<a class="btn btn-success"><i class="ti ti-microphone"></i> <br>Text To Speech</a>
				<a class="btn btn-success"><i class="ti ti-message-2-share"></i> <br>Post Article</a>
		</div>
		<div class="col-lg-12">
			<div id="w-editor">
				<medium-editor></medium-editor>
			</div>
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
</style>
@endpush

@push('js')
@endpush