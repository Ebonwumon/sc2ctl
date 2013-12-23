@extends('layout')


@section('content')

{{ Form::open(array('route' => 'game.store')) }}

	{{ Form::input('number', 'team') }}
	{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}

{{ Form::close() }}

@stop
