@extends('layout')

@section('title')
Tournaments
@stop

@section('content')
@include('ad')
<div class="padded-content">
	<h3>SC2CTL Season 1</h3>
	<div class="box">
		@foreach ($tournaments as $tournament)

			{{ $tournament->name }} 
	
			<a href="{{URL::route('tournament.profile', $tournament->id)}}" class="pure-button pure-button-primary">
				View Tournament
			</a>
			<br />
			<br />
		@endforeach
	</div>
</div>
@stop
