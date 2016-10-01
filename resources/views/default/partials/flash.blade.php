@if ( session()->has('flash.info') )
	<script type="text/javascript">
		swal('Hata!', '{!! session('flash.info') !!}', 'info');
	</script>
@endif

@if ( session()->has('flash.error') )
	<script type="text/javascript">
		swal('Hata!', '{!! session('flash.error') !!}', 'error');
	</script>
@endif

@if ( session()->has('flash.success') )
	<script type="text/javascript">
		swal('Hata!', '{!! session('flash.success') !!}', 'success');
	</script>
@endif