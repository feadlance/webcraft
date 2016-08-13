@extends('templates.app')

@section('title', 'Oyuncular')

@section('breadcrumb')
	<li>Oyuncular</li>
@stop

@section('container')
	<div class="ui special cards">
		@foreach ( $users as $user )
			@include('templates.user.card_block')
		@endforeach
	</div>
@stop