@extends('templates.app')

@section('title', 'Market')

@section('breadcrumb')
	<li>Market</li>
@stop

@section('container')
	<div class="ui market grid">
		<div class="eight wide column" style="padding-right: 5px;">
			<div class="panel">
				<a href="{{ route('market.products') }}">
					<div class="content text-center">
						<span class="blue-text">EŞYALAR</span>
						Oyun eşyalarını bu bölümden alıp-satabilirsiniz.
					</div>
				</a>
			</div>
		</div>
		<div class="eight wide column" style="padding-left: 5px;">
			<div class="panel">
				<a href="{{ route('market.groups') }}">
					<div class="content text-center">
						<span>GRUPLAR</span>
						Satışa açık grupları bu sekmeden alabilirsiniz.
					</div>
				</a>
			</div>
		</div>
	</div>
	<style>
		.ui.market.grid .panel .content {
			color: #afafaf;
			height: 100px;
			transition: all 150ms;
		}

		.ui.market.grid .panel .content:hover {
			color: #fff;
			background: #2bc082;
		}

		.ui.market.grid .panel .content:hover span {
			color: #fff !important;
		}

		.ui.market.grid .content span {
			display: block;
			font-size: 30px;
			padding-top: 25px;
			margin-bottom: 5px;
			color: #e74c3c;
			transition: color 150ms;
		}
	</style>
@stop