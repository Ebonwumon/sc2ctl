<style>
.won { font-weight: bold; }
</style>
<div class='match' data-match-id="{{ $match->id }}">
	<div class='pure-g'>
		<div class="match-top tid" data-team-id="{{$match->teams->first()->id}}">
			<div class="pure-u-7-8 @if(isset($win) && $win && $win == $match->teams->first()->id) won @endif team-name">
				<span>
			<?php $profile = ($match->teams->first()->id == 0) ? "#" : URL::route('team.profile', $match->teams->first()->id); ?>
					<a href="{{ $profile }}">[{{ $match->teams->first()->tag}}]</a>
				</span>
			</div>
			<div class="pure-u-1-8">
				<div class="score-box">
					{{ $score[0] }}
				</div>
			</div>
		</div>
		<div class="match-bottom tid" data-team-id="{{$match->teams->last()->id}}">
			<div class="pure-u-7-8 @if(isset($win) && $win && $win == $match->teams->last()->id) won @endif team-name">
				<span>
			<?php $profile = ($match->teams->last()->id == 0) ? "#" : URL::route('team.profile', $match->teams->last()->id); ?>
					<a href="{{ $profile }}">[{{ $match->teams->last()->tag }}]</a>
				</span>
			</div>
			<div class="pure-u-1-8">
				<div class="score-box">
					{{ $score[1] }}
				</div>
			</div>
		</div>
	</div>
</div>
@if (Entrust::can('report_any_match') || (Auth::check() && $match->teamInMatch(Auth::user()->team_id)))
	@if($match->doodle_id)
		<div>
		<a href="{{ $match->doodle_id }}" class="pure-button pure-button-primary">
			View Schedule
		</a>
		</div>
		@if (Entrust::can('report_match') || Entrust::can('report_any_match'))
			@if (!$match->won())
				<a href="{{ URL::route('match.wizard', $match->id) }}" class="pure-button pure-button-good">
					Report Results
				</a>
							@endif
		@endif
	@else
		@include('match/scheduleMatchForm', array('match' => $match))
	@endif

@endif

@if($match->won())
			<a href="{{ URL::route('match.landing', $match->id)}}" class="pure-button pure-button-primary">
					View Results
				</a>

@endif
