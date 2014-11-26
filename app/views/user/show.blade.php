@extends('layout')
@section('title')
{{ $user->username }}'s Profile
@stop

@section('content')
<div class="pure-g">
    @if (Auth::check() && Auth::user()->id == $user->id)
    <div class="pure-u-1">
        <h3>Notifications</h3>

        <div class="notifications">
            [1] Some notifications
        </div>
    </div>
    @endif

    <div class="pure-u-1-3">
        <h3>User</h3>
        <strong>Username: </strong> {{ $user->username }}
        @if ($user->currentlyOnTeam())
            <h3>Team</h3>
            {{ $user->team->full_name }}
        @endif
    </div>
    <div class="pure-u-1-3">
    </div>
    <div class="pure-u-1-3">
    </div>
</div>
@if (Auth::check() && Auth::getUser()->id == $user->id)
    <a href="{{ URL::route('user.edit', $user->id) }}" class="pure-button pure-button-primary">
        Edit Profile
    </a>
@endif
@if (Auth::check())
[ Some messaging here ]
@endif

@if ($user->hasConnectedBattleNet())
<p>
    <a href="{{ $user->bnet->url }}" class="pure-button pure-button-secondary">
        Battle.net Profile
    </a>
</p>
@endif


@stop
