@extends('layout')

@section('content')

{{ Form::open(array('route' => 'permission.store', 'class' => 'pure-form pure-form-aligned')) }}
	
	<div class="pure-control-group">
		{{ Form::label('name') }}
		{{ Form::text('name') }}
	</div>
	
	<div class="pure-control-group">
		{{ Form::label('display_name') }}
		{{ Form::text('display_name') }}
	</div>

	<div class="pure-control-group">
		<label for='role'>Attach to Role:</label>
		{{ Form::select('role', $roles) }}
	</div>

	<div class="pure-controls">
		{{ Form::submit('Save', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}

@stop
