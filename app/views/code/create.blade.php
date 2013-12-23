@extends('layout')

@section('title')
Create Code
@stop

@section('content')
{{ Form::open(array('route' => 'code.store', 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
	{{ Form::label('text') }}
	{{ Form::text('text') }}
	</div>
	<div class="pure-control-group">
		{{ Form::label('expiry') }}
		{{ Form::input('date', "expiry") }}
	</div>
	<div class="pure-controls">
		{{ Form::submit('Create Code', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}
@stop
