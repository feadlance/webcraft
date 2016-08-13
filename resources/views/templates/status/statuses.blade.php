<div data-id="{{ $status->id }}" data-type="status" class="item ui">
	<div class="header">
		<div class="options">
			<div class="ui dropdown">
				<i class="fa fa-chevron-down"></i>
				<div class="menu">
					<!--<a href="#" class="item">
						<i class="fa fa-bug"></i>
						Bu yazıyı bildir
					</a>-->
					@if ( $status->user()->id === Auth::id() || $status->wall_id === Auth::id() )
						<a href="#" class="item delete-post">
							<i class="fa fa-trash"></i>
							Sil
						</a>
					@endif
				</div>
			</div>
		</div>
		<div class="avatar">
			<img src="{{ $status->user()->getAvatar(50) }}" alt="User Avatar">
		</div>
		<div class="title">
			<a href="{{ route('profile', ['player' => $status->user()->username]) }}">{{ $status->user()->getDisplayName() }}</a>
		</div>
		<div class="extra">
			{{ $status->created_at->diffForHumans() }}
		</div>
	</div>
	<div class="content">
		<p>{{ $status->body }}</p>

		<div class="show_comments_button info">
			<span><font class="like-counter">{{ $status->likes()->count() }}</font> beğeni</span>
			<span><font class="comment-counter">{{ $status->comments()->count() }}</font> yorum</span>
		</div>
	</div>
	<div class="footer">
		<div class="pull-left">
			@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
				<div class="p-relative" style="float: left;">
					<button class="action action-text likeable{{ Auth::user()->hasLikedStatus($status) ? ' liked' : '' }}">
						<i class="fa fa-thumbs-up"></i>
						Beğen
					</button>
					<div class="loading-panel"></div>
				</div>
				<button class="show_comments_button action action-text">
					<i class="fa fa-comments"></i>
					Yorum Yap
				</button>
			@endif
			<button class="action action-text">
				<i class="fa fa-share"></i>
				Paylaş
			</button>
		</div>
	</div>
	<div data-type="comment" class="comments clear-after">
		@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
			<form class="post-comment p-relative">
				<div class="user">
					<img src="{{ Auth::user()->getAvatar(40) }}" alt="User Avatar">
				</div>
				<input type="text" class="post-comment-text" placeholder="Bir yorum  yazın...">
				<div class="loading-comment loading-panel">
					<div class="loading-content" style="margin-left: -10px; margin-top: -10px;">
						<i class="fa fa-circle-o-notch fa-spin"></i>
					</div>
				</div>
			</form>
		@endif
		@foreach ( $status->comments()->orderBy('id', 'asc')->get() as $comment )
			<div data-id="{{ $comment->id }}" class="comment">
				<img src="{{ $comment->user()->getAvatar(40) }}" alt="User Avatar">
				<div class="comment-body">
					<a href="{{ route('profile', ['player' => $comment->user()->username]) }}" class="user-link">{{ $comment->user()->getDisplayName() }}</a>
					<span class="content">{{ $comment->body }}</span>
				</div>
				<div class="bottom">
					<ul class="comment-actions clear-after">
						@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
							<li><a class="likeable" href="#">{{ Auth::user()->hasLikedComment($comment) ? 'Beğenmekten Vazgeç' : 'Beğen' }}</a></li>
						@endif
						<li><a class="show_reply_comments_button" href="#">Yanıtla ({{ $status->comments($comment->id)->count() }})</a></li>
						<li>{{ $comment->created_at->diffForHumans() }}</li>
						<li class="comment-likes" data-likes="{{ $comment->likes()->count() }}">
							<i class="fa fa-thumbs-up"></i>
							<span>{{ $comment->likes()->count() }}</span>
						</li>
					</ul>
					@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
						<form data-type="reply" class="post-comment-reply p-relative">
							<div class="user">
								<img src="{{ Auth::user()->getAvatar(25) }}" alt="User Avatar">
							</div>
							<input type="text" class="post-comment-text" placeholder="Bir yanıt yazın...">
							<div class="loading-reply loading-panel">
								<div class="loading-content" style="margin-left: -10px; margin-top: -10px;">
									<i class="fa fa-circle-o-notch fa-spin"></i>
								</div>
							</div>
						</form>
					@endif
				</div>
				<div class="child-comments">
					@foreach ( $status->comments($comment->id)->orderBy('id', 'asc')->get() as $reply_comment )
						<div data-type="comment" data-id="{{ $reply_comment->id }}" class="comment">
							<img src="{{ $reply_comment->user()->getAvatar(25) }}" alt="User Avatar">
							<div class="comment-body">
								<a href="{{ route('profile', ['player' => $reply_comment->user()->username]) }}" class="user-link">{{ $reply_comment->user()->getDisplayName() }}</a>
								<span class="content">{{ $reply_comment->body }}</span>
							</div>
							<div class="bottom">
								<ul class="comment-actions clear-after">
									@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
										<li><a class="likeable" href="#">{{ Auth::user()->hasLikedComment($reply_comment) ? 'Beğenmekten Vazgeç' : 'Beğen' }}</a></li>
									@endif
									<li>{{ $reply_comment->created_at->diffForHumans() }}</li>
									<li class="comment-likes" data-likes="{{ $reply_comment->likes()->count() }}">
										<i class="fa fa-thumbs-up"></i>
										<span>{{ $reply_comment->likes()->count() }}</span>
									</li>
								</ul>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</div>