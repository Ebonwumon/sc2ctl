@extends('layout')

@section('title')
Match Reporting Wizard
@stop

@section('content')
<?php $winner = $game->winner(); 
?>

<div class="pure-g-r">
	<div class="splash">
		<div class="pure-u-1-3">
			<div class="l-box">
				<p>
				<a href="{{ $game->replay_url }}" @if (!$game->replay_url) disabled @endif 
   			   		class="pure-button pure-button-primary pure-button-large">
   					View Replay
				</a>
				{{ Form::open() }}
				<div class="hidden-file">
					<input type="file" name="replay" />	
					<button class="pure-button pure-button-large pure-button-good expand-left submit replayLink">
						<span class="spinner"></span>
						{{ ($game->replay_url) ? "Change Replay" : "Submit Replay" }}
					</button>
					{{ Form::close() }}
					<span class="error"></span>
					<br />
				</div>
				</p>
				<button class="forfeit pure-button pure-button-large pure-button-bad expand-left">
					<span class="spinner"></span>Declare Forfeit
				</button>
				<span class="error"></span>

			</div>
		</div>
		<div class="pure-u-2-3">
			<div class="l-box splash-content">
				<div class="pure-g-r">
				<div class="pure-u-1-2">
					<h1 class="splash-head">Process Replay</h1>
				</div>
				<div class="pure-u-1-2">
					<a href="http://ggtracker.com">
						<img src="/img/ggtracker_large.png" width="400px"/>
					</a>
				</div>
				</div>
				<h2 class="splash-subhead">Upload your replay using the buttons to the right. SC2CTL will
					attempt to process them using the beautiful GGTracker.com. Should there be an error
					with processing, you will have the option to manually submit information.</h2>
			</div>
		</div>
	</div>
</div>
@if ($gno < $match->bo)

	<a href="{{URL::route('match.wizard.nextgame', array($match->id, $gno)) }}" 
		class="pure-button pure-button-secondary right expand-left">
		<span class="spinner"></span>Next Game
	</a>
@else
	<a href="{{URL::route('home') }}" class="pure-button pure-button-secondary right">
		Finish
	</a>
@endif

@if ($game->replay_url)
<div class="override">
	@include('match/wizard/override')
</div>
@else
<div class="override" style="display:none;">
</div>
@endif


<script>
function loadOverride() {
	$.ajax({
		type: "GET",
		url: "{{ URL::route('match.wizard', array($match->id, $gno)) }}",
		dataType: "html",
		success: function(data) {
			$('.override').html(data).show('fast');
		},
		error: function(jqxhr) {
			console.log(jqxhr);
		}
	});
}

$('.forfeit').click(function() {
	var obj = this;
	$(obj).attr('data-loading', 'true');

	$.ajax({
		type: "PUT",
		url: "{{ URL::route("game.update", $game->id) }}",
		data: { replay_url: "http://sc2ctl.com/game/forfeit" },
		dataType: "json",
		success: function(data) {
			dispError(obj, "Please select the captain of the winning team and declare winner");
			$(obj).removeAttr('data-loading');
			loadOverride();
		},
		error: function(data) {
			dispError(obj, "AJAX Error. Please reload and try again");
			$(obj).removeAttr('data-loading');
			console.log(data);
		}
	});
});

$('input[type="file"]').change(function(e) {
	var obj = this;	
	$(obj).next().attr('data-loading', "true");
	
	var form = new FormData();
	form.append("replay", this.files[0]);

	$.ajax({
		type: "POST",
		url: "{{ URL::route('replay.upload', $game->id) }}",
		data: form,
		contentType: false,
		processData: false,
		enctype: "multipart/form-data",
		success: function(data) {
			console.log(data);
			if (data.status) {
				dispError(obj, data.message);	
				if (data.status == 1) return;
				loadOverride();
			} 
			$(obj).next().removeAttr('data-loading');
			$('.replayLink').attr('href', data.replayUrl);
		},
		error: function(jqxhr) { 
			dispError(obj, "AJAX Error. Please refresh the page and try again");
			console.log(jqxhr); }
	});
});

</script>
@stop
