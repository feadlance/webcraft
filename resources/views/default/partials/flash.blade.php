@if ( session()->has('flash.info') )
	<script type="text/javascript">
<<<<<<< HEAD
		swal('Hata!', '{!! session('flash.info') !!}', 'info');
=======
		swal('Hata!', '{{ session('flash.info') }}', 'info');
>>>>>>> origin/master
	</script>
@endif

@if ( session()->has('flash.error') )
	<script type="text/javascript">
<<<<<<< HEAD
		swal('Hata!', '{!! session('flash.error') !!}', 'error');
=======
		swal('Hata!', '{{ session('flash.error') }}', 'error');
>>>>>>> origin/master
	</script>
@endif

@if ( session()->has('flash.success') )
	<script type="text/javascript">
<<<<<<< HEAD
		swal('Hata!', '{!! session('flash.success') !!}', 'success');
=======
		swal('Hata!', '{{ session('flash.success') }}', 'success');
>>>>>>> origin/master
	</script>
@endif