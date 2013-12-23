@extends('layout')

@section('title')
Create New Notification
@stop

@section('content')

<div class="padded-content">
	{{ Form::open(array('route' => 'notification.store', 'class' => 'pure-form pure-form-aligned')) }}
		<div class="pure-control-group">
		{{ Form::label('text') }}
		{{ Form::text('text') }}
		</div>
		<div class="pure-control-group">
		{{ Form::label('action_url') }}
		{{ Form::text('action_url') }}
		</div>
		
		<div class="pure-control-group">
		{{ Form::label('recipients', "Captains") }}
		{{ Form::checkbox('recipients[]', 'captains') }}
		</div>

		<div class="pure-control-group">
			{{ Form::label('recipients', "All Members") }}
			{{ Form::checkbox('recipients[]', "all") }}
		</div>

		<div class="pure-control-group">
			{{ Form::label('recipients', "Additional Members") }}
			{{ Form::checkbox('recipients[]', "add") }}
		</div>

		<div class="pure-controls">
			{{ Form::submit('Send Notification', array('class' => 'pure-button pure-button-good')) }}
		</div>
	{{ Form::close() }}

</div>

@stop
