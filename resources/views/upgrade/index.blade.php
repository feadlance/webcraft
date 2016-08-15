@extends('templates.app')

@section('title', 'Hesabımı Yükselt')

@section('breadcrumb')
	<li>Hesabımı Yükselt</li>
@stop

@section('container')
	@if ( Auth::user()->isAdmin() )
		<form id="form_new_group" class="ui modal panel">
			<div class="header">
				Yeni Grup
			</div>
			<div class="content p-relative">
				<div class="ui form">
					<div id="group_title" class="field m-b-5">
						<div class="ui input block">
							<input type="text" class="input" placeholder="Grup başlığı...">
						</div>
						<span class="error-p"></span>
					</div>
					<div id="group_group" class="field m-b-5">
						<div class="ui input block">
							<input type="text" class="input" placeholder="Grubun oyundaki ismi...">
						</div>
						<span class="error-p"></span>
					</div>
					<div id="group_money" class="field m-b-5">
						<div class="ui input block">
							<input type="text" class="input" placeholder="Fiyatı (gerçek para)...">
						</div>
						<span class="error-p"></span>
					</div>
				</div>
				<hr>
				<button class="ui bottom attached red button block">
					<i class="fa fa-plus" style="margin-right: 3px;"></i>
					Yeni Grup
				</button>
				<div class="loading-panel">
					<div class="loading-content">
						<i class="fa fa-circle-o-notch fa-4x fa-spin"></i>
					</div>
				</div>
			</div>
		</form>
	@endif
	<div class="text-center m-t-10 m-b-20">
		<h1 class="regular uppercase titillium m-0">Hesabını Yükselt!</h1>
		<p style="font-size: 16px;">İstediğin gruptan birini seçerek yeni özellikler kazanabilirsin.</p>
		@if ( Auth::user()->isAdmin() )
			<p>
				<button id="new_group" class="ui red button">
					<i class="fa fa-plus" style="margin-right: 3px;"></i>
					Yeni Grup
				</button>
			</p>
		@endif
	</div>
	@if ( $groups->count() )
		<div class="ui link cards" style="display: table; margin: 0 auto;">
			@foreach ( $groups as $group )
				<div class="card" style="float: left;">
					<!--<div class="image">
						<img src="assets/images/card-image.png">
					</div>-->
					<div class="content">
						<div class="header titillium regular uppercase" style="font-size: 20px; {{ Auth::user()->isAdmin() ? 'display: inline-block; vertical-align: middle;' : 'text-align: center;' }}">{{ $group->title }}</div>
						@if ( Auth::user()->isAdmin() )
							<a href="{{ route('group.delete', ['id' => $group->id]) }}" class="ui button" style="padding: 5px 10px; float: right;">Sil</a>
						@endif
					</div>
					@if ( $group->getFeatures()->count() )
						@foreach ( $group->getFeatures()->get() as $feature )
							<div class="extra content text-center" style="color: #616161;">
								{!! $color->html($feature->body) !!}
							</div>
						@endforeach
					@else
						<div class="extra content text-center no-feature" style="color: #616161;">
							Bu grubun hiç özelliği yok.
						</div>
					@endif
					@if ( Auth::user()->isAdmin() )
						<div class="custom-extra"></div>
						<div class="extra content text-center" style="color: #616161; padding: 0;">
							<div class="ui input" style="width: 100%;">
								<form class="new-group-feature" data-id="{{ $group->id }}" autocomplete="off" style="width: 100%;">
									<input type="text" placeholder="Yeni özellik ekleyin..." style="border-radius: 0; text-align: center; border: 0; width: 100%;">
								</form>
							</div>
						</div>
					@endif
					<div class="ui bottom attached blue button">
						<i class="fa fa-shopping-cart" style="margin-right: 5px;"></i>
						Satın Al
					</div>
				</div>
			@endforeach
		</div>
	@else
		<div class="ui message text-center" style="width: 500px; margin: 0 auto;">
			<div class="header">
				Oops!
			</div>
			<p>Admin hiç grup eklememiş.</p>
		</div>
	@endif
@stop

@section('scripts')
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop