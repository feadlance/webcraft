@extends($template . '.partials.app')

@section('title', 'Ödeme Başarılı!')

@section('container')
	<div class="card">
		<div class="card-block">
			Ödemeyi başarıyla tamamladın! Şuan hesabında {{ Auth::user()->getMoney() }}₺ bulunmakta.
		</div>
	</div>
@stop