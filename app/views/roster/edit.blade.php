@extends('layout')

@section('title')
Edit Roster
@stop

@section('content')
<div class="splash">
  <h2>{{ $roster->lineup->qualified_name }}</h2>
  {{ Form::model($roster, array('route' => array('roster.update', $roster->id), 
                                'class' => 'pure-form pure-form-aligned')) }}
    <?php $list_keys = array_keys($player_list); ?>
    @for ($i = 0; $i < $roster->match->bo - 1; $i++)
      <div class="pure-control-group">
        {{ Form::label('user_id[]', "Player for map #" . ($i + 1)) }}
        {{ Form::select('user_id[]', $player_list, $list_keys[$i]) }}
      </div>
    @endfor

    <div class="pure-control-group">
      <label for="confirmed">
        Confirm (you will not be able to edit your roster after confirming)
      </label>
      {{ Form::checkbox('confirmed') }}
    </div>

    <div class="pure-controls">
      <input type="submit" value="Update" class="pure-button pure-button-good" />
    </div>

  {{ Form::close() }}
</div>

@stop
