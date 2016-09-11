@extends($template . '.partials.app')

@section('title', TurkishGrammar::get($user->getDisplayName(), 'iyelik') . ' chesti')

@section('container')
	<div class="row">
		<div class="col-lg-6">
			<div class="card">
				<div class="card-header">1. Sandık</div>
				<div class="card-block">
					<div class="player-inventory">
						<div class="inv-row">
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
							<div class="inv-block"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop

