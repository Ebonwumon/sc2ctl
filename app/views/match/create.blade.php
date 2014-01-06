@extends('layout')

@section('title')
Create Match
@stop

@section('additional_head')
<script src="/scripts/select2.min.js" ></script>
<link rel="stylesheet" href="/styles/select2.css" />
@stop

@section('content')
{{ Form::open(array('route' => 'match.store', 'class' => 'pure-form pure-form-aligned')) }}
  <div class="pure-control-group">
    {{ Form::label('teams[]', 'Teams') }}
    {{ Form::select('teams[]', $teams, null, array('id' => 'teams', 'multiple')) }}
  </div>
  
  <div class="pure-control-group">
		<label for="bo">Best Of:</label>
		{{ Form::input('number', 'bo', 7) }}
	</div>
		
	<div class="pure-controls">
	{{ Form::submit('Create', array('class' => "pure-button pure-button-good")) }}
	</div>
{{ Form::close() }}

<script>
  $(document).ready(function() {
      $('select[id=teams]').select2({ maximumSelectionSize: 2, width: "400px" });
  });
</script>
@stop
