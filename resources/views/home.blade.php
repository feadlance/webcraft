@extends('templates.app')

@section('container')
	<div class="row">
		<div class="col-lg-3">
			@if ( $online_users->count() )
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="panel-title">
							Çevrimiçi Oyuncular
							<small>({{ $online_users->count() }})</small>
						</div>
					</div>
					<div class="panel-body">
						@foreach ( $online_users as $online_user )
							<div class="col-lg-2" title="{{ $online_user->username }}">
								<a href="{{ route('profile', ['player' => $online_user->username]) }}">
									<img src="{{ $online_user->getAvatar(66) }}" alt="User Avatar">
								</a>
							</div>
						@endforeach
						@if ( $online_users->count() >= 5 )
							<div class="col-lg-2" title="Tüm Çevrimiçi Oyuncular">
								<a href="{{ route('users', ['filtrele' => 'oyunda']) }}">
									<i class="fa fa-arrow-right"></i>
								</a>
							</div>
						@endif
					</div>
				</div>
			@endif
			@if ( $top5_users->count() )
				<div class="panel panel-custom">
					<div class="panel-heading">
						<div class="panel-title">En iyi 5 katil</div>
					</div>
					<div class="panel-body">
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
	<script type="text/javascript">var player = '{{ $user->username }}';autosize($('#status_form .form-control'));</script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop