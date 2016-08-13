@extends('templates.app')

@section('container')
	<div style="float: left; width: 500px; margin-right: 5px;">
		@if ( $online_users->count() )
			<div class="panel m-b-5">
				<div class="title">Çevrimiçi Oyuncular <small>({{ $online_users->count() }})</small></div>
				<div class="content">
					<ul class="list-user-avatar clear-after">
						@foreach ( $online_users as $online_user )
							<li title="{{ $online_user->username }}">
								<a href="{{ route('profile', ['player' => $online_user->username]) }}">
									<img src="{{ $online_user->getAvatar(66) }}" alt="User Avatar">
								</a>
							</li>
						@endforeach
						@if ( $online_users->count() >= 6 )
							<li class="ui icon more button" title="Tüm Çevrimiçi Oyuncular" style="padding: 0;">
								<a href="{{ route('users') }}?filtrele=oyunda"><i class="fa fa-arrow-right"></i></a>
							</li>
						@endif
					</ul>
				</div>
			</div>
		@endif
		@if ( $top5_users->count() )
			<div class="panel">
				<div class="title">Ölüm Makineleri</div>
				<div class="content">
					<ul class="list-users">
						@foreach ( $top5_users as $top5_user )
							<li class="clear-after">
								<div class="avatar">
									<img src="{{ $top5_user->user()->getAvatar(40) }}" alt="User Avatar">
								</div>
								<div class="detail">
									<div class="title">
										<a href="{{ route('profile', ['player' => $top5_user->user()->username]) }}">
											<strong>{{ $top5_user->user()->getDisplayName() }}</strong>
										</a>
									</div>
									<div class="description">
										<strong>{{ $top5_user->value }}</strong> leş.
									</div>
								</div>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		@endif
	</div>
	<div class="profile-post" style="margin: 0;">
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