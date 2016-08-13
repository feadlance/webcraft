<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<title>@yield('title', 'Anasayfa') - {{ env('SITE_NAME') }}</title>

		<!-- meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- css -->
		<link rel="stylesheet" type="text/css" href="assets/css/main.css">

		<!-- other -->
		@yield('header')
	</head>
	<body>
		@include ('templates.components.header')
		@include ('templates.components.navigation')

		<main class="clear-after">
			@yield('container')
		</main>

		<footer>
			<div class="footer-left">
				Copyright, 2016
			</div>
		</footer>

		<!-- jquery -->
		<script type="text/javascript" src="assets/components/jquery/jquery.min.js"></script>

	    <!-- semantic ui -->
	    <script type="text/javascript" src="assets/components/semantic-ui/semantic.min.js"></script>

		<!-- app -->
		<script type="text/javascript" src="assets/js/main.js"></script>

		<!-- other -->
		<script type="text/javascript">var url = '{{ url('/') }}', token = '{{ Session::token() }}';</script>
		@yield('scripts')
	</body>
</html>
