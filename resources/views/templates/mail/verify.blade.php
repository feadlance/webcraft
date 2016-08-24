Sunucumuza hoşgeldin <strong>{{ $user->username }}</strong>,<br>
Kaydını onaylamak için hemen tıkla:<br>
<a href="{{ $link = route('auth.verify', ['email' => urlencode($user->email)]) }}?token={{ $user->action_token }}">
	{{ $link = route('auth.verify', ['email' => $user->email]) }}
</a>