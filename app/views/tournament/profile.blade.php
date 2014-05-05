@extends('layout')

@section('title')
Tournament Profile
@stop

@section('content')
<div class="splash">
    <div class="pure-g-r">
        <div class="pure-u-1-3">
            <div class="l-box">
                <img width="300px" src="/img/{{$tournament->division}}.png"/>
            </div>
        </div>
        <div class="pure-u-2-3">
            <h1 class="splash-head">{{ $tournament->name }}</h1>

            <h2 class="splash-subhead">Current Phase: {{ $tournament->getPhase() }}</h2>
            @if ($tournament->getPhase() == "Completed")
            <span class="splash-subhead" style="font-size: 150%; font-weight:bold;">Winner:</span><br/>
            @include('team/profileCardPartial', array('team' => Team::find($tournament->winner)))
            @endif
            @if (Sentry::check() && $tournament->phase > 0 && $tournament->userInTournament(Sentry::getUser()))
            <a href="{{ URL::route('roster.index', $tournament->id) }}"
               class="pure-button pure-button-large pure-button-primary">
                Manage Roster Submissions
            </a>
            @endif
        </div>
    </div>
</div>
<br/>
<div class="splash">
    @if ($phase == 0)
    @include('tournament/registrationPhase')

    @elseif ($phase == 1)
    <div class="pure-g-r">
        <div class="pure-u-1-3">
            <table class="pure-table pure-table-striped">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Team</th>
                        <th>Wins</th>
                        <th>Losses</th>
                        <th>Score</th>
                    </tr>
                </thead>
                <?php $i = 1; ?>
                @foreach ($summary as $score)
                <tr>
                    <td>{{ $i }}</td> <?php $i++; ?>
                    <td>
                      <a href="{{ URL::route('lineup.matches', $score->lineup->id) }}">
                        {{ $score->name }}
                      </a>
                    </td>
                    <td>{{ $score->wins }}</td>
                    <td>{{ $score->losses }}</td>
                    <td>{{ $score->score() }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="pure-u-2-3">
            <div class="pure-g-r">

                @foreach($data->matches as $match)
                <div class="pure-u-1-2">
                    @include('match/matchCardPartial')
                </div>
                @endforeach

            </div>
        </div>
    </div>


    @elseif ($phase == 3)
    @if ($phase)
    <br/>
    <br/>

    <div class="box">
        <h3>Total Standings</h3>
        @include('tournament/globalStandings', array('groups' => $data))
    </div>
    <br/>
    @include('ad')

    @include('group/multipleGroupDisplay', array('groups' => $data))

    @endif

    <h2>Hello everyone!</h2>

    <h3>There was a problem with automatic bracket generation, but you can view the starting bracket here:
        <a href="http://dev.sc2ctl.com/blog/10">http://dev.sc2ctl.com/blog/12</a>. Please report your match results
        (with replays) via email to adult@sc2ctl.com!</h3>
    @elseif ($tournament->phase == -1)
    This tournament is completed. Open data on the tournament will be available
    soon &trade;
    @else
    <br/>
    <br/>

    <div class="box">
        <h3>Total Standings</h3>
        @include('tournament/globalStandings', array('groups' => $data))
    </div>
    <br/>
    @include('ad')

    @include('group/multipleGroupDisplay', array('groups' => $data))
    @endif
</div>
@stop
