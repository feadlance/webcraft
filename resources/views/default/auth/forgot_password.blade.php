@extends($template . '.auth.default')

@section('title', 'Şifremi Hatırlamıyorum')

@section('container')
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Şifrenizi mi unuttunuz?</h3>
						<p>Hesabınızın e-posta adresini yazın.</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-key"></i>
					</div>
				</div>
				<div id="forgot-form-error"></div>
				<form class="form-bottom" method="post" autocomplete="off" onsubmit="return forgotPassword(this);">
					<div id="email_group" class="form-group">
						<label class="sr-only" for="email">e-Posta Adresi</label>
						<input type="text" placeholder="e-Posta adresiniz..." class="form-email form-control" name="email" id="email">
						<span class="form-control-feedback"></span>
					</div>
					<button class="btn" style="width: 100%;">Şifremi Sıfırla</button>
					<div class="loading-content">
						<i class="fa fa-spin fa-circle-o-notch"></i>
					</div>
				</form>
			</div>
		</div>
	</div>
@stop