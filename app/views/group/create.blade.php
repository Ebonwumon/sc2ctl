@extends('layout')

@section('content')
<div class="padded-content">
<h4>Teams:</h4>
<div id="teams">
	<div id="team1"></div>
	<div id="team2"></div>
	<div id="team3"></div>
	<div id="team4"></div>
</div>

@include('team/selectableSearchPartial')

<button class="selectMany pure-button pure-button-good">Add to Group</button>
<!-- Todo, I should error check to make sure I can't add more than four -->

<br />
<br />
{{ Form::open(array('route' => 'group.store', 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
	{{ Form::label('tournament_id', "Attach To Tournament") }}
	{{ Form::select('tournament_id', $tournaments) }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('phase', "Phase") }}
		{{ Form::input('number', 'phase', 1) }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('multiplier', "Multiplier") }}
		{{ Form::input('number', 'mulitiplier', 1) }}
	</div>
	<div class="pure-controls">
	{{ Form::submit('Create Group', array('class' => 'pure-button pure-button-good')) }}
	</div>
	{{ Form::hidden('team1') }}
	{{ Form::hidden('team2') }}
	{{ Form::hidden('team3') }}
	{{ Form::hidden('team4') }}
	
{{ Form::close() }}
</div>
<script>
	function selectManyAction(selected, obj) {
		var ids = gatherSelected(selected);
		moveCards(selected);
	}
	
	function moveCards(selected) {
		var ids = gatherSelected(selected);
		var available = Array();
		for (var i = 1; i < 5; i++) {
			if ($('input[name=team' + i + ']').val() == "") {
				available.push(i);
			}
		}
		
		selected.each(function(i) {
			$(selected[i]).hide('fast', function() { $(selected[i]).appendTo('#team' + available[i]).show('fast') });
			$('input[name=team' + available[i] + ']').val(getId($(selected[i]).attr('class').split(" ")));
		});
	}
	
</script>
@stop
