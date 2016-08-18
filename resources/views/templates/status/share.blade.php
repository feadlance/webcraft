<div class="card">
	<div class="card-header">Paylaş</div>
	<form id="status_form" onsubmit="return postStatus(this);">
		<div class="card-block">
			<div class="form-group">
				<textarea placeholder="{{ Auth::id() === $user->id ? 'Ne düşünüyorsun?' : $user->getDisplayName() . ' için bir şeyler söyle...' }}" class="form-control" rows="3"{{ isset($can_post) && !$can_post ? ' disabled' : '' }}></textarea>
			</div>
		</div>
		<div class="card-footer clearfix">
			<button class="btn btn-primary text-uppercase">Paylaş</button>
		</div>
	</form>
</div>