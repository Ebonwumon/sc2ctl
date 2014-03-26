@extends('layout')

@section('title')
All Teams
@stop

@section('content')
<div class="centered">
  @if (Sentry::check())
    <p>
      <a href="{{ URL::route('team.create') }}" 
              @if (Sentry::getUser()->team_id) disabled @endif 
              class="pure-button pure-button-good pure-button-massive">
        Create Team
      </a>
    </p>
  @endif

  <div class="floating-color">
    <div class="pure-g-r">
      @foreach ($teams as $team)
        <div class="pure-u-1-3">
          @include ('team/profileCardPartial')
        </div>
      @endforeach
    </div>
  </div>
</div>
@stop
