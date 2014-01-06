@extends('layout')

@section('background')
background-wrapper sc2ctl-main-logo
@stop

@section('title')
Stream
@stop

@section('content')
<?php $i = 0; ?>
<h1 class="centered">
  @foreach($match->teams as $team)
    {{ $team->name }}
    @if (!$i)
      vs. 
    @endif
    <?php $i++; ?>
  @endforeach
</h1>

<div id="stream-container" class="floating-color">
  <object type="application/x-shockwave-flash" 
          height="432"
          width="768" 
          id="live_embed_player_flash" 
          data="http://www.twitch.tv/widgets/live_embed_player.swf?channel={{ $channel }}" 
          bgcolor="#000000">
    <param name="allowFullScreen" value="true" />
    <param name="allowScriptAccess" value="always" />
    <param name="allowNetworking" value="all" />
    <param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" />
    <param name="flashvars" value="hostname=www.twitch.tv&channel={{ $channel }}&auto_play=true&start_volume=25" />
  </object>
  <iframe frameborder="0" 
          scrolling="no" 
          id="chat_embed" 
          src="http://twitch.tv/chat/embed?channel={{ $channel }}&amp;popout_chat=true" 
          height="432" 
          width="350">
  </iframe>
  <br />
    <div class="pure-g">
      <div class="pure-u-2-3">
        <div class="pure-g">
          <div class="pure-u-1-2">
            <h2>{{ $match->teams->first()->name }}</h2>
          </div>
          <div class="pure-u-1-2">
            <h2>{{ $match->teams->last()->name }}</h2>
          </div>
          <?php $first = true; ?> 
          @foreach($players as $row) 
            @foreach ($row as $arr)
              @foreach ($arr as $player)
                <div class="pure-u-1-2">
                  @if(!$first)
                    @include('user/profileCardPartial', array('user' => $player, 'dispTip' => true, 'smallCard' => true))
                  @else
                    @include('user/profileCardPartial', array('user' => $player, 'dispTip' => true))
                  @endif
                </div>
              @endforeach
              <?php $first = false; ?>
            @endforeach
          @endforeach
        </div>
      </div>
      <div class="pure-u-1-3">
        <h2>Staff</h2>
        <h4>Casters</h4>
        @include('user/profileCardPartial', array('user' => User::find(854), 'dispTip' => true))
        @include('user/profileCardPartial', array('user' => User::find(854), 'dispTip' => true))
        <h4>Tournament Organizer/Programmer</h4>
        @include('user/profileCardPartial', array('user' => User::find(14), 'dispTip' => true))
        <h4>Future Events</h4>
        <br />
        <br />
{{ Form::open(array('url' => 'https://www.dogeapi.com/checkout', 'method' => 'GET', 'target' => '_blank')) }}
  {{ Form::hidden('widget_type', 'donate') }}
  {{ Form::hidden('widget_key', Config::get('app.doge_widget_key')) }}
  {{ Form::hidden('payment_address', Config::get('app.future_event_donation')) }}
  <input type="submit" value="Contribute" class="pure-button-xlarge pure-button tip-button" />
{{ Form::close() }}
    </div>
  </div>
</div>

<br />
<br />
<div class="centered">
  <a target="_blank" href="{{ URL::route('dogetip.list') }}" class="pure-button tip-button pure-button-massive">
    View All Submitted Tips
  </a>
</div>
@stop
