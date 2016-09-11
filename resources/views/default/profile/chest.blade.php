@extends($template . '.partials.app')

@section('title', TurkishGrammar::get($user->getDisplayName(), 'iyelik') . ' chesti')

@section('container')
	<div class="row">
		@foreach ( $inventories as $inventory )
			<div class="col-lg-6 col-md-8">
				<div class="card">
					<div class="card-header">{{ $inventory->number }}. Sandık</div>
					<div class="card-block">
						<div class="player-inventory">
							<div class="inv-row clearfix">
								@for ($i = 0; $i < 36; $i++)
									<div class="inv-block">
										@if ( array_key_exists($i, $inventory->inventory) )
											<img data-toggle="tooltip" title="{{ $inventory->inventory[$i][1] ?: $inventory->name($i) }}" src="{{ $inventory->icon($i) }}" alt="Inventory Block">
											<span class="inv-piece">{{ $inventory->inventory[$i][2] }}</span>
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

