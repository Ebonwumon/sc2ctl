@extends('layout')

@section('title')
{{ $team->tag }}'s Profile
@stop

@section('content')
<div class="pure-g">
    <div class="pure-u-2-3 team-info-panel">
        <div class="team-banner">
            <img src="{{ $team->banner_img }}" />
        </div>
        <div class="team-logo">
            <img class="team-logo" src="{{ $team->logo_img }}" />
        </div>
        <div class="team-info">
            <h1>{{ $team->name }}</h1>
            <p class="team-description">
                {{ $team->description }}
            </p>
            <p>
                <strong>Founder</strong>:
                <a href="{{ URL::route('user.show', $team->getOwner()->id) }}">
                    {{ $team->getOwner()->bnet->qualified_name }}
                </a>
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
            </p>
        </div>
    </div>

    <div class="pure-u-1-3">
        <div class="team-lineups">
            </div>
        </div>
    </div>



@stop
