@extends($template . '.partials.app')

@section('title', 'Oyuncular')

@section('container')
	<div class="col-lg-8 offset-lg-2">
		<div class="card">
			<div class="card-header">Oyuncular</div>
			<div class="card-block">
				@if ( $users->count() )
					<ul class="list-group-user">
						@foreach ( $users as $user )
							<li class="list-group-user-item inline col-lg-6 clearfix">
								<div class="avatar">
									<img src="{{ $user->getAvatar(40) }}" alt="User Avatar">
								</div>
								<div class="content">
									<div class="title">
										<a href="{{ route('profile', ['player' => $user->username]) }}">
											<strong>{{ $user->getDisplayName() }}</strong>
										</a>
									</div>
									<div class="body">
										{!! $user->game() && $user->game()->online() ? '<span class="text-success">çevrimiçi</span>' : '<span class="text-muted">çevrimdışı</span>' !!}
									</div>
								</div>
							</li>
						@endforeach
					</ul>
				@else
					<p class="text-muted m-b-0">{{ request('filtrele') === 'oyunda' ? 'Şuan oyunda kimse yok.' : 'Kayıtlı hiç oyuncu yok.' }}</p>
				@endif
			</div>
		</div>
	</div>
@stop