@extends('auth.default')

@section('container')
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Kayıt onayı</h3>
						<p>Robot olmadığınızı bize gösterin.</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-user"></i>
					</div>
				</div>
				<div class="form-bottom">
					<strong>{{ Session::get('verify_email') }}</strong> adresine gönderdiğimiz postada ki bağlantıyı açarak üyeliğinizi aktif etmelisiniz.
				</div>
			</div>
		</div>
	</div>
@stop