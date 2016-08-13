@extends('templates.app')

@section('title', $user->getDisplayName())

@section('breadcrumb')
	<li><a href="{{ route('users') }}">Oyuncular</a></li>
	<li>{{ $user->getDisplayName() }}</li>
@stop

@section('container')
	<div class="profile-detail">
		<div class="header">
			<img class="cover" src="assets/images/cover.jpg" alt="Cover">
			<img class="avatar" src="{{ $user->getAvatar(70) }}" alt="User Avatar">
			<span class="title">{{ $user->getDisplayName() }}</span>
			@if ( Auth::id() !== $user->id )
				<div class="friend-actions">
					@if ( Auth::user()->hasFriendRequestPending($user) )
						<button class="ui blue transparent button" style="cursor: text;">
							<i class="fa fa-check" style="margin-right: 5px;"></i>
							İstek gönderildi
						</button>
					@elseif ( Auth::user()->hasFriendRequestReceived($user) )
						<button id="accept_friend" class="ui yellow transparent button">
							<i class="fa fa-thumbs-up" style="margin-right: 5px;"></i>
							İsteği kabul et
						</button>
					@elseif ( Auth::user()->isFriendsWith($user) )
						<button id="delete_friend" class="ui red transparent button">
							<i class="fa fa-times" style="margin-right: 5px;"></i>
							Arkadaşlıktan çıkar
						</button>
					@else
						<button id="add_friend" class="ui red transparent button">
							<i class="fa fa-user-plus" style="margin-right: 5px;"></i>
							Arkadaş olarak ekle
						</button>
					@endif
				</div>
			@endif
		</div>
		<ul class="panel-content-list">
			<li>
				<span>Şuanda {!! $user->game() && $user->game()->online() ? '<strong style="color: green;">oyunda.</strong>' : '<strong>oyunda değil.</strong>' !!}</span>
			</li>
			<li>
				<span>Hakkında</span>
				@if ( $user->about )
					{{ $user->about }}
				@else
					<i class="fa fa-minus"></i>
				@endif
			</li>
			<li>
				<span>Şehir</span>
				@if ( $user->city )
					{{ $user->city }}
				@else
					<i class="fa fa-minus"></i>
				@endif
			</li>
			<li>
				<span>Cinsiyet</span>
				@if ( $user->getSex() )
					{{ $user->getSex() }}
				@else
					<i class="fa fa-minus"></i>
				@endif
			</li>
		</ul>
		<!--<div class="panel m-t-5">
			<div class="title">Medya</div>
			<div class="content" style="padding: 5px 5px 0 5px;">
				<ul class="media">
					<li><img src="" alt=""></li>
				</ul>
			</div>
		</div>-->
		<div class="panel" style="margin-top: 5px;">
			<div class="title">Oyun İstatistikleri</div>
			@if ( $user->game() )
				<ul class="content">
					<li>
						<span>
							Öldürme
							<small><a href="{{ route('profile.killed', ['player' => $user->username]) }}">(detaylı)</a></small>
						</span>
						{{ $user->game()->playerKills('ALL', true) }} oyuncu - yaratık - hayvan
					</li>
					<li>
						<span>
							Ölüm
							<small><a href="{{ route('profile.death', ['player' => $user->username]) }}">(detaylı)</a></small>
						</span>
						{{ $user->game()->playerDeaths('ALL', true) }} kez
					</li>
					<li>
						<span>Oynama Süresi</span>
						{{ $user->game()->playTime() }} saniye
					</li>
				</ul>
			@else
				<div class="content" style="padding: 10px; color: #afafaf;">
					Hiç veri yok.
				</div>
			@endif
		</div>
	</div>
	<div class="profile-post">
		@include('templates.status.share')
		<div class="posts">
			@foreach ( $statuses as $status )
				@include('templates.status.statuses')
			@endforeach
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$('.ui.dropdown').dropdown();
		var player = '{{ $user->username }}';
	</script>
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop