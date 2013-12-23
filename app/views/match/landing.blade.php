@extends('layout')

@section('title')
Match Splash Screen
@stop

@section('content')

	<div class="splash">
		<div class="pure-g-r">
			<div class="pure-u-2-3">
				<h1 class="splash-head">{{ $winner->name }} Won!</h1>
				<h2 class="splash-subhead">Congrats to {{ $winner->name }} on being a hero. They're pretty rad
					at this game</h2>
				<p>
					<a href="{{ URL::route('tournament.profile', $match->getTournament()->id) }}" class="pure-button pure-button-good pure-button-large">Thumbs Up, Dude!</a>
				</p>
			</div>
			<div class="pure-u-1-3">
				<h3 class="splash-subhead">Replays</h3>
				<?php $i = 1; ?>
			@foreach ($match->getFinishedGames() as $game)
				<a href="{{$game->replay_url}}" class="pure-button pure-button-primary">
					Game {{$i}} Replay
				</a>
				<br />
				<?php $i++; ?>
			@endforeach
		
			</div>
		</div>
	</div>

@stop
