<h3>Registered Teams</h3>
  <div class="box">
    @if ($tournament->teams->count())
      @include('team/lineup/multipleCardPartial', array('lineups' => $tournament->teams))
    @else
      <h4>No teams currently registered</h4>
    @endif
  </div>
  <br />
  @if (Sentry::check() && Sentry::hasAnyAccess(array(
                                                      'register_lineups', 
                                                      'register_team_lineups', 
                                                      'register_team_lineup')))
    <div class="pure-g-r">
      <div class="pure-u-1-2">
        <?php
          $addList = $tournament->filterEnrolledLineups(Sentry::getUser()->listAccess("Lineup"),
                                                        true);
        ?>
        @if (count($addList) > 0)
          {{ Form::open(array('route' => array('tournament.register', $tournament->id),
                              'class' => 'pure-form pure-form-aligned')) }}
            <div class="pure-control-group">
              {{ Form::label('lineup_id', "Lineup") }}
              {{ Form::select('lineup_id', $addList) }}
            </div>
            <div class="pure-controls">
              {{ Form::submit('Register', array('class' => "pure-button pure-button-good")) }}
            </div>
          {{ Form::close() }}
        @endif
      </div>
      <div class="pure-u-1-2">
        <?php
           $removeList = $tournament->filterEnrolledLineups(Sentry::getUser()->listAccess("Lineup"));
        ?>
        @if (count($removeList > 0))
          {{ Form::open(array('route' => array('tournament.leave', $tournament->id),
                              'class' => 'pure-form pure-form-aligned')) }}
            <div class="pure-control-group">
              {{ Form::label('lineup_id', "Lineup") }}
              {{ Form::select('lineup_id', $removeList) }}
            </div>
            <div class="pure-controls">
              {{ Form::submit('Leave', array('class' => 'pure-button pure-button-bad')) }}
            </div>
          {{ Form::close() }}
        @endif
      </div>
  @endif

