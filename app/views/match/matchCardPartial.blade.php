<style>
    .won {
        font-weight: bold;
    }
</style>

<div class='match' data-match-id="{{ $match->id }}">
    <div class="match-top hoverable pure-g" data-lineup-id="{{ $matchScore[$keys[0]]['id'] }}"
         data-id-elem="lineup-id">
        <div class="pure-u-7-8 @if($matchScore[$keys[0]]['won']) won @endif team-name">
      <span>
    <?php $profile =
        ($matchScore[$keys[0]]['id'] == 0) ? "#"
            : URL::route('team.profile', $matchScore[$keys[0]]['id']);

    ?>
          <a href="{{ $profile }}">{{ $keys[0] }}</a>
      </span>
        </div>
        <div class="pure-u-1-8">
            <div class="score-box">
                {{ $matchScore[$keys[0]]['wins'] }}
            </div>
        </div>
    </div>
    <div class="match-bottom hoverable pure-g" data-lineup-id="{{ $matchScore[$keys[1]]['id'] }}"
         data-id-elem="lineup-id">
        <div class="pure-u-7-8 @if($matchScore[$keys[1]]['won']) won @endif team-name">
      <span>
    <?php $profile =
        ($matchScore[$keys[1]]['id'] == 0) ? "#"
            : URL::route('team.profile', $matchScore[$keys[1]]['id']);

    ?>
          <a href="{{ $profile }}">{{ $keys[1] }}</a>
      </span>
        </div>
        <div class="pure-u-1-8">
            <div class="score-box">
                {{ $matchScore[$keys[1]]['wins'] }}
            </div>
        </div>
    </div>
</div>

@if (!$match->won())
    @if (Sentry::check() && $match->canReport(Sentry::getUser()))
    <a href="{{ URL::route('match.report', $match->id) }}" class="pure-button pure-button-good">
        Report Results

    </a>
    @endif
    <a href="{{ URL::route('match.profile', $match->id) }}" class="pure-button pure-button-secondary">
        View Rosters
        ({{ $match->countCompleteRosters() }})
    </a>
    @else
    <a href="{{ URL::route('match.profile', $match->id)}}" class="pure-button pure-button-primary">
        View Results
        @if ($match->is_default)
            (&#x1f44e;)
        @else
            (&#x1f44d;)
        @endif
    </a>
    <br/>
@endif


