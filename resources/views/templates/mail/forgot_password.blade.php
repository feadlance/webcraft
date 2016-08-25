<!DOCTYPE html>
<html>
	<head>
	</head>
	<body style="background:#f7f7f7;text-align:center;">
		<h1 style="padding-top:20px;color:#000;">
			Şifremi Unuttum
		</h1>
		<div style="padding: 15px;background:#fff;font-size:14px;width:30%;margin:0 auto;color:#000;">
			<p style="margin-bottom:15px;">Görünüşe göre hesabının şifresini unuttun. Sana hemen yeni bir tane veriyorum.</p>
			<a href="{{ route('auth.forgot_password.new', ['email' => urlencode($user->email), 'token' => urlencode($user->action_token)]) }}" style="background:#008dd0;padding:15px;text-align:center;display:block;border-radius:10px;color:#fff;font-size:17px;text-decoration:none;width:300px;margin:0 auto;">Şifremi Sıfırla</a>
		</div>
		<div style="background:#efefef;padding:10px;font-size:17px;color:#848484;width:30%;margin:0 auto;">
			{{ MinecraftServer::name() }}
		</div>
	</body>
</html>