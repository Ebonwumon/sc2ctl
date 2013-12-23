@extends('layout')

@section('title')
Admin Tournament
@stop

@section('content')
{{ Form::open(array('route' => array('tournament.addteam', $tournament->id), 'class' => 'pure-form')) }}

	{{ Form::label('team_id', 'Team ID') }}
	{{ Form::input('number','team_id') }}

	{{ Form::submit('Register', array('class' => 'pure-button pure-button-good')) }}

{{ Form::close() }}

{{ Form::open(array('route' => array('tournament.removeteam', $tournament->id), 'class' => 'pure-form')) }}

	{{ Form::label('team_id', 'Team ID') }}
	{{ Form::input('number', 'team_id') }}

	{{ Form::submit('Remove', array('class' => 'pure-button pure-button-bad')) }}

{{ Form::close() }}

ADMINS
{{ Form::model($tournament, array('route' => array('tournament.update', $tournament->id), 'class' => 'pure-form pure-form-aligned', 'method' => 'PUT')) }}
	<div class="pure-control-group">
	{{ Form::label('name', "Name") }}
	{{ Form::text('name') }}
	</div>
	<div class="pure-control-group">
	{{ Form::label('phase', "Current Phase") }}
	{{ Form::input('number', 'phase') }}
	</div>

	<div class="pure-controls">
		{{ Form::submit('Save Tournament', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}

<br />
{{ Form::open(array('route' => array('tournament.generategroups', $tournament->id))) }}

	{{ Form::submit('Generate Groups', array('class' => 'pure-button pure-button-good')) }}
{{ Form::close() }}

@stop
