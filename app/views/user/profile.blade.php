@extends('layout')
@section('title')
	{{ $user->username }}'s Profile
@stop
@section('content')
<div class="padded-content">
<?php $member = $user; ?>
<div class="pure-g-r">
	@if (Auth::check() && Auth::user()->id == $user->id)
	<div class="pure-u-1">
		<h3>Notifications</h3>
		<div class="notification-box">
			@include('notification/notificationsPartial')
		</div>
	</div>
	@endif
	
	<div class="pure-u-1-3">
		<h3>User</h3>
		@include('user/profileCardPartial')
		Battle.net Name: {{ $user->bnet_name }}.{{ $user->char_code }}
		@if ($user->team_id != 0)
			<h3>Team</h3>
			@include('team/profileCardPartial', array('team' => $user->team))
			@if ($user->team->contact == $user->id || $user->team->leader == $user->id)
				<a href="mailto:{{$user->email}}" class="pure-button pure-button-primary">
					Contact
				</a>
			@endif
		@endif
	</div>
	<div class="pure-u-1-3">
		<h3>Recent Games</h3>
		@if ($games->count())
			@foreach ($games as $game)
				<a class="pure-button pure-button-primary" href="{{ URL::route('game.profile', $game->id) }}">
					View Game
				</a>

			@endforeach
		@else
			<span class="splash-subhead">No games played yet</span>
		@endif
	</div>
	<div class="pure-u-1-3">
		<h3>Statistics</h3>
		<table class="pure-table">
			<thead>
				<tr>
					<th>Wins</th>
					<th>Losses</th>
					<th>%</th>
				</tr>
			</thead>
			<tr>
				<td>{{ $wins }}</td>
				<td>{{ $losses }}</td>
				<td>{{ $ratio }}</td>
			</tr>
		</table>
	</div>
</div>
</div>
@if (Auth::check() && Auth::user()->id == $user->id)
<a href="{{ URL::route('user.edit', $user->id) }}" class="pure-button pure-button-primary">
	Edit Profile
</a>
@endif
@stop
