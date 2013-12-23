@extends('layout')

@section('content')

{{ Form::model($match, array('route' => array('match.update', $match->id))) }}
	
	{{ Form::label('bo', 'Best Of') }}
	{{ Form::input('number', 'bo') }}
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
	{{ Form::hidden('team1') }}
	{{ Form::hidden('team2') }}

	{{ Form::submit('Save', array('class' => 'pure-button pure-button-good')) }}
{{ Form::close() }}

@include('team/selectableSearchPartial')
<button class="pure-button pure-button-good selectOne expand-left">
	<span class="spinner"></span>Replace Player
</button>
{{ Form::select('replace', array(1 => 'Team 1', 2 => 'Team 2')) }} <span class="error"></span>
{{ Form::open(array('class' => 'pure-form pure-form-aligned')) }}
	<?php $i = 1; ?>
	@foreach ($match->games()->get() as $game)
		<div class="pure-control-group">
		{{ Form::label('game'. $i, 'Game ' . $i) }}
		{{ Form::select('game'. $i, array('None', 
									$game->playerone->bnet_name, $game->playertwo->bnet_name),
									$game->winner, array('data-id' => $game->id)) 
									}}
		<button class="pure-button pure-button-good expand-left set" >
			<span class="spinner"></span>Set
		</button>
		</div>
	<?php $i++; ?>
	@endforeach

{{ Form::close() }}

<script>

	function selectOneAction(selected, obj) {
		$(obj).attr('data-loading', 'true');
		
		// TODO AJAX
		
		moveCards(selected);
		$(obj).removeAttr('data-loading');
	}

	function moveCards(selected) {
		if ($('[name=replace]').val() == 1) {
			$('.participant-one').html(selected);
		}
	}

	$('.set').click(function(e) {
		e.preventDefault();
		var obj = this;
		$(this).attr('data-loading', 'true');
		var myData = { winner: $(this).prev('[id^=game]').val() }	
		var id = $(this).prev('[id^=game]').data('id');
		$.ajax({
			type: "PUT",
			url: "/game/" + id + "/report",
			data: myData,
			dataType: "json",
			success: function(data) {
				if (data.status) {
				} else {
					$(obj).removeAttr('data-loading');
				}
			},
			error: function(jqxhr) {
				console.log(jqxhr);
			}
		});
	});
</script>

@stop
