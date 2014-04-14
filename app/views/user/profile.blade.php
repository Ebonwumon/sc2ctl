@extends('layout')
@section('title')
	{{ $user->username }}'s Profile
@stop

@section('content')
<div class="padded-content splash colour-purple">
  <div class="pure-g-r">
    @if (Sentry::check() && Sentry::getUser()->id == $user->id)
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
      @if ($user->team_id != 0)
        <h3>Team</h3>
        @include('team/profileCardPartial', array('team' => $user->team))
      @endif
    </div>
    <div class="pure-u-1-3">
    </div>
    <div class="pure-u-1-3">
    </div>
  </div>
</div>
@if (Sentry::check() && Sentry::getUser()->id == $user->id)
  <a href="{{ URL::route('user.edit', $user->id) }}" class="pure-button pure-button-primary">
	  Edit Profile
  </a>
@endif
@if (Sentry::check())
<p>
  <a href="mailto:{{ $user->email }}" class="pure-button pure-button-orange">
    Send Email
  </a>
</p>
@endif
@stop
