@extends($template . '.partials.app')

@section('title', 'Kredi Yükle')

@section('container')
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="alert alert-warning">
				<strong>Dikkat!</strong>
				İşlemleri tamamladıktan sonra krediniz maksimum 4-5 dakika içerisinde hesabınıza yüklenir.
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-header">Hesabınıza Kredi Yükleyin</div>
				<div class="card-block">
					<form action="https://batihost.com/vipgateway/viprec.php" method="post" autocomplete="off">
						<input type="hidden" name="oyuncu" value="{{ Auth::user()->getDisplayName() }}">
						<input type="hidden" name="odemeolduurl" value="{{ route('payment.success') }}">
						<input type="hidden" name="odemeolmadiurl" value="{{ route('payment.error') }}">
						<input type="hidden" name="vipname" value="Kredi">
						<input type="hidden" name="raporemail" value="{{ config('mail.from.address') }}">
						<input type="hidden" name="posturl" value="{{ route('payment.listener') }}">
						<input type="hidden" name="batihostid" value="{{ config('payment.methods.batihost.id') }}">

						<div class="form-group">
							<label for="amount">Türk Lirası</label>
							<input type="text" name="amount" id="amount" class="form-control" value="{{ old('amount', 10) }}">
						</div>

						<div class="form-group">
							<label class="d-block">Ödeme Tipi</label>
							<div class="btn-group" data-toggle="buttons">
								<div class="label btn btn-warning">
									<input type="radio" name="odemeturu" value="kredikarti">
									Kredi Kartı
								</div>
								<div class="label btn active btn-warning">
									<input type="radio" name="odemeturu" selected>
									Mobil Ödeme
								</div>
							</div>
						</div>
						<div class="form-group m-b-0">
							<button type="submit" class="btn btn-secondary">Devam et</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop