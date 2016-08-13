@if ( Auth::user()->isFriendsWith($user) || Auth::id() === $user->id )
	<div class="panel p-relative">
		<div class="title">Paylaş</div>
		<div class="input-content">
			<textarea id="status_body" placeholder="{{ Auth::id() === $user->id ? 'Ne düşünüyorsun?' : $user->getDisplayName() . ' için bir şeyler söyle...' }}"></textarea>
		</div>
		<div class="footer clear-after">
			<!--<div class="pull-left">
				<button class="action">
					<i class="fa fa-camera"></i>
				</button>
			</div>-->
			<div class="pull-right">
				<button id="submit_status" class="ui blue button" style="margin: 0; border-radius: 0;">Paylaş</button>
			</div>
		</div>
		<div id="add_status_loading" class="loading-panel">
			<div class="loading-content">
				<i class="fa fa-circle-o-notch fa-4x fa-spin"></i>
			</div>
		</div>
	</div>
@endif