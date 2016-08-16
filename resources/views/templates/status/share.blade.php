<div id="status_form" class="panel panel-custom">
	<div class="panel-heading">
		<div class="panel-title">Paylaş</div>
	</div>
	<div class="panel-content">
		<div class="form-group">
			<textarea id="status_body" placeholder="{{ Auth::id() === $user->id ? 'Ne düşünüyorsun?' : $user->getDisplayName() . ' için bir şeyler söyle...' }}" class="form-control" rows="3"{{ isset($can_post) && !$can_post ? ' disabled' : '' }}></textarea>
		</div>
	</div>
	<div class="panel-footer clearfix">
		<button id="submit_status" class="btn btn-primary text-uppercase">Paylaş</button>
	</div>
</div>