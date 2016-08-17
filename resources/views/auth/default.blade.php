<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Aramıza Katıl - {{ MinecraftServer::name() }}</title>
		<!-- CSS -->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
		<link rel="stylesheet" href="assets/components/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/components/sweetalert/sweetalert.css">
		<link rel="stylesheet" href="assets/css/guest.css">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Favicon and touch icons -->
		<link rel="shortcut icon" href="favicon.ico">
	</head>
	<body>
		<!-- Top content -->
		<div class="top-content">
			<div class="inner-bg">
				<div class="container">
					@yield('container')
				</div>
			</div>
		</div>
		<!-- Footer -->
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="footer-border"></div>
						<p>
							Bu site, <a href="http://davutabi.com" style="border-bottom: 1px dotted #fff;">Davutabi</a> tarafından değerli takipçileri için hediye niteliğinde yapılmıştır.
						</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- Javascript -->
		<script type="text/javascript" src="assets/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="assets/components/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="assets/js/guest/jquery.backstretch.min.js"></script>
		<script type="text/javascript" src="assets/components/sweetalert/sweetalert.min.js"></script>
		<script type="text/javascript">
			$(function() {
			    $.backstretch("assets/images/auth-bg.jpg");
			});

			var token = '{{ Session::token() }}', url = '{{ url('/') }}';
		</script>
		<script type="text/javascript" src="assets/js/request.js"></script>
		<!--[if lt IE 10]>
		<script src="assets/js/guest/placeholder.js"></script>
		<![endif]-->
	</body>
</html>