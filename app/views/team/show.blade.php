@extends('layout')

@section('title')
{{ $team->tag }}'s Profile
@stop

@section('content')
 <!--   <div class="team-info-grid">
        <div class="team-info-col">hi</div>
    </div>-->
<div class="pure-g team-info-grid">
    <div class="pure-u-1 pure-u-md-1-2 team-info-col">
        <div class="team-info-panel">

            <div class="image-header">
                <div class="team-banner">
                    <img src="{{ $team->banner_img }}" />
                </div>
                <div class="team-logo">
                    <img class="team-logo" src="{{ $team->logo_img }}" />
                </div>
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
    </div>

    <div class="pure-u-1 pure-u-md-1-2 team-info-col">
        <div class="team-lineups">
            <h2 class="section-header">Team Lineups</h2>
            @forelse([] as $lineup)

            @empty
                <em>There are no team lineups for this team</em>
            @endforelse

        </div>
    </div>
</div>



@stop
