@extends('layout')

@section('content')

<h3>New Role</h3>

{{ Form::open(array('route' => array('role.store'), 'class' => "pure-form pure-form-aligned")) }}

	<div class="pure-control-group">
		<label for="name">Name</label>
		{{ Form::text('name') }}
	</div>
	
	<div class="pure-controls">
		{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}

@stop
