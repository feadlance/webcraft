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
			@if ( is_array($__env->yieldContent('breadcrumb')) )
				@foreach ( $__env->yieldContent('breadcrumb') as $value )
					@if ( isset($value[0]) && isset($value[1]) )
						<li class="breadcrumb-item"><a href="{{ $value[0] }}">{{ $value[1] }}</a></li>
					@endif
				@endforeach
			@endif
			<li class="breadcrumb-item active">@yield('title', 'Anasayfa')</li>
		</ol>
	</div>
</header>