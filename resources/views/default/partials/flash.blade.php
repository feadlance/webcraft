@if ( session()->has('flash.info') )
	<div class="row">
		<div class="col-lg-12">
			<div class="alert alert-info">
				{{ session('flash.info') }}
			</div>
		</div>
	</div>
@endif