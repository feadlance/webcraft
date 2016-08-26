@extends($template . '.auth.default')

@section('title', 'Yeni e-Posta')

@section('container')
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Yeni bir e-posta belirleyin</h3>
						<p>Görünüşe göre henüz bir e-posta adresiniz yok.</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-key"></i>
					</div>
				</div>
				<div id="login-form-error"></div>
				<form class="form-bottom" action="{{ route('auth.email') }}" method="post" autocomplete="off">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<div id="email_group" class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
						<label class="sr-only" for="email">e-Posta Adresi</label>
						<input type="text" placeholder="e-Posta adresiniz..." value="{{ old('email') }}" class="form-email form-control{{ $errors->has('email') ? ' form-control-danger' : '' }}" name="email" id="email">
						{!! $errors->has('email') ? '<span class="form-control-feedback">' . $errors->first('email') . '</span>' : '' !!}
					</div>
					<button class="btn" style="width: 100%;">Bu benim yeni e-postam</button>
				</form>
			</div>
		</div>
	</div>
@stop