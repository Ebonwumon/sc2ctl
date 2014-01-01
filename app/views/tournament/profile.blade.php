@extends('layout')

@section('title')
Tournament Profile
@stop

@section('content')
<div class="splash">
  <div class="pure-g-r">
    <div class="pure-u-1-3">
			<div class="l-box">
				<img width="300px" src="/img/{{$tournament->division}}.png" />
			</div>
		</div>
		<div class="pure-u-2-3">
			<h1 class="splash-head">{{ $tournament->name }}</h1>
			<h2 class="splash-subhead">Current Phase: {{$tournament->getPhase() }}</h2>
		</div>
	</div>
</div>
<div class="padded-content">
@if ($tournament->phase == 0)

	<h3>Registered Teams</h3>
	<div class="box">
		@include('team/multipleCardPartial', array('teams' => $tournament->teams()->get()))
	</div>
	<br />
	@if (Entrust::hasRole('team_captain'))
		@if (!$tournament->isInTournament(Auth::user()->team_id))
			{{ Form::open(array('route' => array('tournament.register', $tournament->id))) }}
				{{ Form::submit('Register', array('class' => "pure-button pure-button-good")) }}
			{{ Form::close() }}
		@else
			{{ Form::open(array('route' => array('tournament.leave', $tournament->id))) }}
				{{ Form::submit('Leave', array('class' => 'pure-button pure-button-bad')) }}
			{{ Form::close() }}
		@endif
	@endif

@elseif ($tournament->phase == 1)
<br />
<br />
<div class="box">
	<h3>Total Standings</h3>
	@include('tournament/globalStandings', array('groups' => $data))
</div>
	@include('ad')
<hr />
@include('group/multipleGroupDisplay', array('groups' => $data))

@elseif ($tournament->phase == 3)
	@if ($phase)
	<br />
<br />
<div class="box">
	<h3>Total Standings</h3>
	@include('tournament/globalStandings', array('groups' => $data))
</div>
<br />
@include('ad')

@include('group/multipleGroupDisplay', array('groups' => $data))

	@endif

	<h2>Hello everyone!</h2>
	<h3>There was a problem with automatic bracket generation, but you can view the starting bracket here:
	<a href="http://dev.sc2ctl.com/blog/10">http://dev.sc2ctl.com/blog/12</a>. Please report your match results (with replays) via email to adult@sc2ctl.com!</h3>
@elseif ($tournament->phase == -1)
  This tournament is completed. Open data on the tournament will be available
  soon &trade;
@else 
<br />
<br />
<div class="box">
	<h3>Total Standings</h3>
	@include('tournament/globalStandings', array('groups' => $data))
</div>
<br />
@include('ad')

@include('group/multipleGroupDisplay', array('groups' => $data))
@endif
</div>
@stop
