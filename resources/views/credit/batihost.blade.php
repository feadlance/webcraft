@extends('templates.app')

@section('title', 'Kredi Yükle')

@section('container')
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-header">Hesabınıza Kredi Yükleyin</div>
				<div class="card-block text-xs-center" style="padding: 0.25rem 1.25rem 1.25rem 1.25rem;">
					<form action="https://batihost.com/vipgateway/viprec.php" method="post" autocomplete="off">
						<input type="hidden" name="oyuncu" value="{{ Auth::user()->getDisplayName() }}">
						<input type="hidden" name="odemeolduurl" value="{{ route('payment.success') }}">
						<input type="hidden" name="odemeolmadiurl" value="{{ route('payment.error') }}">
						<input type="hidden" name="vipname" value="Kredi">
						<input type="hidden" name="raporemail" value="{{ config('mail.from.address') }}">
						<input type="hidden" name="posturl" value="{{ route('payment.listener') }}">
						<input type="hidden" name="batihostid" value="{{ config('payment.methods.batihost.id') }}">

						<div class="btn-group m-t-1" data-toggle="buttons">
							<div class="label btn btn-primary">
								<input type="radio" name="amount" value="5">
								5 TRY
							</div>
							<div class="label active btn btn-primary">
								<input type="radio" name="amount" value="10" checked>
								10 TRY
							</div>
							<div class="label btn btn-primary">
								<input type="radio" name="amount" value="20">
								20 TRY
							</div>
						</div>
						<div class="btn-group m-t-1" data-toggle="buttons">
							<div class="label btn btn-warning">
								<input type="radio" name="odemeturu" value="kredikarti">
								Kredi Kartı
							</div>
							<div class="label btn active btn-warning">
								<input type="radio" name="odemeturu" selected>
								Mobil
							</div>
						</div>
						<div class="btn-group m-t-1">
							<button type="submit" class="btn btn-secondary">Devam et</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@stop