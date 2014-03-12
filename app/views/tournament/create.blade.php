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
  <div class="pure-control-group">
    {{ Form::label('season') }}
{{ Form::select('season_id', Season::lists('name', 'id')) }}
  </div>

	<div class="pure-controls">
		{{ Form::submit('Create', array('class' => 'pure-button pure-button-good')) }}
	</div>
{{ Form::close() }}

<h3>New Season</h3>
{{ Form::open(array('route' => 'tournament.store_season', 
                    'class' => 'pure-form pure-form-aligned')) }}

  <div class="pure-control-group">
    {{ Form::label('name') }}
    {{ Form::text('name') }}
  </div>

  <div class="pure-control-group">
    {{ Form::label('start_date') }}
    {{ Form::input('date', 'start_date') }}
  </div>

  <div class="pure-control-group">
    {{ Form::label('end_date') }}
    {{ Form::input('date', 'end_date') }}
  </div>

  <div class="pure-controls">
    <input type="submit" value="Create" class="pure-button pure-button-good" />
  </div>

{{ Form::close() }}
@stop
