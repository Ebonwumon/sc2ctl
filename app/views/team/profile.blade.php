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
	Currently editing 
  <a href="{{ URL::route('team.profile', $team->id) }}" class="pure-button pure-button-good">
    Done
  </a> &nbsp;
  <a href="{{ URL::route('help') }}" class="pure-button pure-button-primary">
    Help
  </a>
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
			@if ($team->lineups->count() == 0)
        @foreach ($team->members as $user)
          @include('user/profileCardPartial')
          <br />
        @endforeach
      @else
        @foreach($team->lineups as $lineup)
          @include('team/lineupPartial')
        @endforeach
      @endif
		@if ($edit && $team->canCreateLineups(Sentry::getUser()))
			<a href="{{ URL::route('lineup.create', $team->id) }}" class="pure-button pure-button-primary">
				New Lineup
			</a>
      <br />
      <br />
      
      @if ($team->canAddMembers(Sentry::getUser()))
        <div class="splash-bg padded-content">
          {{ Form::open(array('route' => array('team.add', $team->id), 'class' => 'pure-form')) }}
            <legend>Add Members</legend>
            <div class="pure-controls">
              {{ Form::select('user_id', User::listTeamless()) }}
              <br />
              <input type="submit" class="pure-button pure-button-primary" value="Quick Add To Team" />
            </div>
          {{ Form::close() }}
        </div>
        <br />
      @endif

      @if ($team->canRemoveMembers(Sentry::getUser()))
        <div class="splash-bg padded-content">
          {{ Form::open(array('route' => array('team.remove', $team->id), 'class' => 'pure-form')) }}
            <legend>Remove Members</legend>
            <div class="pure-controls">
              {{ Form::select('user_id', $team->members->lists('qualified_name', 'id')) }}
              <br />
              <input type="submit" class="pure-button pure-button-bad" value="Remove From Team" />
            </div>
          {{ Form::close() }}
        </div>
      @endif
    @endif
		</div>
  </div>
</div>
<br />
@if (Sentry::check())
  <div class="pure-control-panel">
    @if(!$edit && ($team->canCreateLineups(Sentry::getUser()) || $team->canEditLineups(Sentry::getUser()))) 
      <a class="pure-button pure-button-primary" href="{{ URL::route('team.edit', $team->id) }}">
        Alter/Create Lineups
      </a>
    @endif
    @if($team->canEditTeam(Sentry::getUser()))
      <a class="pure-button pure-button-secondary" href="{{ URL::route('team.editinfo', $team->id) }}">
        Edit Info
      </a>
    @endif
    @if (Sentry::getUser()->team_id && Sentry::getUser()->team_id == $team->id)
      {{ Form::open(array('route' => array('team.remove', $team->id))) }}
        {{ Form::hidden('user_id', Sentry::getUser()->id) }}
        <input type="submit" value="Leave Team" class="pure-button pure-button-bad" />
      {{ Form::close() }}
    @endif
  </div>
@endif
</div>

<script>
	function bindRemoteCallback(obj) {
		if ($(obj).hasClass('delete')) {
			$(obj).parents('tr:first').hide('fast');
			return true;
		}
		deselect($(obj).parent().find('.remoteAction'));
		$(obj).addClass('selected');
	}
</script>

@stop
