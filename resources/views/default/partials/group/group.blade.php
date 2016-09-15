<div data-id="{{ $group->id }}" id="group_card_{{ $group->id }}" class="col-lg-4">
	<div class="card">
		<div class="card-block">
			<h4 class="card-title">{{ $group->title }}</h4>
			<p class="card-text">{{ TurkishGrammar::get($group->title, 'iyelik') }} fiyatı {{ $group->getMoney() }} Türk Lirası'dır.</p>
			@if ( Auth::user()->isAdmin() )
				<div class="btn-group">
					<button data-toggle="modal" data-target="#newGroupModal" class="btn btn-outline-primary card-link">Düzenle</button>
					<button onclick="deleteGroup(this, {{ $group->id }});" class="btn btn-outline-danger card-link">Sil</button>
				</div>
			@endif
		</div>
		<ul class="list-group list-group-flush">
			@foreach ( $group->getFeatures()->get() as $feature )
				@include($template . '.partials.group.feature')
			@endforeach
			@if ( Auth::user()->isAdmin() )
				<li class="list-group-item">
					<form role="form" onsubmit="return addGroupFeature(this, {{ $group->id }});">
						<div class="form-group m-b-0">
							<input type="text" placeholder="Yeni özellik..." class="form-control">
						</div>
					</form>
				</li>
			@endif
		</ul>
		<div class="card-block">
			<button data-toggle="modal" data-target="#buyGroupModal" class="btn btn-outline-primary card-link d-block w-100">Satın Al</button>
		</div>
	</div>
</div>