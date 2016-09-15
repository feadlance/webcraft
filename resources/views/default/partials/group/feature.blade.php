<li class="list-group-item">
	{!! MinecraftColor::html($feature->body) !!}
	
	@if ( Auth::user()->isAdmin() )
		<div class="pull-right">
			<a href="#" onclick="return deleteGroupFeature(this, {{ $feature->id }})" class="text-danger">
				<i class="fa fa-times"></i>
			</a>
		</div>
	@endif
</li>