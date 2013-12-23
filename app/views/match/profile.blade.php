@extends('layout')


@section('content')

<div class="padded-content">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			@include('match/matchCardPartial')
		</div>
		<div class="pure-u-2-3">
			<h3>Replays</h3>
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
@stop
