@extends('layout')

@section('title')
Manage Rosters
@stop

@section('content')
@foreach ($lineups as $lineup)
  <div class="splash about">
    <h2>Rosters for Lineup: {{ $lineup->qualified_name }}</h2>
    <table class="pure-table">
      <thead>
        <tr>
          <th>Match</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      @foreach ($lineup->activeMatchesForTournament($tournament->id)->get() as $match)
        <tr>
          <td>{{ $match->qualified_name }}</td>
          <td>{{ Roster::displayStatus($match->rosterStatus($lineup->id)) }}</td>
          <td>
            @if ($match->rosterStatus($lineup->id) == Roster::STATUS_UNSTARTED)
              <a href="{{ URL::route('roster.create', 
                            array('match_id' => $match->id, 'lineup_id' => $lineup->id)) }}"
                 class="pure-button pure-button-good">
                Create
              </a>
            @endif
          </td>
        </tr>
      @endforeach
    </table>
  </div>
  <br />
@endforeach
@stop
