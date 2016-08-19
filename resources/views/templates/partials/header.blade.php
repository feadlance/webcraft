<header>
	<!-- top -->
	<div class="top">
		<div class="pull-left">
			<div class="page-title">
				@yield('title', 'Anasayfa')
			</div>
		</div>
		<div class="pull-right">
			<div class="header-item hidden-lg-up">
				<button id="mobileMenu" class="navbar-toggler">
					<i class="fa fa-bars"></i>
				</button>
			</div>
		</div>
	</div>
	
	<!-- bottom -->
	<div class="bottom">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{ MinecraftServer::name() }}</a></li>
			@yield('breadcrumb')
			<li class="breadcrumb-item active">@yield('title', 'Anasayfa')</li>
		</ol>
	</div>
</header>