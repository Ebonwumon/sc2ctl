@extends('layout')

@section('title')
Round
@stop

@section('content')

	@include('round/bracketDisplayPartial')


	@if (Entrust::can('generate_matches')) 
		{{ Form::open(array('route' => array('round.generate', $tournament->id))) }}
			{{ Form::submit('Generate Matches', array('class' => 'pure-button pure-button-good')) }}
		{{ Form::close() }}
	@endif
@stop
