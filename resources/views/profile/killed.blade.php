@extends('templates.app')

@section('title', 'Öldürme Detayları')

@section('breadcrumb')
	<li><a href="{{ route('users') }}">Oyuncular</a></li>
	<li><a href="{{ route('profile', ['player' => $user->username]) }}">{{ $user->getDisplayName() }}</a></li>
@stop

@section('container')
	<div class="panel">
		<div class="content">
			<h3 style="font-family: 'Titillium Web', arial; font-weight: normal;">
				{{ TurkishGrammar::get($user->getDisplayName(), 'iyelik') }} öldürdüğü canlılar
				<small style="display: block; color: #8a8a8a;">Toplam {{ $user->game()->playerKills('ALL', true) }}</small>
			</h3>
		</div>
	</div>
	@if ( $killed_users->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Oyuncular
				<small style="color: #8a8a8a;">Toplam: {{ $user->game()->playerKills('PLAYER', true) }}</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_users as $killed_user )
						<li class="clearfix">
							<div class="avatar">
								<img src="{{ $killed_user->victim()->getAvatar(40) }}" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="{{ route('profile', ['player' => $killed_user->victim()->username]) }}">
										<strong>{{ $killed_user->victim()->getDisplayName() }}</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $killed_user->total }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
	
	@if ( $killed_monsters->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Yaratıklar
				<small style="color: #8a8a8a;">Toplam: {{ $user->game()->playerKills('MONSTERS', true) }}</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_monsters as $killed_monster )
						<li class="clearfix">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('minecraft.' . $killed_monster->entityType)</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $killed_monster->value }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
	

	@if ( $killed_animals->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">
				Hayvanlar
				<small style="color: #8a8a8a;">Toplam: {{ $user->game()->playerKills('ANIMALS', true) }}</small>
			</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_animals as $killed_animal )
						<li class="clearfix">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('minecraft.' . $killed_animal->entityType)</strong>
									</a>
								</div>
								<div class="description">
									<strong>{{ $killed_animal->value }}</strong> kez
								</div>
							</div>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
	@endif
@stop