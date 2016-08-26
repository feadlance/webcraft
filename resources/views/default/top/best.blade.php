@extends($template . '.partials.app')

@section('title', 'En İyi Katiller')

@section('container')
	<div class="col-lg-8 offset-lg-2">
		<div class="card">
			<div class="card-header">En İyi Oyuncular</div>
			<div class="card-block">
				@if ( $bestUsers->count() )
					<ul class="list-group-user">
						@foreach ( $bestUsers as $user )
							<li class="list-group-user-item inline col-lg-6">
								<div class="avatar">
									<img src="{{ $user->getUser()->getAvatar(40) }}" alt="User Avatar">
								</div>
								<div class="content">
									<div class="title">
										<a href="{{ route('profile', ['player' => $user->getUser()->username]) }}">
											<strong>{{ $user->getUser()->getDisplayName() }}</strong>
										</a>
									</div>
									<div class="body text-muted">
										{{ $user->point }} puan
									</div>
								</div>
							</li>
						@endforeach
					</ul>
				@else
					<p class="text-muted m-b-0">Aramızda hiç katil yok.</p>
				@endif
			</div>
		</div>
	</div>
@stop