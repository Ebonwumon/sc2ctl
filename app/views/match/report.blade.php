@extends('layout')

@section('title')
Report Results
@stop

@section('content')
  <?php $winner = $match->won(); ?>
  <div class="splash about">
    @if ($winner)
      <h1>COMPLETE - Won by {{ Lineup::findOrFail($winner)->qualified_name }}</h1>
    @else
      {{ Form::open(array('route' => array('match.report_default', $match->id), 'class' => 'pure-form')) }}
        <label for="winner">Winning Lineup</label>
        {{ Form::select('winner', $match->teams->lists('qualified_name', 'id')) }} 
        <input type="checkbox" name="is_default" required @if ($match->is_default) checked @endif />
        Confirm Walkover
        <input type="submit" value="Declare Walkover" class="pure-button pure-button-bad" />
      {{ Form::close() }}
    @endif
  </div>
  <?php $i = 1; ?>
  @foreach ($match->games as $game)
    @if ($game->canReport(Sentry::getUser()))
        <div class="splash about" style="padding-top:0.5em;">
          {{ Form::model($game, array('route' => array('game.report', $game->id),
                              'class' => 'pure-form')) }}
            <legend>
              Game {{ $i }}
              @if ($game->winner)
                - Won by {{ $game->getWinner->qualified_name }}
              @elseif ($i == $match->bo)
                - Ace Match
              @endif
            </legend>
              {{ Form::label('winner') }}
              {{ Form::select('winner', $game->players()->lists('qualified_name', 'id')) }}
              <input type="checkbox" name="is_default" @if($game->is_default) checked @endif />
              <label for='is_default'>
                Won by forfeit?
              </label>
              @if ($game->replay_url)
                <div class="fileUpload pure-button pure-button-orange expand-left" style="top:15px;">
                  <span class="fileUpload-text">
                    <i class="fa fa-cloud-upload fa-lg"></i>
                    Change Replay?
                  </span>
                  <span class="spinner"></span>
                  <input type="file" name="replay" class="upload"
                         data-action-url="{{ URL::route('replay.upload', $game->id) }}"/>
                </div>
              @else

                <div class="fileUpload pure-button pure-button-secondary expand-left" style="top:15px;">
                  <span class="fileUpload-text">
                    <i class="fa fa-cloud-upload fa-lg"></i>
                    Upload Replay
                  </span>
                  <span class="spinner"></span>
                  <input type="file" name="replay" class="upload"
                         data-action-url="{{ URL::route('replay.upload', $game->id) }}"/>
                </div>
              @endif
              @if ($game->winner)
                <input type="submit" value="Modify Winner" class="pure-button pure-button-bad" />
              @else
                <input type="submit" value="Declare Winner" class="pure-button pure-button-good" />
              @endif

              @if ($i == $match->bo)
                <br />
                {{ Form::label('loser') }}
                {{ Form::select('loser', $game->players()->lists('qualified_name', 'id')) }}

              @endif
          {{ Form::close() }}
        </div>
      @endif
    <?php $i++; ?>
  @endforeach
  <br />
<script>
$(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_square-purple',
    radioClass: 'iradio_square-purple',
    increaseArea: '20%' // optional
  });

  $('input[type="file"]').change(function(e) {
    var obj = this;
    var button = $(obj).parents('.fileUpload');
    button.attr('data-loading', 'true');

    var form = new FormData();
    form.append("replay", this.files[0]);

    $.ajax({
      type: "POST",
      url: $(obj).data('action-url'),
      data: form,
      contentType: false,
      processData: false,
      enctype: "multipart/form-data",
      success: function(data) {
        console.log(data);
        if (data.status == 0) {
          button.removeClass('pure-button-bad').removeClass('pure-button-secondary');
          button.addClass('pure-button-orange');
          button.find('fileUpload-text').html('Change Replay?');
        } else {
          alert("ERROR! " + data.message);
          button.removeClass('pure-button-secondary').removeClass('pure-button-orange');
          button.addClass('pure-button-bad');

        }

        button.removeAttr('data-loading');
      },
      error: function(jqxhr) {
        alert("AJAX Error. Please refresh the page and try again");
        button.removeAttr('data-loading');
        button.removeClass('pure-button-secondary').removeClass('pure-button-orange');
        button.addClass('pure-button-bad');


        console.log(jqxhr); }
    });
  });

});
</script>
@stop

