@extends($template . '.partials.app')

@section('title', 'Kredi Yükle')

@section('container')
	@if ( session('iframe') )
		<div id="addCreditModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header text-uppercase">
						Kredi Yükleyin
					</div>
					<div class="modal-body">
						<iframe width="100%" height="600px" src="{{ session('iframe') }}" frameborder="0"></iframe>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div class="row">
		<div class="col-lg-8 offset-lg-2">
			<div class="card">
				<div class="card-header">Hesabınıza Kredi Yükleyin</div>
				<div class="card-block">
					<form action="{{ route('payment.send') }}" method="post" autocomplete="off">
						{{ csrf_field() }}

						<div class="form-group">
							<label>Kullanıcı Adı</label>
							<input type="text" class="form-control" value="{{ Auth::user()->username }}" readonly="">
						</div>

						<div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
							<label for="amount">Türk Lirası</label>
							<input type="text" name="amount" id="amount" class="form-control" value="10">
							@if ( $errors->has('amount') )
								<span class="form-control-feedback">{{ $errors->first('amount') }}</span>
							@endif
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

@section('scripts')
	@if ( session('iframe') )
			<script type="text/javascript">
			$('#addCreditModal').modal('show');
		</script>
	@endif
@stop