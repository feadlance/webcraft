<div class="comment-item">
	<div class="avatar">
		<img src="{{ $comment->user()->getAvatar(isset($sub) ? 35 : 40) }}" alt="User Avatar">
	</div>
	<div class="content">
		<div class="comment">
			<a href="{{ route('profile', ['player' => $comment->user()->username]) }}">
				<strong>{{ $comment->user()->getDisplayName() }}</strong>
			</a>
			<span>{{ $comment->body }}</span>
		</div>
		<ul class="meta clearfix">
			<li class="action-comment-like"><a href="#" onclick="return likeComment(this, {{ $comment->id }});">{{ Auth::user()->hasLikedComment($comment) ? 'Beğenmekten Vazgeç' : 'Beğen' }}</a></li>
			@if ( !isset($sub) )
				<li class="action-comment-reply"><a href="#" onclick="return showCommentReplies(this);">Yanıtla <small class="comment-reply-counter">({{ $status->comments($comment->id)->count() }})</small></a></li>
			@endif
			@if ( $comment->likes()->count() )
				<li class="action-comment-like-counter">
					<i class="fa fa-thumbs-up"></i>
					<span>{{ $comment->likes()->count() }}</span>
				</li>
			@endif
			<li class="action-ago">{{ $comment->created_at->diffForHumans() }}</li>
		</ul>

		@if ( !isset($sub) )
			@include($template . '.partials.status.post_comment', [
				'id' => $comment->id,
				'type' => 'comment',
				'placeholder' => 'Yanıtınızı yazın...',
			])

			<div class="sub-comments">
				@foreach ( $status->comments($comment->id)->get() as $comment )
					@include($template . '.partials.status.comment', ['sub' => true])
				@endforeach
			</div>
		@endif
	</div>
</div>