@extends('templates.app')

@section('title', 'Market')

@section('breadcrumb')
	<li><a href="{{ route('market') }}">Market</a></li>
	<li>Eşyalar</li>
@stop

@section('container')
	<div class="ui message" style="margin-bottom: 5px;">
		<div class="header">Ödeme</div>
		<p>Bu sayfada ki eşyalar <strong>oyun parası</strong> ile satılmaktadır.</p>
	</div>

	<div class="ui grid">
		<div class="wide centered column">
			@if ( Auth::user()->isAdmin() )
				<div class="p-relative">
					<table class="ui celled table">
						<thead>
							<tr>
								<th colspan="4">
									Yeni Ürün
									<small style="color: #c0392b;">bu paneli sadece adminler görebilir</small>
								</th>
							</tr>
						</thead>
						<tbody>
							<tr style="background: #eaeaea;">
								<td id="product_title" style="width: 40%;">
									<div class="ui input block">
										<input type="text" class="input" placeholder="Ürün adı...">
									</div>
									<span class="error-p"></span>
								</td>
								<td id="product_code" style="width: 30%;">
									<div class="ui input block">
										<input type="text" class="input" placeholder="Ürün kodu...">
									</div>
									<span class="error-p"></span>
								</td>
								<td id="product_balance" style="width: 20%;">
									<div class="ui input block">
										<input type="text" class="input" placeholder="Fiyat...">
									</div>
									<span class="error-p"></span>
								</td>
								<td style="width: 10%;">
									<button type="submit" id="add_product" type="submit" class="ui red block button">
										<i class="fa fa-plus"></i>
										Yeni Ürün
									</button>
								</td>
							</tr>
						</tbody>
					</table>
					<div id="add_product_loading" class="loading-panel">
						<div class="loading-content">
							<i class="fa fa-circle-o-notch fa-4x fa-spin"></i>
						</div>
					</div>
				</div>
			@endif

			<table class="ui celled products table">
				<thead>
					<tr>
						<th>Ürün</th>
						<th>Fiyat</th>
						<th>Adet</th>
						<th>İşlem</th>
					</tr>
				</thead>
				<tbody>
					@if ( $products->count() )
						@foreach ( $products as $product )
							<tr data-balance="{{ $product->balance }}">
								<td>
									<img src="assets/images/minecraft-items/{{ $product->getCode('-') }}.png" alt="{{ $product->title }}" style="vertical-align: middle; margin-right: 4px;">
									{{ $product->title }}
								</td>
								<td style="width: 100px;">{{ $product->getBalance() }}</td>
								<td style="width: 50px;">
									<div class="ui input block">
										<input type="text" class="input" id="piece_{{ $product->id }}" value="1">
									</div>
								</td>
								<td style="width: 150px;">
									<button type="submit" class="ui primary block buy_product button" value="{{ $product->id }}">Satın Al</button>
								</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="5">Admininiz bu markete hiç ürün eklememiş.</td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="assets/js/request.js"></script>
@stop