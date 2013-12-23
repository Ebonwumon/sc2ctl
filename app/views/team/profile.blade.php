@extends('layout')

@section('background')
background-wrapper clown-background
@stop


@if ($edit)
	@section('additional_head')
		<link href="/styles/select2.css" rel="stylesheet"/>
		<script src="/scripts/select2.min.js"></script>
	@stop
@endif

@section('title')
{{ $team->tag }}'s Profile
@stop

@section('content')
@if ($edit)
<div class="current-action-bar">
	Currently editing <a href="{{ URL::route('team.profile', $team->id) }}" class="pure-button pure-button-good">Done</a>
</div>
@endif
<div class="padded-content">
	<div class="pure-g-r">
		<div class="pure-u-2-3 floating-color team-info-panel">
				<img class="team-banner" src="{{ $team->banner_url }}" />
				<div class="team-info">
							<img class="team-logo" src="{{ $team->logo_url }}" />
				</div>
				<div class="team-info padded-content">
					<h1 class="splash-head">{{ $team->name }}</h1>
				<p class="team-description">
					{{ $team->description }}
				</p>
				<p>
					<strong>Founder</strong>: <a href="{{ URL::route('user.profile', $team->user_id) }}">{{ $team->user->bnet_name }}#{{ $team->user->char_code }}</a><br />
					@if ($team->website)
						<strong>Website</strong>: <a href="{{ $team->website }}">{{$team->website}}</a> <br />
					@endif

					@if($team->social_fb)
						<strong>Facebook</strong>: <a href="{{ $team->social_fb }}">{{$team->social_fb }}</a> <br />
					@endif
					
					@if($team->social_twitter)
						<strong>Twitter</strong>: <a href="{{ $team->social_twitter }}">{{$team->social_twitter}}</a> <br />
					@endif

					@if($team->social_twitch)
						<strong>Twitch</strong>: <a href="{{ $team->social_twitch }}">{{$team->social_twitch}}</a> <br />
					@endif
					</div>
		</div>
	<div class="pure-u-1-3">
		<div class="team-rosters">
			@foreach($team->lineups as $lineup)
				@include('team/lineupPartial')
			@endforeach
		@if ($edit)
			<a href="{{ URL::route('lineup.create', $team->id) }}" class="pure-button pure-button-primary">
				Add Lineup
			</a>
		@endif
		</div>
	</div>	
</div>
</div>
<div class="pure-control-panel">
@if (Auth::check() && Auth::user()->canManageTeam($team->id))
<a href="{{ URL::route('team.editinfo', $team->id) }}" class="pure-button pure-button-primary">Edit Info</a>
<a href="{{ URL::route('team.edit', $team->id) }}" class="pure-button pure-button-secondary">Manage Team</a>
@endif


@if (Auth::check() && Auth::user()->team_id == $team->id)
{{ Form::open(array('url' => 'user/leaveteam')) }}

	{{ Form::submit('Leave Team', array('id' => 'leaveTeam', 'class' => 'pure-button pure-button-bad')) }}

{{ Form::close() }}
@else

<button class="pure-button pure-button-good" disabled>Request to Join</button> 
<span>Unimplemented. Contact your team captain to be added.</span>
@endif
<span class="error"></span>
</div>

@if (Entrust::hasRole('team_captain') && $team->members->count() > 1)
<script>
	$('#leaveTeam').click(function(e) {
		e.preventDefault();
		$(this).parents().closest('.pure-control-panel').find('.error').show('fast').html('You must promote another member to leader before leaving');

	});
</script>

@endif
</div>

<script>
	function bindRemoteCallback(obj) {
		if ($(obj).hasClass('delete')) {
			$(obj).parent().hide('fast');
			return true;
		}
		deselect($(obj).parent().find('.remoteAction'));
		$(obj).addClass('selected');
	}
</script>

@stop
