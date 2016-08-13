@extends('templates.app')

@section('title', 'Ölüm Detayları')

@section('breadcrumb')
	<li><a href="{{ route('users') }}">Oyuncular</a></li>
	<li><a href="{{ route('profile', ['player' => $user->username]) }}">{{ $user->getDisplayName() }}</a></li>
	<li>Ölüm Detayları</li>
@stop

@section('container')
	<div class="panel">
		<div class="content">
			<h3 style="font-family: 'Titillium Web', arial; font-weight: normal;">
				<strong>{{ $user->getDisplayName() }}</strong> oyuncusunu öldüren canlılar
				<small>toplam {{ $user->game()->playerDeaths('ALL', true) }}</small>
			</h3>
		</div>
	</div>
	@if ( $from_players->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Oyuncular
				<small>({{ $user->game()->playerDeaths('PLAYER', true) }})</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $from_players as $from_player )
						<li class="clear-after">
							<div class="avatar">
								<img src="{{ $from_player->killer()->getAvatar(40) }}" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="{{ route('profile', ['player' => $from_player->killer()->username]) }}">
										<strong>{{ $from_player->killer()->getDisplayName() }}</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $from_player->total }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
	
	@if ( $from_monsters->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Yaratıklar
				<small>({{ $user->game()->playerDeaths('MONSTERS', true) }})</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $from_monsters as $from_monster )
						<li class="clear-after">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('minecraft.' . $from_monster->cause)</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $from_monster->value }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif

	@if ( $from_others->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Diğer Sebepler
				<small>({{ $user->game()->playerDeaths('OTHERS', true) }})</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $from_others as $from_other )
						<li class="clear-after">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('minecraft.' . $from_other->cause)</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $from_other->value }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
@stop