<aside class="left-sidebar">
	<!-- Sidebar scroll-->
	<div>
		<div class="brand-logo d-flex align-items-center justify-content-between">
			<a href="./index.html" class="text-nowrap logo-img">
				<img src="{{asset('ui/assets/images/logos/dark-logo.svg')}}" width="180" alt="" />
			</a>
			<div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
				<i class="ti ti-x fs-8"></i>
			</div>
			
		</div>
		<!-- Sidebar navigation-->
		<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
			<div id="focus-mode">
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
							<!-- <button type="submit" id="btn-cancel-article" class="btn btn-danger me-2"><i class="ti ti-x"></i> Cancel</button> -->
							<button type="submit" id="btn-save-article" class="btn btn-primary"><i class="ti ti-device-floppy"></i> Save</button>
						</div>
						<div class="col-lg-12 form-group text-end">
							<hr>
						</div>
					</div>
				</form>
			</div>
		</nav>
		<!-- End Sidebar navigation -->
	</div>
	<!-- End Sidebar scroll-->
</aside>