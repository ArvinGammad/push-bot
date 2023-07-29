@extends('layouts.editor')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
      <div id="app">
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
</style>
@endpush

@push('js')

@endpush