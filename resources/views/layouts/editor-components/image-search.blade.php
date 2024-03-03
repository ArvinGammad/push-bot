<form action="" type="POST" id="form-image-search-mode">
	@csrf
	<div class="row mt-3 image-main-page">
		<div class="col-lg-12 form-group mb-3">
			<label for="article-title-field">Image Search</label>
			<input type="text" name="image-search" id="image-search" class="form-control">
		</div>
		<div class="col-lg-12 form-group text-end">
			<button type="button" class="btn btn-sm btn-primary" id="btn-image-run">Run Image Search</button>
		</div>
		<div class="col-lg-12 text-end">
			<hr>
		</div>
		<div class="col-lg-12 image-div-data">
		</div>
	</div>
</form>
