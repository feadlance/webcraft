<div class="card">
	<div class="image" style="background: url('assets/images/cover.jpg'); height: 80px;">
		<img src="{{ $user->getAvatar(60) }}">
	</div>
	<div class="content text-center">
		<a class="header" href="{{ route('profile', ['player' => $user->username]) }}">
			@if ( $user->game() && $user->game()->online() )
				<i class="fa fa-circle"></i>
			@endif

			{{ Auth::id() === $user->id ? 'ben' : $user->getDisplayName() }}
		</a>
	</div>
</div>