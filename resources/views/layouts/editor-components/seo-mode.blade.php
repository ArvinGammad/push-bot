<form action="" type="POST" id="form-seo-mode">
	@csrf
	<div class="row mt-3">
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
	</div>
</form>

<script type="text/javascript">
	let input = document.querySelector('#seo-keywords');
	let seo_tagify = new Tagify(input, {
		maxTags: 10
	});
</script>