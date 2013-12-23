@extends('layout')

@section('content')

{{ Form::open(array('route' => 'tournament.store', 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
		{{ Form::label('name', 'Name') }}
		{{ Form::text('name') }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('division', 'Division') }}
		{{ Form::select('division', array('BSG' => 'BSG', 'PD' => 'Platinum-Diamond', 'DM' => 'Diamond-Masters', 'MGM' => 'Masters-Grandmasters')); }}
	</div>

	<div class="pure-controls">
		{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}
@stop
