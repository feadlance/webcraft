<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<title>@yield('title', 'Anasayfa') - {{ MinecraftServer::name() }}</title>

		<!-- meta -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- font awesome -->
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/font-awesome/css/font-awesome.min.css">

		<!-- css -->
		<link rel="stylesheet" type="text/css" href="global/css/app.css">
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/css/main.css">

		<!-- bootstrap -->
		<link rel="stylesheet" type="text/css" href="templates/{{ $template }}/components/sweetalert/sweetalert.css">

		<!-- other -->
		@yield('header')
	</head>
	<body>
		@include ($template . '.partials.navigation')

		<div class="wrapper">
			@include ($template . '.partials.header')

			<!-- container -->
			<div class="container-fluid clearfix">				
				@yield('container')
			</div>
		</div>

		<footer>
			<!-- -->
		</footer>

		<!-- BUG MODAL -->
		<form id="bugModal" method="post" action="{{ route('bug') }}" class="modal fade">
			{{ csrf_field() }}

			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header text-uppercase">
						Bug Bildirimi
					</div>
					<div class="modal-body">
						<div class="form-group">
							<textarea placeholder="Bir hata gördüyseniz lütfen bildirin..." name="bug[cause]" class="form-control"></textarea>
							<span class="form-control-feedback"></span>
						</div>
						<div class="form-group clearfix">
							<button class="btn btn-secondary pull-right">
								<i class="fa fa-save"></i>
								Gönder
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- BUG MODAL -->

		<!-- app -->
		<script type="text/javascript" src="templates/{{ $template }}/components/jquery/jquery.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/components/tether/tether.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/components/bootstrap/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="templates/{{ $template }}/js/main.js"></script>

		<!-- other -->
		<script type="text/javascript">var url = '{{ url('/') }}', token = '{{ Session::token() }}';</script>
		<script type="text/javascript" src="templates/{{ $template }}/components/sweetalert/sweetalert.min.js"></script>
		@include($template . '.partials.flash')
		@yield('scripts')
	</body>
</html>
