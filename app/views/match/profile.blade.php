@extends('layout')

@section('title')
View Match
@stop

@section('content')
<?php $complete = $match->rostersComplete(); ?>
<?php $match_won = $match->won(); ?>
@if (!$complete && !$match_won)
  <div class="error-box">
    <h2>One or more of the rosters are incomplete!</h2>
    <p>
      In order to remain fair, both teams must confirm their final rosters before either
      is displayed.
    </p>
  </div>
@endif
@if ($match_won)
  <?php $winner = $match->winner(); ?>
<div class="splash about">
  <h2>Match Complete!</h2>
  <p>
    {{ $winner['qualified_name'] }} won with a score of {{ $winner['wins'] }}-{{ $winner['losses'] }}
  </p>
</div>
<br />
@endif
<div class="pure-g-r splash">
  @foreach ($match->teams as $team)
    <div class="pure-u-1-2">
      <h2>{{ $team->qualified_name }}</h2>
      <?php $roster_status = $match->rosterStatus($team->id); ?>
      @if ($roster_status != Roster::STATUS_COMPLETE)
        <div class="error-box">
          <p>
          This roster is unconfirmed
          </p>
        </div>
      @elseif (!$complete)
        <div class="success-box">
            <p>
                This roster is confirmed
            </p>
        </div>
        @if (Sentry::check() && $team->canViewRoster(Sentry::getUser()))
          @foreach ($match->rosterForLineup($team->id)->first()->entries as $entry)
              @include('user/profileCardPartial', array('user' => $entry->player))
              <br />
          @endforeach
        @endif
      @else
        @foreach ($match->rosterForLineup($team->id)->first()->entries as $entry)
          <?php $game = $match->game($entry->map -1); ?>
          @if (count($game) > 0 && $game->winner)
            @include('user/profileCardPartial', array('user' => $entry->player, 'win' => $game->won($entry->player->id), 'loss' => !$game->won($entry->player->id), 'is_default' => $game->is_default, 'replay_url' => $game->replay_url))
          @else
            @include('user/profileCardPartial', array('user' => $entry->player))
          @endif
          <br />
        @endforeach
      @endif
    </div>
  @endforeach
</div>
@if ($match->won())
  <div class="centered">
    <a href="{{ URL::route('match.report', $match->id) }}" class="pure-button pure-button-bad" />
      Dispute Result
    </a>
  </div>
@endif
@stop
