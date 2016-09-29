@extends($template . '.partials.app')

@section('title', 'Hesabımı Yükselt')

@section('header')
	<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/datepicker/css/bootstrap-datepicker3.min.css">
@stop

@section('container')
	@if ( Auth::user()->isAdmin() )
		<form id="newGroupModal" class="modal fade">
			<input type="hidden" id="group_id">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header text-uppercase">
						Yeni Grup
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="text" placeholder="Grup başlığı..." id="group_title" class="form-control">
							<span class="form-control-feedback"></span>
						</div>

						<div id="group_money_form" class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<label class="m-b-0 hidden-md-down">Kaç gün?</label>
									<small class="form-text text-muted m-t-0" style="margin-bottom: .5rem;">Grup kaç gün geçerli? (-1 = Sınırsız)</small>
									<input type="text" placeholder="30" id="group_money_day_0" name="group_money_day[]" class="datepicker form-control">
									<span class="form-control-feedback"></span>
								</div>
								<div class="col-lg-6">
									<label class="m-b-0 hidden-md-down">Fiyatı</label>
									<small class="form-text text-muted m-t-0" style="margin-bottom: .5rem;">Gerçek paradır. (₺)</small>
									<input type="text" placeholder="10" id="group_money_0" name="group_money[]" class="form-control">
									<span class="form-control-feedback"></span>
								</div>
							</div>
						</div>

						<div id="groupNewMoneyField" class="form-group clearfix">
							<button data-count="0" onclick="return groupNewMoneyField(this);" class="btn btn-secondary pull-right"><i class="fa fa-plus"></i></button>
						</div>

						<hr>
						<div class="form-group">
							<textarea placeholder="Grup satın alındığında oyuncuya gidecek komutlar..." id="group_commands" class="form-control" rows="4"></textarea>
							<small class="form-text text-muted">Her satıra bir komut. (@p = oyuncu adı)</small>
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group">
							<textarea placeholder="Grup süresi bittiğinde oyuncuya gidecek komutlar..." id="group_expiry_commands" class="form-control" rows="4"></textarea>
							<small class="form-text text-muted">Her satıra bir komut. (@p = oyuncu adı)</small>
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group clearfix">
							<button class="btn btn-secondary pull-right" onclick="return addGroup(this);">
								<i class="fa fa-save"></i>
								Kaydet
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	@endif

	<form id="buyGroupModal" class="modal fade">
		<input type="hidden" id="group_id">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header text-uppercase"></div>
				<div class="modal-body">
					<div id="group_modal_money" class="form-group">
						<select class="form-control"></select>
					</div>
					<div id="group_modal_features" class="form-group">
						<label><strong>Özellikler;</strong></label>
						<ul style="list-style: none; margin: 0; padding: 0 0 0 10px;"></ul>
					</div>
					<div id="group_modal_commands" class="form-group">
						<label><strong>Verilecek Komutlar;</strong></label>
						<ul style="list-style: none; margin: 0; padding: 0 0 0 10px;"></ul>
					</div>
					<hr>
					<div class="form-group m-b-0">
						<button class="btn btn-primary w-100" onclick="return buyGroup(this);">
							<i class="fa fa-shopping-cart"></i> Satın Al
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="row" style="overflow: hidden; margin-bottom: 10px;">
		<div class="col-lg-8 offset-lg-2 text-xs-center">
			<h1>Hesabını Yükselt</h1>
			<p>İstediğin gruptan birini seçerek yeni özellikler kazanabilirsin.</p>
			@if ( Auth::user()->isAdmin() )
				<p>
					<button data-toggle="modal" data-target="#newGroupModal" class="btn btn-danger">
						<i class="fa fa-plus"></i>
						Yeni Grup
					</button>
				</p>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-lg-8 offset-lg-2 text-xs-center">
			<div id="groupCards">
				@if ( $groups->count() )
					@foreach ( $groups as $group )
						@include($template . '.partials.group.group')
					@endforeach
				@else
					<div class="alert alert-warning text-center">
						<strong>Oops!</strong>
						<p>Admin hiç grup eklememiş.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="templates/{{ $template }}/components/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script type="text/javascript">var player = '{{ Auth::user()->username }}';</script>
	<script type="text/javascript" src="templates/{{ $template }}/js/request.js"></script>
@stop