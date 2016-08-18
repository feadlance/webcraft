<div class="status-item">
	<div class="status-info clearfix">
		<div class="avatar">
			<img src="{{ $status->user()->getAvatar(40) }}" alt="User Avatar">
		</div>
		<div class="body">
			<a href="{{ route('profile', ['player' => $status->user()->username]) }}">
				<strong>{{ $status->user()->getDisplayName() }}</strong>
			</a>
			<ul class="status-meta clearfix">
				<li>
					<a href="#">{{ $status->created_at->diffForHumans() }}</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="status-body clearfix">
		{!! $status->postFormat() !!}
	</div>
	<div class="status-footer">
		<ul class="status-meta clearfix">
			<li>
				<span class="status-like-counter">{{ $status->likes()->count() }}</span> beğeni
			</li>
			<li>
				<span class="status-comment-counter">{{ $status->comments()->count() }}</span> yorum
			</li>
		</ul>
		<ul class="status-actions clearfix">
			<li>
				<button class="btn {{ Auth::user()->hasLikedStatus($status) ? 'btn-primary' : 'btn-default' }}" onclick="return likeStatus(this, {{ $status->id }});">
					<i class="fa fa-thumbs-up"></i>
					Beğen
				</button>
			</li>
			<li>
				<button class="btn btn-default" onclick="return showComments(this);">
					<i class="fa fa-comments"></i>
					Yorum Yap
				</button>
			</li>
		</ul>
	</div>
	@include('templates.status.post_comment')

	<div class="status-comments">
		@foreach ( $status->comments()->get() as $comment )
			@include('templates.status.comment')
		@endforeach
	</div>
</div>



