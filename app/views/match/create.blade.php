@extends('layout')

@section('content')

{{ Form::open(array('route' => 'match.store', "class" => "pure-form pure-form-aligned")) }}
	{{ Form::hidden('team1') }}
	{{ Form::hidden('team2') }}
	<div class="pure-control-group">
		<label for="bo">Best Of:</label>
		{{ Form::input('number', 'bo', 1) }}
	</div>
	
	<div class='box'>
		<div class="pure-g">
			<div class="pure-u-1-2">
				<h3>Team 1</h3>
				<div id="team1">
				</div>
			</div>
			<div class="pure-u-1-2">
				<div id="team2">
				</div>
			</div>
		</div>
	</div>
	
	<div class="pure-controls">
	{{ Form::submit('Create', array('class' => "pure-button pure-button-good")) }}
	</div>
{{ Form::close() }}

@include('team/selectableSearchPartial')

<button class='pure-button pure-button-good expand-left selectOne' id="addTeam1">
	<span class="spinner"></span>Make Team 1
</button>
<button class="pure-button pure-button-good expand-left selectOne" id="addTeam2">
	Make Team 2
</button>
<span class="error"></span>

<script>
	function selectOneAction(selected) {
		console.log("eggs");
		moveCards(selected);
	}
	
	function moveCards(selected) {
		selected.each(function(i) {
			$(selected[i]).hide('fast', function() { $(selected[i]).appendTo('#team' + t).show('fast') });
		});
	}
</script>
@stop
