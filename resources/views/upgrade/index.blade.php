@extends('templates.app')

@section('title', 'Hesabımı Yükselt')

@section('container')
	@if ( Auth::user()->isAdmin() )
		<form id="newGroupModal" class="modal fade">
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
						<div class="form-group">
							<input type="text" placeholder="Grubun oyundaki adı..." id="group_group" class="form-control">
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group">
							<input type="text" placeholder="Fiyatı (gerçek para)..." id="group_money" class="form-control">
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group clearfix">
							<button class="btn btn-default pull-right" onclick="return addGroup(this);">
								<i class="fa fa-plus"></i>
								Kaydet
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	@endif


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
			@if ( $groups->count() )
				<div id="groupCards" class="cards center-block">
					@foreach ( $groups as $group )
						<div class="col-lg-4">
							<div class="card">
								<div class="card-block">
									<h4 class="card-title">{{ $group->title }}</h4>
									<p class="card-text">{{ TurkishGrammar::get($group->title, 'iyelik') }} fiyatı {{ $group->getMoney() }} Türk Lirası'dir.</p>
								</div>
								<ul class="list-group list-group-flush">
									@foreach ( $group->getFeatures()->get() as $feature )
										<li class="list-group-item">
											{!! $color->html($feature->body) !!}
											
											@if ( Auth::user()->isAdmin() )
												<div class="pull-right">
													<a href="{{ route('group.delete.feature', ['id' => $feature->id]) }}" class="text-danger">
														<i class="fa fa-times"></i>
													</a>
												</div>
											@endif
										</li>
									@endforeach
									@if ( Auth::user()->isAdmin() )
										<li class="list-group-item">
											<form role="form" onsubmit="return addGroupFeature(this, {{ $group->id }});">
												<div class="form-group m-b-0">
													<input type="text" name="" id="" placeholder="Yeni özellik..." class="form-control">
												</div>
											</form>
										</li>
									@endif
								</ul>
								<div class="card-block">
									<a href="#" class="btn btn-outline-primary card-link{{ !Auth::user()->isAdmin() ? ' d-block' : '' }}">Satın Al</a>
									@if ( Auth::user()->isAdmin() )
										<a href="{{ route('group.delete', ['id' => $group->id]) }}" class="btn btn-outline-danger card-link">Grubu Sil</a>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="alert alert-warning text-center">
					<strong>Oops!</strong>
					<p>Admin hiç grup eklememiş.</p>
				</div>
			@endif
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop