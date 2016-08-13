@extends('templates.app')

@section('container')
	<div class="panel">
		<div class="content">
			<h3 style="font-family: 'Titillium Web', arial; font-weight: normal;">
				<strong>{{ $user->getDisplayName() }}</strong> oyuncusunun öldürdüğü canlılar
			</h3>
		</div>
	</div>
	@if ( $killed_users->count() )
		<div style="width: 25%; margin-right: 5px; float: left;" class="panel m-t-5">
			<div class="title">Öldürdüğü Oyuncular</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_users as $killed_user )
						<li class="clear-after">
							<div class="avatar">
								<img src="https://minotar.net/avatar/{{ $killed_user->victim()->username }}/40" alt="User Avatar">
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
			<div class="title">Öldürdüğü Yaratıklar</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_monsters as $killed_monster )
						<li class="clear-after">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('mc_entity.' . $killed_monster->entityType)</strong>
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
			<div class="title">Öldürdüğü Hayvanlar</div>
			<div class="content">
				<ul class="list-users">
					@foreach ( $killed_animals as $killed_animal )
						<li class="clear-after">
							<div class="avatar">
								<img src="https://minotar.net/avatar/default/40" alt="User Avatar">
							</div>
							<div class="detail">
								<div class="title">
									<a href="#">
										<strong>@lang('mc_entity.' . $killed_animal->entityType)</strong>
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