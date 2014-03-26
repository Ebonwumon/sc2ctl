@extends('layout')

@section('title')
Create Roster
@stop

@section('content')
<div class="splash">
  <h2>{{ $lineup->qualified_name }}</h2>
  {{ Form::open(array('route' => 'roster.store', 'class' => 'pure-form pure-form-aligned')) }}
    {{ Form::hidden('match_id', $match->id) }}
    {{ Form::hidden('lineup_id', $lineup->id) }}
    <?php $player_list = $lineup->players->lists('qualified_name', 'id'); ?>
    <?php $list_keys = array_keys($player_list); ?>
    @for ($i = 0; $i < $match->bo - 1; $i++)
      <div class="pure-control-group">
        {{ Form::label('user_id[]', "Player for map #" . ($i + 1)) }}
        {{ Form::select('user_id[]', $player_list, $list_keys[$i]) }}
      </div>
    @endfor

    <div class="pure-control-group">
      <label for="confirmed">
        Confirm (you will not be able to edit your roster after confirming)
      </label>
      <input type="checkbox" name="confirmed" />
    </div>

    <div class="pure-controls">
      <input type="submit" value="Create" class="pure-button pure-button-good" />
    </div>

  {{ Form::close() }}
</div>
@stop
