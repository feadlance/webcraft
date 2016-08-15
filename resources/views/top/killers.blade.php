@extends('templates.app')

@section('title', 'En İyi Katiller')

@section('container')
	<div class="panel" style="max-width: 50%; margin: 0 auto;">
		<div class="title">En iyi 100 katil</div>
		<div class="content" style="padding-bottom: 0;">
			@if ( $top100->count() )
				<ul class="user-killers clear-after">
					@foreach ( $top100 as $user )
						<li>
							<a href="{{ route('profile', ['player' => $user->user()->username]) }}" title="{{ $user->user()->getDisplayName() }}">
								<img src="{{ $user->user()->getAvatar(80) }}" alt="User Avatar">
							</a>
							<span>
								<strong>{{ $user->value }}</strong>
							</span>
						</li>
					@endforeach
				</ul>
			@else
				<p style="padding: 5px;">Aramızda hiç katil yok.</p>
			@endif
		</div>
	</div>
@stop