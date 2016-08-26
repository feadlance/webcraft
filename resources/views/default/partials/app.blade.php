<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<title>@yield('title', 'Anasayfa') - {{ MinecraftServer::name() }}</title>

		<!-- meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- sweetalert -->
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">

		<!-- font awesome -->
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/font-awesome/css/font-awesome.min.css">

		<!-- css -->
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/css/main.css">

		<!-- other -->
		@yield('header')
	</head>
	<body>
		@include ($template . '.partials.navigation')

		<div class="wrapper">
			@include ($template . '.partials.header')

			<!-- container -->
			<div class="container-fluid clearfix">
				@include($template . '.partials.flash')
				
				@yield('container')
			</div>
		</div>

		<footer>
			<!-- -->
		</footer>

		<!-- app -->
		<script type="text/javascript" src="templates/{{ $template }}/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/components/tether/tether.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/components/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/js/main.js"></script>

		<!-- other -->
		<script type="text/javascript">var url = '{{ url('/') }}', token = '{{ Session::token() }}';</script>
		@yield('scripts')
	</body>
</html>
