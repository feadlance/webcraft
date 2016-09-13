@extends($template . '.partials.app')

@section('title', $user->getDisplayName())

@section('header')
	<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">
@stop

@section('breadcrumb', [
	[route('users'), 'Oyuncular']
])

@section('container')
	<div class="row">
		<div class="col-lg-3">
			<div id="user-profile-card">
				<div class="card-cover">
					<img src="templates/{{ $template }}/images/cover.jpg" alt="User Cover">
				</div>
				<div class="card-content">
					<div class="left">
						<div class="avatar">
							<img src="{{ $user->getAvatar(60) }}" alt="User Avatar">
						</div>
						<div class="title">
							{{ $user->getDisplayName() }}
						</div>
					</div>
					<div class="right">
						<div class="friend-actions">
							@if ( Auth::user()->hasFriendRequestPending($user) )
								<div class="btn-group">
									<button class="btn btn-secondary">
										<i class="fa fa-check"></i>
										İstek Gönderildi
									</button>
									<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu">
										<a href="#" onclick="return deleteFriend(this, {{ $user->id }});" class="dropdown-item">İsteği İptal Et</a>
									</div>
								</div>
							@elseif ( Auth::user()->hasFriendRequestReceived($user) )
								<button class="btn btn-danger" onclick="return acceptFriend(this, {{ $user->id }});">
									<i class="fa fa-thumbs-up"></i>
									İsteği Kabul Et
								</button>
							@elseif ( Auth::user()->isFriendsWith($user) )
								<div class="btn-group">
									<button class="btn btn-secondary">
										<i class="fa fa-check"></i>
										Arkadaşsınız
									</button>
									<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="sr-only">Toggle Dropdown</span>
									</button>
									<div class="dropdown-menu">
										<a href="#" onclick="return deleteFriend(this, {{ $user->id }});" class="dropdown-item">Arkadaşlıktan Çıkart</a>
									</div>
								</div>
							@elseif ( Auth::id() !== $user->id )
								<button class="btn btn-secondary" onclick="return addFriend(this, {{ $user->id }});">
									<i class="fa fa-user-plus"></i>
									Arkadaşlık İsteği Gönder
								</button>
							@endif
						</div>
					</div>
				</div>
				<div class="card-footer">
					@if ( $user->city || $user->getSex() )
						<div class="top">
							{{ $user->city ? $user->city . ', ' : '' }}
							{{ $user->getSex() ? $user->getSex() : '' }}
						</div>
					@endif
					@if ( $user->about )
						<div class="bottom">
							{{ $user->about }}
						</div>
					@endif
				</div>
			</div>
			<div id="game-stats" class="card">
				<div class="card-header">Oyun İstatistikleri</div>
				<div class="card-block">
					@if ( $user->game() )
						<div class="stats-inline clearfix">
							<div class="stats-section">
								<a href="{{ route('profile.killed', ['player' => $user->username]) }}" data-toggle="tooltip" data-html="true" title="{{ $user->game()->playerKills('PLAYER', true) }} oyuncu<br>{{ $user->game()->playerKills('MONSTERS', true) }} yaratık<br>{{ $user->game()->playerKills('ANIMALS', true) }} hayvan">
									<span>Öldürme</span>
									{{ $user->game()->playerKills('ALL', true) }}
								</a>
							</div>
							<div class="stats-section">
								<a href="{{ route('profile.death', ['player' => $user->username]) }}" data-toggle="tooltip" title="Tüm Detaylar">
									<span>Ölüm</span>
									{{ $user->game()->playerDeaths('ALL', true) }}
								</a>
							</div>
						</div>
						<div class="stats-inline clearfix">
							<div class="stats-section">
								<span>Oyun Parası</span>
								{{ $user->game()->balance(true) }}
							</div>
							<div class="stats-section">
								<span>Oynama Süresi</span>
								{{ $user->game()->playTime() }}
							</div>
						</div>
						<div class="stats-section">
							<span>Oyun Puanı</span>
							{{ $user->game()->point }}
						</div>
					@else
						<span style="color: #afafaf; padding: 1.25rem; display: block;">Oyun verisi henüz oluşmamış.</span>
					@endif
				</div>
			</div>
		</div>
		<div class="col-lg-5">
			@include($template . '.partials.status.share')

			<div id="statuses">
				@foreach ( $statuses as $status )
					@include($template . '.partials.status.status')
				@endforeach
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="templates/{{ $template }}/components/autosize/autosize.min.js"></script>
	<script type="text/javascript" src="templates/{{ $template }}/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">var player = '{{ $user->username }}', avatar = '{{ Auth::user()->getAvatar(40) }}', avatar_35 = '{{ Auth::user()->getAvatar(35) }}';autosize($('#status_form .form-control'));</script>
	<script type="text/javascript" src="templates/{{ $template }}/js/request.js"></script>
@stop