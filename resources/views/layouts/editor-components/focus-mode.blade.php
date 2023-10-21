<form action="" type="POST" id="form-focus-mode">
	<input type="hidden" name="article-id" id="article-id" value="{{@$article->id}}">
	<div class="row mt-3">
		<div class="col-lg-12 form-group mb-3">
			<label for="article-title-field">Article Title</label>
			<input type="text" class="form-control" name="article-title-field" id="article-title-field" placeholder="Write article title here..." value="{{@$article->title}}" required/>
		</div>
		<div class="col-lg-12 form-group mb-3">
			<label for="article-description">Article Description</label>
			<textarea class="form-control" name="article-description" id="article-description" placeholder="Write article description here..." rows="10" required>{{@$article->description}}</textarea>
		</div>
		<div class="col-lg-12 form-group text-end">
			<button type="submit" id="btn-save-article" class="btn btn-primary"><i class="ti ti-device-floppy"></i> Save</button>
		</div>
		<div class="col-lg-12 form-group text-end">
			<hr>
		</div>
	</div>
</form>