@extends($template . '.partials.app')

@section('title', 'Kredi Yükle')

@section('container')
	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-header">Hesabınıza Kredi Yükleyin</div>
				<div class="card-block">
					@if ( session('iframe') )
						<iframe src="{{ session('iframe') }}" frameborder="0"></iframe>
					@else
						<form action="{{ route('payment.send') }}" method="post" autocomplete="off">
							{{ csrf_field() }}

							<div class="form-group">
								<label>Kullanıcı Adı</label>
								<input type="text" class="form-control" value="{{ Auth::user()->username }}" readonly="">
							</div>

							<div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
								<label for="amount">Kredi</label>
								<input type="text" name="amount" id="amount" class="form-control" value="10">
								@if ( $errors->has('amount') )
									<span class="form-control-feedback">{{ $errors->first('amount') }}</span>
								@endif
							</div>

							<div class="form-group m-b-0">
								<button type="submit" class="btn btn-secondary">Devam et</button>
							</div>
						</form>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop