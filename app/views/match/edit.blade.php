@extends('layout')

@section('title')
Edit Match
@stop

@section('additional_head')
<script src="/scripts/select2.min.js"></script>
<link rel="stylesheet" href="/styles/select2.css" />
@stop
@section('content')

{{ Form::model($match, array(
      'route' => array('match.update', $match->id), 
      'class' => 'pure-form pure-form-aligned',
      'method' => "POST"
      )) }}
<div class="pure-g-r">
  <?php
    $games = $match->games;
    $matchCount = $match->games->count();
  ?>
  @for ($i = 0; $i < $match->bo; $i++)
    <div class="pure-u-1-3">
      <?php $default = ($i < $matchCount) ? $games[$i] : array_keys($team1Players)[$i % count($team1Players)];
      if ($i == $match->bo -1) $default = 0;
      ?>
      {{ Form::select('team1Players[]', $team1Players, $default) }}
    </div>
    <div class="pure-u-1-3">
      Game {{ $i + 1 }}
    </div>
    <div class="pure-u-1-3">
      <?php $default = ($i < $matchCount) ? $games[$i] : array_keys($team2Players)[$i % count($team2Players)]; 
      if ($i == $match->bo -1) $default = 0;
      ?>
      {{ Form::select('team2Players[]', $team2Players, $default) }}
    </div>
    <br />
    <br />
  @endfor
</div>
  <div class="pure-control-group">	
	  {{ Form::label('bo', 'Best Of') }}
	  {{ Form::input('number', 'bo') }}
  </div>
	<div class="pure-g-r">
		<div class="pure-u-1-4"></div>
		<div class="pure-u-1-2">
			<div class="participant-pane">
				<div class="pure-g-r">
					<div class="pure-u-1-2">
				<div class="participant participant-one">
					@include('team/profileCardPartial', array('team' => $teams->first()))
				</div>
				</div>
				<div class="pure-u-1-2">
				<div class="participant participant-two">
					@include('team/profileCardPartial', array('team' => $teams->last()))
				</div>
				</div>
			</div>
			</div>
		</div>
	</div>

	{{ Form::submit('Save', array('class' => 'pure-button pure-button-good')) }}
{{ Form::close() }}
<script>
  $(document).ready(function() {
    $('select').select2({ width: "400px" });
  });

</script>

@stop
