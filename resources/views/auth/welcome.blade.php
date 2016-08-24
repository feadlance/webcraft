@extends('auth.default')

@section('container')
	<div class="row">
		<div class="col-sm-8 offset-sm-2">
			<div class="form-box">
				<div class="form-top">
					<div class="form-top-left">
						<h3>Tebrikler!</h3>
						<p>Artık bizden birisin.</p>
					</div>
					<div class="form-top-right">
						<i class="fa fa-check"></i>
					</div>
				</div>
				<div class="form-bottom">
					İçeride çok eğlenceli şeyler oluyor, bu panel de bile oyunda ki kadar çok eğleneceksin!
					<div class="continue">
						<a href="{{ route('home') }}" class="btn">
							Devam et
							<i class="fa fa-long-arrow-right"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop