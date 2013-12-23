@extends('layout')

@section('title')
	Create Team
@stop

@section('content')
<div class="padded-content">
	<h2>Create a Team</h2>
	<p class="splash-subhead about">Thanks for your interest in SC2CTL! 
	<br />To start, all we need is for you to pick a team name and tag. Be aware that team names cannot be 
	changed, and must be unique! If you're registering multiple divisions, you should add some qualifier
	to your team name, eg. "My Team (Silver Division)".
	<br />
	After you've created a team, you will be set as team leader, and team contact. You can offload these
	responsibilities and add new members as soon as you've finished creating your team.
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

{{ Form::hidden('leader', Auth::user()->id) }}
{{ Form::hidden('contact', Auth::user()->id) }}
<div class="pure-controls">
	{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}
</div>
{{ Form::close() }}

@stop
