@extends('layouts.auth')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-8 me-auto ms-auto">
			<div class="card p-0">
				<div class="card-header bg-danger">
				</div>
				<div class="card-body">
					<div class="form-group">
						<h5><i class="ti ti-key"></i> Enter your keywords below</h5>
						<select class="form-control" name="keywords" id="keywords" multiple="multiple">
						</select>
						<p class="text-info">When entering numerous keywords, it is better if they are all connected to one another (for example, "AI, Computer, AI Content Generation").</p>
					</div>
					<button class="btn btn-primary mt-3 btn-keyword-create"><i class="ti ti-search me-1"></i> Create Article</button>
				</div>
			</div>
		</div>
		<div class="col-12 text-center">
			<hr>
			<div id="article-carousel" class="carousel slide" data-bs-ride="true" hidden>
				<div class="carousel-indicators">
					<button type="button" data-bs-target="#article-carousel" data-bs-slide-to="0" class="active" aria-label="Slide 1" aria-current="true"></button>
				</div>
				<div class="carousel-inner" style="background: #b3b3b3;">
					<div class="carousel-item active mt-3 mb-3">
						<div class="row">
							<div class="col-9 ms-auto me-auto">
								<div class="card">
									<div class="card-header">
									</div>
									<div class="card-body" style="min-height: 500px;">
									</div>
								</div>
							</div>
						</div>
						
					</div>
				</div>
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
  		  </div>
		</div>
	</div>
</div>
@endsection
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style type="text/css">
	.articles-icon{
		font-size:70px;
	}
	.card{
		box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
	}
</style>
@endpush

@push('js')
<script src="{{asset('js/articles-keywords.js')}}?v={{strtotime(date('Y-m-d h:i:s'))}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script type="text/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();
	});

	$(document).ready(function() {
		$('#keywords').select2({
			tags: true,
			tokenSeparators: [','], // Separators for creating new tags
		});
	});
</script>
@endpush