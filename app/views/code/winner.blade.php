@extends('layout')

@section('title')
Code Winner
@stop

@section('content')

{{ Form::open(array('route' => 'code.getWinner', 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
		{{ Form::label('date') }}
		{{ Form::input('date', 'date') }}
	</div>

	{{ Form::submit('Choose') }}

{{ Form::close() }}

@stop
