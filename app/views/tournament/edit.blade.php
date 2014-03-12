@extends('layout')

@section('title')
Admin Tournament
@stop

@section('content')
@if (Sentry::getUser()->hasAccess("register_rosters"))
  {{ Form::open(array('route' => array('tournament.register', $tournament->id), 
                      'class' => 'pure-form pure-form-aligned')) }}
    <div class="pure-control-group">
    {{ Form::label('lineup_id', 'Lineup') }}
    {{ Form::input('number','lineup_id') }}
    {{ Form::submit('Register', array('class' => 'pure-button pure-button-good')) }}
    </div>

  {{ Form::close() }}

  {{ Form::open(array('route' => array('tournament.leave', $tournament->id), 
                      'class' => 'pure-form pure-form-aligned')) }}
    <div class="pure-control-group">
    {{ Form::label('lineup_id', 'Lineup') }}
    {{ Form::select('lineup_id', $tournament->teams->lists('qualified_name', 'id')) }}

    {{ Form::submit('Remove', array('class' => 'pure-button pure-button-bad')) }}
    </div>
  {{ Form::close() }}
@endif

@if (Sentry::getUser()->hasAccess("rename_tournaments"))
  {{ Form::model($tournament, array('route' => array('tournament.update', $tournament->id), 
                                    'class' => 'pure-form pure-form-aligned', 'method' => 'PUT')) }}
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

@endif
<br />
@if ($tournament->phase == 0)
  {{ Form::open(array('route' => array('tournament.start', $tournament->id),
                      'class' => 'pure-form pure-form-aligned')) }}
    <div class="pure-control-group">
      {{ Form::label('due_date', "First week ends on:") }}
      {{ Form::input('date', 'due_date') }}
    </div>
    <div class="pure-controls">
      {{ Form::submit('Start Tournament', array('class' => 'pure-button pure-button-good')) }}
    </div>
  {{ Form::close() }}
@endif
@stop
