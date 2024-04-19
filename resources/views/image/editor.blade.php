@extends('layouts.image')

@section('content')
<div id="tui-image-editor"></div>
@endsection

@push('css')
<link rel="stylesheet" href="https://uicdn.toast.com/tui-image-editor/latest/tui-image-editor.css" />
<style type="text/css">
	.tui-image-editor-header-logo{
		display: none;
	}
</style>
@endpush

@push('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/4.4.0/fabric.js"></script>
<script type="text/javascript" src="https://uicdn.toast.com/tui.code-snippet/v1.5.0/tui-code-snippet.min.js"></script>
<script type="text/javascript" src="https://uicdn.toast.com/tui-color-picker/v2.2.6/tui-color-picker.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.3/FileSaver.min.js"></script>

<script type="text/javascript" src="{{ asset('tui.image-editor/apps/image-editor/dist/tui-image-editor.js') }}"></script>
<script type="text/javascript" src="{{ asset('tui.image-editor/apps/image-editor/examples/js/theme/white-theme.js') }}"></script>
<script type="text/javascript" src="{{ asset('tui.image-editor/apps/image-editor/examples/js/theme/black-theme.js') }}"></script>


<script>
// Image editor
	var imageEditor = new tui.ImageEditor('#tui-image-editor', {
		includeUI: {
			theme: whiteTheme, // or whiteTheme
			initMenu: 'filter',
			menuBarPosition: 'bottom',
		},
		cssMaxWidth: 700,
		cssMaxHeight: 500,
		usageStatistics: false,
	});

	window.onresize = function () {
		imageEditor.ui.resizeEditor();
	};
</script>
@endpush