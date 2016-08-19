@extends('templates.app')

@section('container')
	<div class="row">
		<div class="col-lg-3">
			@if ( $online_users->count() )
				<div class="card">
					<div class="card-header">
						Çevrimiçi Oyuncular
						<small>({{ $online_users->count() }})</small>
					</div>
					<div class="card-block">
						<div class="row">
							@foreach ( $online_users as $online_user )
								<div class="col-lg-2">
									<a href="{{ route('profile', ['player' => $online_user->username]) }}" data-toggle="tooltip" title="{{ $online_user->getDisplayName() }}" style="display: block; text-align: center;">
										<img src="{{ $online_user->getAvatar(57) }}" alt="User Avatar" style="border-radius: 5px;">
									</a>
								</div>
							@endforeach
							@if ( $online_users->count() >= 5 )
								<div class="col-lg-2">
									<a href="{{ route('users', ['filtrele' => 'oyunda']) }}">
										<i class="fa fa-arrow-right"></i>
									</a>
								</div>
							@endif
						</div>
					</div>
				</div>
			@endif
			@if ( $top5_users->count() )
				<div class="card">
					<div class="card-header">En iyi 5 katil</div>
					<div class="card-block">
						<ul class="list-group-user">
							@foreach ( $top5_users as $top5_user )
								<li class="list-group-user-item clearfix">
									<div class="avatar">
										<img src="{{ $top5_user->user()->getAvatar(40) }}" alt="User Avatar">
									</div>
									<div class="content">
										<div class="title">
											<a href="{{ route('profile', ['player' => $top5_user->user()->username]) }}">
												<strong>{{ $top5_user->user()->getDisplayName() }}</strong>
											</a>
										</div>
										<div class="body">
											{{ $top5_user->value }} leş
										</div>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endif
		</div>
		<div class="col-lg-5">
			<!-- share post -->
			@include('templates.status.share')

			<!-- statuses -->
			<div id="statuses">
				@foreach ( $statuses as $status )
					@include('templates.status.status')
				@endforeach
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="assets/components/autosize/autosize.min.js"></script>
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">var player = '', avatar = '{{ Auth::user()->getAvatar(40) }}', avatar_35 = '{{ Auth::user()->getAvatar(35) }}';autosize($('#status_form .form-control'));</script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop