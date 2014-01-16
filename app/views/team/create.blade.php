@extends('layout')

@section('title')
	Create Team
@stop

@section('content')
<div class="padded-content">
	<h2>Create a Team</h2>
	<p class="splash-subhead about">Thanks for your interest in SC2CTL! 
	<br />To start, all we need is for you to pick a team name and tag. Be aware that team names cannot be 
	changed, and must be unique! 
  <br />
	Gl, hf!
	</p>
</div>
{{ Form::open(array('route' => 'team.store', 'class' => 'pure-form pure-form-aligned')) }}

<div class="pure-control-group">
	{{ Form::label('name') }}
	{{ Form::text('name', null, array('class' => 'validates')) }}
</div>

<div class="pure-control-group">
	{{ Form::label('tag') }}
	{{ Form::text('tag') }}
</div>
<div class="pure-controls">
	{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}
</div>
{{ Form::close() }}

@stop
