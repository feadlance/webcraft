<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<title>@yield('title', 'Anasayfa') - {{ MinecraftServer::name() }}</title>

		<!-- meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- sweetalert -->
		<link rel="stylesheet" type="text/css" href="assets/components/sweetalert/sweetalert.css">

		<!-- css -->
		<link rel="stylesheet" type="text/css" href="assets/components/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="assets/css/main.css">

		<!-- other -->
		@yield('header')
	</head>
	<body>
		@include ('templates.partials.navigation')

		<div class="wrapper">
			@include ('templates.partials.header')

			<!-- container -->
			<div class="container-fluid clearfix">
				@yield('container')
			</div>
		</div>

		<footer>
			<!-- -->
		</footer>

		<!-- jquery -->
		<script type="text/javascript" src="assets/components/jquery/jquery.min.js"></script>

		<!-- app -->
		<script type="text/javascript" src="assets/js/main.js"></script>

		<!-- other -->
		<script type="text/javascript">var url = '{{ url('/') }}', token = '{{ Session::token() }}';</script>
		@yield('scripts')
	</body>
</html>
