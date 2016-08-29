@extends($template . '.partials.app')

@section('title', 'Bildirimler')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="{{ route('profile', ['player' => Auth::user()->username]) }}">Hesap</a></li>
@stop

@section('container')	
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-block">
					@if ( Auth::user()->notifications->count() )
						<ul class="list-group-user notification">
							@foreach ( Auth::user()->notifications as $notification )
								@include ($template . '.partials.notification.' . snake_case(class_basename($notification->type)), [
									'user' => Webcraft\Models\User::find($notification->data['user_id'])
								])
							@endforeach

							{{ Auth::user()->unreadNotifications->markAsRead() }}
						</ul>
					@else
						<p class="text-muted m-b-0">Hiç bildirimin yok.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop