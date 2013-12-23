@extends('layout')

@section('content')

{{ $game->playerone->bnet_name }} vs. {{ $game->playertwo->bnet_name }}

<br />
<div class="padded-content">
	@if ($game->replay_url)
	<a href="{{ $game->replay_url }}" class="pure-button pure-button-primary">
		View Replay
	</a>
	@endif
</div>
@stop
