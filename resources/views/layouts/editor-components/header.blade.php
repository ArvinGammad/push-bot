<!--  Header Start -->
<header class="app-header">
	<nav class="navbar navbar-expand-lg navbar-light">
		<ul class="navbar-nav w-100">
			<li class="nav-item d-block d-xl-none">
				<a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
					<i class="ti ti-menu-2"></i>
				</a>
			</li>
			<li class="nav-item w-50">
				<input type="text" name="article-title" id="article-title" class="form-control" readonly value="{{@$article->title}}" placeholder="Untitled">
			</li>
		</ul>
		<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
			<ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
				<a href="javascript:void(0)" class="btn btn-success d-flex btn-compose"><i class="ti ti-pencil-plus mt-auto mb-auto me-2"></i> Compose</a>
				<li class="nav-item dropdown">
					<a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="{{asset('ui/assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
					</a>
					<div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
						<div class="message-body">
							<a href="/profile" class="d-flex align-items-center gap-2 dropdown-item">
								<i class="fa-solid fa-user fs-6 me-2"></i>
								<p class="mb-0 fs-3">My Profile</p>
							</a>
							<a href="/usage" class="d-flex align-items-center gap-2 dropdown-item">
								<i class="fa-solid fa-chart-simple fs-6 me-2"></i>
								<p class="mb-0 fs-3">My Usage</p>
							</a>
							<a href="javascript:void(0)" id="btn-logout" class="btn btn-outline-primary mx-3 mt-2 d-block"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>
<!--  Header End -->