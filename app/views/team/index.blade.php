@extends('layout')

@section('title')
All Teams
@stop

@section('content')
@include('ad')
<div class="padded-content">
<table class="pure-table pure-table-horizontal">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Owner</th>
		</tr>
	</thead>
<?php $i=1; ?>
@foreach ($teams as $team)
<?php $owner = $team->user; ?>
<tr>
	<td>{{ $i }}</td>
	<td>
		<a href="{{ URL::route('team.profile', $team->id) }}">
			{{ $team->name }}
		</a>
	</td>
	<td>
		<a href="{{ URL::route('user.profile', $owner->id) }}">
			{{ $owner->username }}
		</a>
	</td>
</tr>
<?php $i++; ?>
@endforeach
</table>
<br />
@if (Sentry::check())
<a href="{{ URL::route('team.create') }}" 
        @if (Sentry::getUser()->team_id) disabled @endif 
        class="pure-button pure-button-good">
	Create Team
</a>
@endif
</div>
@stop
