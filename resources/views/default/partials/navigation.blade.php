<nav>
	<div class="logo">
		<a href="/">{{ MinecraftServer::name() }}</a>
	</div>
	
	<!--
	@if ( Auth::user()->isVerified() !== true )
		<div class="widget hide-768">
			<div class="ui warning message">
			  <div class="header">
			    hesabın kısıtlı.
			  </div>
			  e-posta adresine gönderdiğmiz bağlantıya tıklayarak hesabını doğrulamalısın.
			</div>
		</div>
	@endif
	<div class="widget hide-768" style="border-bottom: 0;">
		<div class="ui card">
			<div class="ui slide masked image">
				<img style="position: absolute; bottom: 50%; left: 50%; margin-bottom: -100px; margin-left: -50px; width: 100px;" src="{{ Auth::user()->getSkin(100) }}" alt="{{ Auth::user()->username }}">
				<img src="assets/images/skin-backgrounds/1.png" alt="Avatar Background">
			</div>
			<div class="content">
				<a class="header">{{ Auth::user()->username }}</a>
				<div class="meta">
					<ul class="user-balance">
						<li>
							oyun parası
							<span>
								<i class="fa fa-money"></i>
								{{ Auth::user()->getBalance(true) ?: '0.00' }}
							</span>
						</li>
						<li>
							gerçek para
							<span>
								<i class="fa fa-turkish-lira"></i>
								{{ Auth::user()->getMoney() }}
							</span>
						</li>
					</ul>
				</div>
			</div>
			<div class="extra content">
				@if ( Auth::user()->game() )
					@if ( Auth::user()->game()->online() )
						<span style="color: green;">
							<i class="fa fa-circle" style="margin-right: 3px; vertical-align: middle;"></i>
							çevrimiçi
						</span>
					@elseif ( Auth::user()->game()->lastLogin() === 'firstlogin' )
						Sunucuya hiç girmediniz.
					@else
						<i class="fa fa-circle" style="margin-right: 3px; vertical-align: middle;"></i>
						{{ Auth::user()->game()->lastLogin() }}
					@endif
				@else
					Sunucuya hiç girmediniz.
				@endif
			</div>
		</div>
	</div>
	-->

	<div class="widget" style="border-bottom: 0;">
		<ul class="navigation-menu">
			<li{!! Request::route()->getName() == 'home' ? ' class="active"' : '' !!}>
				<a href="{{ route('home') }}">Anasayfa</a>
			</li>
			<li{!! Request::route()->getName() == 'market' ? ' class="active"' : '' !!}>
				<a href="#">Market</a>
			</li>
			<li{!! Request::route()->getName() == 'profile' ? ' class="active"' : '' !!}>
				<a href="{{ route('profile', ['player' => Auth::user()->username]) }}">Profilim</a>
			</li>
			<li{!! Request::route()->getName() == 'users' ? ' class="active"' : '' !!}>
				<a href="{{ route('users') }}">Oyuncular</a>
			</li>
			<li{!! Request::route()->getName() == 'payment' ? ' class="active"' : '' !!}>
				<a href="{{ route('payment') }}">Kredi Yükle</a>
			</li>
			<li{!! Request::route()->getName() == 'upgrade' ? ' class="active"' : '' !!}>
				<a href="{{ route('upgrade') }}">Hesabımı Yükselt</a>
			</li>
			<li>
				<a href="{{ route('auth.signout') }}">Çıkış Yap</a>
			</li>
		</ul>
	</div>

	<div class="bottom">
		Copyright, 2016
	</div>
</nav>