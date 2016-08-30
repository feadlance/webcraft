@extends($template . '.partials.app')

@section('title', 'Öldürme Detayları')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('users') }}">Oyuncular</a></li>
	<li class="breadcrumb-item"><a href="{{ route('profile', ['player' => $user->username]) }}">{{ $user->getDisplayName() }}</a></li>
@stop

@section('container')
	<h3 class="m-b-1">{{ TurkishGrammar::get($user->getDisplayName(), 'iyelik') }} öldürdükleri</h3>

	<div class="row">
		@if ( !$user->game()->playerKills('PLAYER', true) && !$killed_monsters->count() && !$killed_animals->count() )
			<div class="col-lg-12">
				<div class="card">
					<div class="card-block">
						<span class="text-muted">
							{{ $user->getDisplayName('firstname') }} henüz bir tavşan bile öldürememiş.<br>
						</span>
					</div>
				</div>
			</div>
		@endif

		@if ( $user->game()->playerKills('PLAYER', true) )
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						Oyuncular
						<small class="text-muted">{{ $user->game()->playerKills('PLAYER', true) }}</small>
					</div>
					<div class="card-block">
						<ul class="list-group-user">
							@foreach ( $killed_users as $killed_user )
								<li class="list-group-user-item clearfix">
									<div class="avatar">
										<img src="{{ $killed_user->victim()->getAvatar(40) }}" alt="User Avatar">
									</div>
									<div class="content">
										<div class="title">
											<a href="{{ route('profile', ['player' => $killed_user->victim()->username]) }}">
												<strong>{{ $killed_user->victim()->getDisplayName() }}</strong>
											</a>
										</div>
										<div class="body">
											{{ $killed_user->total }} kez
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif
		
		@if ( $killed_monsters->count() )
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						Yaratıklar
						<small class="text-muted">{{ $user->game()->playerKills('MONSTERS', true) }}</small>
					</div>
					<div class="card-block">
						<ul class="list-group-user">
							@foreach ( $killed_monsters as $killed_monster )
								<li class="list-group-user-item clearfix">
									<div class="avatar">
										<img src="{{ $killed_monster->getMobAvatar(40) }}" alt="User Avatar">
									</div>
									<div class="content">
										<div class="title">
											<strong>@lang('minecraft.' . $killed_monster->entityType)</strong>
										</div>
										<div class="body">
											{{ $killed_monster->value }} kez
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif
		

		@if ( $killed_animals->count() )
			<div class="col-lg-4">
				<div class="card">
					<div class="card-header">
						Hayvanlar
						<small class="text-muted">{{ $user->game()->playerKills('ANIMALS', true) }}</small>
					</div>
					<div class="card-block">
						<ul class="list-group-user">
							@foreach ( $killed_animals as $killed_animal )
								<li class="list-group-user-item clearfix">
									<div class="avatar">
										<img src="{{ $killed_animal->getMobAvatar(40) }}" alt="User Avatar">
									</div>
									<div class="content">
										<div class="title">
											<strong>@lang('minecraft.' . $killed_animal->entityType)</strong>
										</div>
										<div class="body">
											{{ $killed_animal->value }} kez
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
		@endif
	</div>
@stop