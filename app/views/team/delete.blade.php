@extends('layout')

@section('title')
Delete Team
@stop

@section('content')
<div class="splash">
  <h2>Delete team {{ $team->name }}</h2>

  {{ Form::open(array('route' => array('team.destroy', $team->id), 
                      'class' => 'pure-form pure-form-aligned',
                      'method' => 'DELETE')) }}

    <div class="pure-control-group">
      <label for="confirmation">
        <input type="checkbox" required name="confirmation" />
        Confirm?
      </label>
    </div>
    <div class="pure-controls">
      <input type="submit" value="Delete" class="pure-button pure-button-bad" />
    </div>
  {{ Form::close() }}
</div>
@stop
