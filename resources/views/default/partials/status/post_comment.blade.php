<div class="status-post-comment clearfix">
	<div class="avatar">
		<img src="{{ Auth::user()->getAvatar(isset($type) ? 35 : 40) }}" alt="User Avatar">
	</div>
	<div class="comment">
		<form onsubmit="return postComment(this, {{ $id or $status->id }}, '{{ $type or 'status' }}');">
			<input type="text" placeholder="{{ $placeholder or 'Yorumunuzu yazın...' }}" class="form-control">
		</form>
	</div>
</div>