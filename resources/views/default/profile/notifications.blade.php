@extends($template . '.partials.app')

@section('title', 'Bildirimler')

@section('container')
	@foreach ( Auth::user()->notifications as $notification )
		<li>
			@include ($template . '.partials.notification.' . snake_case(class_basename($notification->type)), ['user' => Webcraft\Models\User::find($notification->data['user_id'])])
		</li>
	@endforeach
@stop