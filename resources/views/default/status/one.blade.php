@extends($template . '.partials.app')

@section('title', 'Paylaşım')

@section('header')
	<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">
@stop

@section('container')
	<div class="col-lg-8 offset-lg-2">
		<div id="statuses">
			@include($template . '.partials.status.status', ['open' => true])
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript" src="templates/{{ $template }}/components/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="templates/{{ $template }}/js/request.js"></script>
@stop