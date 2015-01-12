@extends('layout')

@section('title')
	Create Team
@stop

@section('content')

<section class="section">
	<h2 class="section-header">Create a Team</h2>

	<p>
		Thanks for your interest in SC2CTL!
		<br />
		To start, all we need is for you to pick a team name and tag. Be aware that team names cannot be
		changed, and must be unique!
		<br />
		Gl, hf!
	</p>
</section>

{{ Form::open([ 'route' => 'team.store', 'class' => 'pure-form pure-form-aligned' ]) }}

<div class="pure-control-group">
	{{ Form::label('name') }}
	{{ Form::text('name') }}
</div>

<div class="pure-control-group">
	{{ Form::label('tag') }}
	{{ Form::text('tag') }}
</div>

<div class="pure-controls">
	{{ Form::submit('Create', [ 'class' => 'button success' ]) }}
</div>

{{ Form::close() }}

@stop
