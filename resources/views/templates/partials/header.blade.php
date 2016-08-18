<header>
	<!-- top -->
	<div class="top">
		<div class="page-title">
			@yield('title', 'Anasayfa')
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