<div class="status-post-comment clearfix">
	<div class="avatar">
		<img src="{{ Auth::user()->getAvatar(isset($type) ? 35 : 40) }}" alt="User Avatar">
	</div>
	<div class="comment">
		<form onsubmit="return postComment(this, {{ isset($id) ? $id : $status->id }}, '{{ isset($type) ? $type : 'status' }}');">
			<input type="text" placeholder="{{ isset($placeholder) ? $placeholder : 'Yorumunuzu yazın...' }}" class="form-control">
		</form>
	</div>
</div>