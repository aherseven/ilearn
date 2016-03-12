<header class="main-header">
	<a href="{{ route('auth.index') }}" class="logo">
		<span class="logo-mini"><b>W</b>H</span>
		<span class="logo-lg"><b>Wira</b> Harapan</span>
	</a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

				<li class="dropdown messages-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-envelope-o"></i>
						<span class="label label-success">4</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 4 messages</li>
						<li>
							<ul class="menu">
								<li>
									<a href="#">
										<div class="pull-left">
											<img src="{{ $picture or "" }}" class="img-circle" alt="User Image"/>
										</div>
										<h4>Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4>
										<p>Why not buy a new awesome theme?</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">See All Messages</a></li>
					</ul>
				</li>

				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-bell-o"></i>
						<span class="label label-warning">10</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 10 notifications</li>
						<li>
							<ul class="menu">
								<li>
									<a href="#">
										<i class="fa fa-users text-aqua"></i> 5 new members joined today
									</a>
								</li>
							</ul>
						</li>
						<li class="footer"><a href="#">View all</a></li>
					</ul>
				</li>

				<li class="dropdown tasks-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-flag-o"></i>
						<span class="label label-danger">9</span>
					</a>
					<ul class="dropdown-menu">
						<li class="header">You have 9 tasks</li>
						<li>
							<ul class="menu">
								<li>
									<a href="#">
										<h3>Design some buttons <small class="pull-right">20%</small></h3>
										<div class="progress xs">
											<div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
												<span class="sr-only">20% Complete</span>
											</div>
										</div>
									</a>
								</li>
							</ul>
						</li>
						<li class="footer">
							<a href="#">View all tasks</a>
						</li>
					</ul>
				</li>

				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="{{ Auth::user()->picture }}" class="user-image" alt="User Image"/>
						<span class="hidden-xs">{{ Auth::user()->firstname }}</span>
					</a>
					<ul class="dropdown-menu">
						<li class="user-header" style="background: url({{ Auth::user()->cover }});">
							<img src="{{ Auth::user()->picture }}" class="img-circle" alt="User Image" />
							<p>
								{{ Auth::user()->fullname }}
								<small>{{ Auth::user()->created_at }}</small>
							</p>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="{{ route('auth.profile', Auth::user()->username) }}" class="btn btn-default btn-flat">Profil</a>
							</div>
							<div class="pull-right">
								<a href="{{ route('auth.logout') }}" class="btn btn-default btn-flat">Keluar</a>
							</div>
						</li>
					</ul>
				</li>
				<li>
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-ellipsis-h"></i></a>
				</li>
			</ul>
		</div>
	</nav>
</header>