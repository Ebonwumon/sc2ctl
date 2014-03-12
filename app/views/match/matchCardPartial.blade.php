<style>
.won { font-weight: bold; }
</style>

<div class='match' data-match-id="{{ $match->id }}">
  <div class="match-top hoverable pure-g" data-lineup-id="{{ $matchScore[$keys[0]]['id'] }}"
                                          data-id-elem="lineup-id">
    <div class="pure-u-7-8 @if($matchScore[$keys[0]]['won']) won @endif team-name">
      <span>
    <?php $profile = 
                    ($matchScore[$keys[0]]['id'] == 0) ? "#" 
                    : URL::route('team.profile', $matchScore[$keys[0]]['id'] ); 
                    
    ?>
        <a href="{{ $profile }}">{{ $match->teams->first()->qualified_name }}</a>
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
                    : URL::route('team.profile', $matchScore[$keys[1]]['id'] ); 
                    
    ?>
        <a href="{{ $profile }}">[{{ $match->teams->last()->qualified_name }}]</a>
      </span>
    </div>
    <div class="pure-u-1-8">
      <div class="score-box">
        {{ $matchScore[$keys[1]]['wins'] }}
      </div>
    </div>
  </div>
  @if (Sentry::check() && $match->canReport(Sentry::getUser()))
    @if (!$match->won())
      <a href="{{ URL::route('match.wizard', $match->id) }}" class="pure-button pure-button-good">
        Report Results
      </a>
    @else
      <a href="{{ URL::route('match.landing', $match->id)}}" class="pure-button pure-button-primary">
        View Results
      </a>
    @endif
  @endif

</div>

