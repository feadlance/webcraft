@extends($template . '.partials.app')

@section('title', TurkishGrammar::get($user->getDisplayName(), 'iyelik') . ' chesti')

@section('header')
	<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">
@stop

@section('container')
	@if ( Auth::id() === $user->id )
		<form id="itemModal" onsubmit="return sellInventoryItem(this);" class="modal fade" autocomplete="off">
			<input type="hidden" id="item_order">
			<input type="hidden" id="chest_number">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header text-uppercase">
						Item Satışı
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="item_piece">Adet</label>
							<input type="text" id="item_piece" class="form-control">
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group">
							<label for="item_price">Fiyat</label>
							<input type="text" placeholder="" id="item_price" class="form-control">
							<span class="form-control-feedback"></span>
							<small class="form-text text-muted">Kaç paraya satıyorsunuz? (oyun parası)</small>
						</div>
						<div class="form-group clearfix">
							<button class="btn btn-default pull-right">
								<i class="fa fa-plus"></i>
								Satışa Çıkart
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	@endif

	<div class="row">
		@foreach ( $inventories as $inventory )
			<div class="col-lg-6 col-md-12r">
				<div class="card">
					<div class="card-header">{{ $inventory->number }}. Sandık</div>
					<div class="card-block">
						<div class="player-inventory">
							<div class="inv-row clearfix">
								@for ($i = 0; $i < 36; $i++)
									<div class="inv-block">
										@if ( array_key_exists($i, $inventory->inventory) )
											@if ( Auth::id() === $user->id )
												<a id="inv_item_{{ $inventory->number }}_{{ $i }}" href="#" data-toggle="modal" data-target="#itemModal" data-number="{{ $inventory->number }}" data-item="{{ $i }}">
											@endif
												<img data-toggle="tooltip" title="{{ $inventory->nameOrDisplayName($i) }}" src="{{ $inventory->icon($i) }}" alt="Inventory Block">
												<span class="inv-piece">{{ $inventory->inventory[$i][4] }}</span>
											@if ( Auth::id() === $user->id )
												</a>
											@endif
										@else
											<img src="global/images/minecraft/items/0-0.png" alt="Inventory Block">
										@endif
									</div>
								@endfor
							</div>
						</div>
					</div>
				</div>
			</div>
		@endforeach
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="templates/{{ $template }}/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
		var player = '{{ $user->username }}';
	</script>
	<script type="text/javascript" src="templates/{{ $template }}/js/request.js"></script>
@stop