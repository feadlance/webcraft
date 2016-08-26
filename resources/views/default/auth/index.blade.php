@extends($template . '.auth.default')

@section('container')
	<div class="row">
		<div class="col-sm-8 offset-sm-2 text">
			<h1><strong>Sunucumuza</strong> sizi de davet ediyoruz</h1>
			<div class="description">
				<p>
					Profesyonel sunucumuzda müthiş eğlence için ilk deneyiminiz ise sağ taraftaki <strong>"kayıt"</strong> formu ile kayıt olabilir, daha önce kayıt olduysanız soldaki <strong>"giriş"</strong> formunu kullanarak giriş yapabilirsiniz. <strong>İyi eğlenceler!</strong>
				</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-5">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Sisteme giriş yapın</h3>
						<p>Kullanıcı adınızı ve şifrenizi yazın:</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-key"></i>
					</div>
				</div>
				<div id="login-form-error"></div>
				<form class="form-bottom" autocomplete="off" onsubmit="return signIn(this);">
					<div id="username_group" class="form-group">
						<label class="sr-only" for="username">Kullanıcı adı</label>
						<input type="text" placeholder="Kullanıcı adı..." class="form-username form-control" name="username" id="username">
						<span class="form-control-feedback"></span>
					</div>
					<div id="password_group" class="form-group">
						<label class="sr-only" for="password">Şifre</label>
						<input type="password" placeholder="Şifre..." class="form-password form-control" name="password" id="password">
						<span class="form-control-feedback"></span>
					</div>
					<div class="form-group">
						<a href="{{ route('auth.forgot_password') }}">Şifremi hatırlamıyorum</a>
					</div>
					<button class="btn" style="width: 100%;">Hazırım!</button>
					<div class="loading-content">
						<i class="fa fa-spin fa-circle-o-notch"></i>
					</div>
				</form>
			</div>
			<div class="social-login">
				<h3>...daha hızlı giriş yapın:</h3>
				<div class="social-login-buttons">
					<a class="btn btn-link-1 btn-link-1-facebook" href="#">
					<i class="fa fa-facebook"></i> Facebook
					</a>
					<a class="btn btn-link-1 btn-link-1-twitter" href="#">
					<i class="fa fa-twitter"></i> Twitter
					</a>
					<a class="btn btn-link-1 btn-link-1-google-plus" href="#">
					<i class="fa fa-google-plus"></i> Google Plus
					</a>
				</div>
			</div>
		</div>
		<div class="col-sm-1 middle-border"></div>
		<div class="col-sm-1"></div>
		<div class="col-sm-5">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Şimdi kayıt olun</h3>
						<p>Eğlenceye çok az kaldı:</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-pencil"></i>
					</div>
				</div>
				<div id="register-form-error"></div>
				<form class="form-bottom" autocomplete="off" onsubmit="return signUp(this);">
					<div id="register_email_group" class="form-group">
						<label class="sr-only" for="register_email">e-Posta</label>
						<input type="text" placeholder="e-Posta..." class="form-control" id="register_email">
						<span class="form-control-feedback"></span>
					</div>
					<div id="register_username_group" class="form-group">
						<label class="sr-only" for="register_username">Kullanıcı Adı</label>
						<input type="text" placeholder="Kullanıcı adı..." class="form-control" id="register_username">
						<span class="form-control-feedback"></span>
					</div>
					<div id="register_password_group" class="form-group">
						<label class="sr-only" for="register_password">Şifre</label>
						<input type="password" placeholder="Şifre..." class="form-control" id="register_password">
						<span class="form-control-feedback"></span>
					</div>
					<div id="register_password_confirm_group" class="form-group">
						<label class="sr-only" for="register_password_confirm">Şifre</label>
						<input type="password" placeholder="Şifrenizin Tekrarı..." class="form-control" id="register_password_confirm">
						<span class="form-control-feedback"></span>
					</div>
					<div id="register_captcha_group" class="form-group">
						{!! app('captcha')->display(); !!}
						<span class="form-control-feedback"></span>
					</div>
					<button id="signup_submit" type="submit" class="btn" style="width: 100%;">
						<i class="fa fa-check" style="margin-right: 5px;"></i>
						Bilgileri Doldurdum
					</button>
					<div class="loading-content">
						<i class="fa fa-spin fa-circle-o-notch"></i>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop