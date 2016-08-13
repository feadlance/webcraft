<header>
	<div class="logo">
		<a href="/">{{ env('SITE_NAME') }}</a>
	</div>

	<div class="container">
		<div class="page-title">
			@yield('title', 'Anasayfa')
		</div>

		<div class="search-form">
			<form action="" method="get" autocomplete="off">
				<input type="text" name="q" placeholder="Ara bişeyler.." class="input-search">
				<i id="close-search-form" class="fa fa-times header-item"></i>
			</form>
		</div>

		<div id="open-search-form" class="header-item search-toggle">
			<i class="fa fa-search"></i>
		</div>

		<div class="header-item user-control">
			<span class="title">{{ Auth::user()->getDisplayName() }}</span>
			<img class="user-avatar" src="{{ Auth::user()->getAvatar(60) }}" alt="{{ Auth::user()->getDisplayName() }}">

			<!--<ul class="user-actions">
				<li><a href="#">Profil</a></li>
				<li><a href="#">Ayarlar</a></li>
			</ul>-->
		</div>
	</div>
</header>