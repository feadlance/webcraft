@extends('auth.default')

@section('title', 'Yeni Şifreniz')

@section('container')
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Tebrikler!</h3>
						<p>Hesabınızı kurtardınız, şimdi şifrenizi değiştirin.</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-key"></i>
					</div>
				</div>
				<div id="forgot-form-error"></div>
				<form class="form-bottom" method="post" autocomplete="off" onsubmit="return forgotNewPassword(this);">
					<div id="password_group" class="form-group">
						<label class="sr-only" for="password">Yeni Şifreniz</label>
						<input type="password" placeholder="Şifreniz..." class="form-password form-control" name="password" id="password">
						<span class="form-control-feedback"></span>
					</div>
					<div id="password_confirm_group" class="form-group">
						<label class="sr-only" for="password_confirm">Yeni Şifreniz</label>
						<input type="password" placeholder="Şifreniz..." class="form-password_confirm form-control" name="password_confirm" id="password_confirm">
						<span class="form-control-feedback"></span>
					</div>
					<button class="btn" style="width: 100%;">Şifremi Değiştir</button>
					<div class="loading-content">
						<i class="fa fa-spin fa-circle-o-notch"></i>
					</div>
					<input type="hidden" id="email" name="email" value="{{ $email }}">
					<input type="hidden" id="token" name="token" value="{{ request('token') }}">
				</form>
			</div>
		</div>
	</div>
@stop