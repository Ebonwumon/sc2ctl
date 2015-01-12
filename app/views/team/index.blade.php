@extends('layout')

@section('title')
All Teams
@stop

@section('content')

@if (Auth::check() && !Auth::user()->currentlyOnATeam())
    <div class="call-to-action">
        <a href="{{ URL::route('team.create') }}" class="button success">
            Create Team
        </a>
    </div>
@endif

<div class="pure-g">
    @forelse ($teams as $team)
        <div class="pure-u-1 pure-u-md-1-3">
            @include ('team/profileCardPartial')
        </div>
    @empty
        <div class="pure-u-1">
            <h2 class="centered">There are no currently registered teams.</h2>
        </div>
    @endforelse
</div>

@stop
