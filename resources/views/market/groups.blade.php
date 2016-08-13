@extends('templates.app')

@section('title', 'Gruplar')

@section('breadcrumb')
	<li><a href="{{ route('market') }}">Market</a></li>
	<li>Gruplar</li>
@stop

@section('container')
	<div class="ui message" style="margin-bottom: 5px;">
		<div class="header">Dikkat!</div>
		<p>Bu sayfada ki gruplar gerçek para <strong>(TRY)</strong> ile satılmaktadır.</p>
	</div>
	@if ( Auth::user()->isAdmin() )
		<div id="new_group_form" class="ui modal panel">
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
					<div id="group_description" class="field m-b-5">
						<div class="ui input block">
							<textarea class="input" placeholder="Grup hakkında..." rows="2"></textarea>
						</div>
						<span class="error-p"></span>
					</div>
					<div id="group_group" class="field m-b-5">
						<div class="ui input block">
							<input type="text" class="input" placeholder="Grubun oyundaki ismi...">
						</div>
						<span class="error-p"></span>
					</div>
					<div id="group_balance" class="field m-b-5">
						<div class="ui input block">
							<input type="text" class="input" placeholder="Fiyatı (gerçek para)...">
						</div>
						<span class="error-p"></span>
					</div>
					<div id="group_game" class="field m-t-10">
						<div class="ui checkbox">
						  <input id="group_game_check" type="checkbox" />
						  <label for="group_game_check">Bu grubu oyunda da oluştur.</label>
						</div>
						<span class="error-p"></span>
					</div>
				</div>
				<hr>
				<a id="add_group" class="ui bottom attached red button">
					<i class="add icon"></i>
					Yeni Grup
				</a>
				<div id="add_group_loading" class="loading-panel">
					<div class="loading-content">
						<i class="fa fa-circle-o-notch fa-4x fa-spin"></i>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div class="panel">
		<div class="title">
			Gruplar
			@if ( Auth::user()->isAdmin() )
				<button id="add_group_modal" class="ui blue button" style="padding: 5px 10px; margin-left: 5px; font-size: 13px;">Yeni Grup</button>
			@endif
		</div>
		<div class="content" style="padding: 10px;">
			<div class="ui cards">
				@if ( $groups->count() )
					@foreach ( $groups as $group )
						<div class="card">
							<a href="#" class="image">
								<img src="storage/image/group/1.jpg" alt="">
							</a>
							<div class="content text-center">
								<div class="header">{{ $group->title }}</div>
								<div class="description">
									<strong>{{ $group->title }}</strong> grubu, <strong>{{ $group->getBalance() }}TRY</strong> dir.<hr>
									<p style="text-align: left;">{{ $group->description }}</p>
								</div>
							</div>
							<a data-id="{{ $group->id }}" class="ui bottom attached blue buy_group button">
								<i class="add icon"></i>
								Satın Al
							</a>
						</div>
					@endforeach
				@else
					<p id="no-group-message" style="padding: 10px 5px;">Yetkili arkadaş hiç grup eklememiş sisteme. Söyle de eklesin bişeyler.</p>
				@endif
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop