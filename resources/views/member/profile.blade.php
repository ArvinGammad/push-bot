@extends('layouts.auth')

@section('content')
<div class="container"  style="padding-top: 100px">
	<div class="row">
		<div class="col-lg-3 user-profile-menu">
			<ul class="nav flex-column">
				<li class="nav-item">
					<a class="nav-link active" aria-current="page" href="javascript:void(0)" data-id="user-profile"><i class="fa-solid fa-id-card me-2"></i> User Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="javascript:void(0)" data-id="user-password"><i class="fa-solid fa-key me-2"></i> Account Password</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="javascript:void(0)" data-id="user-credit"><i class="fa-solid fa-coins me-2"></i> Credit and Subscription</a>
				</li>
			</ul>
		</div>
		<div class="col-lg-9">
			<div class="row" id="user-tab-contents">
				<div class="col-lg-12 user-div-content" id="user-profile">
					<div class="card w-100">
						<div class="card-header bg-danger">
							<h5 class="text-white"><i class="fa-solid fa-id-card me-2"></i> Personal Information</h5>
						</div>
						<div class="card-body">
							<form id="form-profile" enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-lg-12 form-group mb-4 text-center">
										<div class="circle">
											@if(is_null(Auth::user()->picture))
											<img src="{{asset('ui/assets/images/profile/user-1.jpg')}}" class="profile-pic">
											@elseif(Auth::user()->picture == '')
											<img src="{{asset('ui/assets/images/profile/user-1.jpg')}}" class="profile-pic">
											@else
											<img src="{{asset('storage/profile/images/')}}/{{Auth::user()->picture}}" class="profile-pic">
											@endif
										</div>
									</div>
									<div class="col-lg-12 form-group mb-4 text-center">
										<input class="file-upload" type="file" name="profile_image" accept="image/*"/>
										<div class="p-image upload-button">
											<i class="fa fa-camera me-2"></i>
											Upload New Profile
										</div>
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-lg-12 form-group mb-4">
										<label for="profile_name"><i class="fa-solid fa-signature me-2"></i> Name</label>
										<input type="text" value="{{Auth::user()->name}}" name="profile_name" id="profile_name" class="form-control" required>
									</div>
									<div class="col-lg-12 form-group mb-4">
										<label for="profile_email"><i class="fa-solid fa-at me-2"></i> Email</label>
										<input type="email" value="{{Auth::user()->email}}" name="profile_email" id="profile-email" class="form-control" required>
									</div>
									<div class="col-lg-12 form-group text-end">
										<button class="btn btn-success"><i class="fa-solid fa-floppy-disk me-2"></i>Save Changes</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-lg-12 user-div-content  d-none" id="user-password">
					<form id="form-profile-password">
						<div class="card w-100">
							<div class="card-header bg-danger">
								<h4 class="text-white"><i class="fa-solid fa-key me-2"></i> Change Password</h4>
							</div>
							<div class="card-body">
									<div class="row">
										<div class="col-lg-12 form-group mb-4">
											<label for="profile_password"><i class="fa-solid fa-key me-2"></i> Current Password</label>
											<input type="password" name="profile_password" id="profile_password" class="form-control" required>
										</div>
										<div class="col-lg-12 form-group mb-4">
											<label for="profile_new_password"><i class="fa-solid fa-key me-2"></i>New Password <span>(At least 8 characters)</span></label>
											<input type="password" name="profile_new_password" id="profile_new_password" class="form-control" required>

										</div>
										<div class="col-lg-12 form-group mb-4">
											<label for="profile_confirm_password"><i class="fa-solid fa-key me-2"></i>Confirm Password</label>
											<input type="password" name="profile_confirm_password" id="profile_confirm_password" class="form-control" required>
										</div>
									</div>
								
							</div>
							<div class="card-footer text-end">
								<button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk me-2"></i>Save Changes</button>
							</div>
						</div>
					</form>
				</div>
				<div class="col-lg-12 user-div-content d-none" id="user-credit">
					<div class="card w-100">
						<div class="card-header bg-danger">
							<h4 class="text-white"> Credits and Subscription</h4>
						</div>
						<div class="card-body">
							<form id="form-credits-subscriptions">
								<div class="row">
									<div class="col-lg-12 form-group mb-4">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('css')
<style type="text/css">
	.user-profile-menu ul li a.active{
		background: #0cac50;
		border-radius: 10px;
		color: white;
	}

	.profile-pic {
		width: 200px;
		max-height: 200px;
		display: inline-block;
	}

	.file-upload {
		display: none;
	}
	.circle {
		border-radius: 100% !important;
		overflow: hidden;
		width: 200px;
		height: 200px;
		border: 2px solid rgba(255, 255, 255, 0.2);
		margin: auto;
	}
	img.profile-pic {
		max-width: 100%;
		height: auto;
	}
	.p-image {
		/*position: fixed;
		top: 342px;
		right: 395px;*/
		color: #136cd7;
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
	}
	.p-image:hover {
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
	}
	.upload-button {
		font-size: 1.3em;
		cursor: pointer;
	}

	.upload-button:hover {
		transition: all .3s cubic-bezier(.175, .885, .32, 1.275);
		color: #999;
	}
</style>
@endpush

@push('js')

<script type="text/javascript">
	$(".user-profile-menu a").on('click',function(e){
		var data_id = $(this).attr('data-id');
		$(".user-profile-menu a").removeClass('active');
		$(this).addClass('active');

		$("#user-tab-contents .user-div-content").addClass('d-none');
		$("#"+data_id).removeClass('d-none');
	});

	$(document).ready(function() {
		var readURL = function(input) {
			if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function (e) {
				$('.profile-pic').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
			}
		}


		$(".file-upload").on('change', function(){
			readURL(this);
		});

		$(".upload-button").on('click', function() {
			$(".file-upload").click();
		});

		$("#form-profile-password").on('submit',function(e){
			e.preventDefault();

			var formData = $(this).serialize();

			$.ajax({
				url: '/profile/change-password',
				method: 'PUT',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				beforeSend: function(data){
					Swal.fire({
						text: 'Processing...',
						allowOutsideClick: false,
						didOpen: () => {
								Swal.showLoading();
						}
					});
				},
				success: function(response){
					Swal.close();
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Successfully Saved!',
						confirmButtonText: 'Ok',
					});
				},
				error: function(xhr, status, error){
					console.log(xhr.responseJSON);
					// Handle error response
					Swal.close();
					Swal.fire({
						icon: 'error',
						title: 'Oops Something Went Wrong...',
						text: 'Please make sure your details are correct',
					});
				}
			});
		})

		$("#form-profile").on('submit',function(e){
			e.preventDefault();
			var formData = new FormData(this);

			$.ajax({
				url: '/profile/save-profile',
				method: 'POST',
				data: formData,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				processData: false,
				contentType: false,
				beforeSend: function(data){
					Swal.fire({
						text: 'Processing...',
						allowOutsideClick: false,
						didOpen: () => {
								Swal.showLoading();
						}
					});
				},
				success: function(response){
					Swal.close();
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Successfully Saved!',
						confirmButtonText: 'Ok',
					});
				},
				error: function(xhr, status, error){
					// Handle error response
					Swal.close();
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: xhr.responseJSON.error,
					});
				}
			});
		});
	});
</script>
@endpush