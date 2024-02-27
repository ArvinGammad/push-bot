<form action="" type="POST" id="form-seo-mode">
	@csrf
	<div class="row mt-3 seo-main-page">
		<div class="col-lg-12 form-group mb-3">
			<label for="article-title-field">SEO Keywords</label>
			<input type="text" name="seo-keywords" id="seo-keywords" class="form-control">
		</div>
		<div class="col-lg-12 form-group text-end">
			<button type="button" class="btn btn-sm btn-primary" id="btn-seo-run">Run Crawler</button>
		</div>
		<div class="col-lg-12 form-group text-end">
			<hr>
		</div>
		<div class="col-lg-12 form-group seo-div-data">
		</div>
	</div>
	<div class="row mt-3 seo-data-page" hidden>
		
		<div class="col-lg-12">
			<a href="javascript:void(0)" class="btn btn-primary btn-sm w-100 btn-seo-back"><i class="ti ti-arrow-back-up"></i> Go Back To SEO List</a>
			<hr>
		</div>
		<div class="col-lg-12 seo-crawled-data text-center">
		</div>
	</div>
</form>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script type="text/javascript">
	let input = document.querySelector('#seo-keywords');
	let seo_tagify = new Tagify(input, {
		maxTags: 10
	});
</script>