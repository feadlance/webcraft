@extends($template . '.partials.app')

@section('title', 'Topluluk Pazarı')

@section('header')
	<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">
@stop

@section('container')
	@if ( $materials->count() )
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					@foreach ( $materials as $material )
						<div class="col-lg-3 col-md-6">
							<div class="card">
								<div class="card-block">
									<div class="pull-left m-r-1">
										<img width="50" src="{{ $material->icon() }}" alt="Material Icon">
									</div>
									<h4 class="card-title">{{ $material->material()->name or $material->material()->text_type }}</h4>
									<h6 class="card-subtitle text-muted">Bu ürün için <strong>{{ Webcraft\Models\Community_Market::where('type', $material->type)->where('meta', $material->meta)->count() }}</strong> satış mevcut.</h6>
								</div>
								<ul class="list-group list-group-flush">
									@foreach ( Webcraft\Models\Community_Market::where('type', $material->type)->where('meta', $material->meta)->orderBy('price', 'asc')->get() as $children )
										<li class="list-group-item clearfix">
											<div class="pull-left">
												{{ $children->piece }} adet, <span data-toggle="tooltip" title="Oyun Parası">{{ $children->price(true) }} Kredi</span>
											</div>
											<div class="pull-right">
												@if ( Auth::id() === $children->user()->id )
													<a onclick="return buyCommunityMarketItem(this, {{ $children->id }});" href="#" class="card-link text-danger">İptal Et</a>
												@else
													<a onclick="return buyCommunityMarketItem(this, {{ $children->id }});" href="#" class="card-link">Satın al</a>
												@endif
											</div>
										</li>
									@endforeach
								</ul>
								<div class="card-block">
									<a onclick="swal('', 'Bu sayfa henüz hazır değil.'); return false;" href="#" class="card-link">Satışları Göster</a>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	@else
		<div class="card">
			<div class="card-block">
				Markette hiç ürün yok. Hemen <a href="{{ route('profile.chest', ['player' => Auth::user()->username]) }}">chestine</a> girip ürün satabilirsin!
			</div>
		</div>
	@endif
@stop

@section('scripts')
	<script type="text/javascript" src="templates/{{ $template }}/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="templates/{{ $template }}/js/request.js"></script>
@stop