<header>
	<!-- top -->
	<div class="top">
		<div class="page-title">
			@yield('title', 'Anasayfa')
		</div>
	</div>
	
	<!-- bottom -->
	<div class="bottom">
		<ul class="breadcrumb">
			<li><a href="/">{{ MinecraftServer::name() }}</a></li>
			@yield('breadcrumb')
			<li>@yield('title', 'Anasayfa')</li>
		</ul>
	</div>
</header>