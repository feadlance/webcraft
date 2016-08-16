<div data-id="{{ $status->id }}" class="status-item">
	<div class="status-info clearfix">
		<div class="avatar">
			<img src="{{ $status->user()->getAvatar(50) }}" alt="User Avatar">
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
	<div class="status-comments">
		
	</div>
</div>