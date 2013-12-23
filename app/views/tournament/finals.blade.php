@extends('layout')

@section('title')
GLOBAL FINALS
@stop

@section('content')
<div class="splash">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			<div class="l-box">
				<img src="/img/season_1_cup.png" />
			</div>
		</div>
		<div class="pure-u-2-3">
			<h1 class="splash-head">Season 1, Global Finals</h1>
			<h2 class="splash-subhead">
				The season one global finals are here, beginning at <strong>2PM EDT, Sunday, Sept 29</strong>!
				<br />
				<br />
				The winner of this best-of nine match will walk home with <strong>5 Das Keyboards</strong> for their team
				as well as taking home the SC2CTL Trophy!
				<br />
				<br />
				The global finals will take place between ESC Icy Box (Europe) and Team Gravity (North America)
			</h2>
<object  type="application/x-shockwave-flash" height="378" width="620" id="live_embed_player_flash" data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=sc2ctl" bgcolor="#000000"><param name="allowFullScreen" value="true" /><param name="allowScriptAccess" value="always" /><param name="allowNetworking" value="all" /><param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" /><param name="flashvars" value="hostname=www.twitch.tv&channel=sc2ctl&auto_play=true&start_volume=25" /></object>
			<div class="pure-control-panel">
				<strong>SC2CTL</strong> &nbsp;
				<a href="http://reddit.com/r/sc2ctl" class="pure-button pure-button-primary pure-button-large">
					Reddit
				</a>
				<a href="https://www.facebook.com/SC2CTL" class="pure-button pure-button-facebook pure-button-large">
					Facebook
				</a>
				<a href="https://plus.google.com/101699772085740069639/posts" class="pure-button pure-button-gplus pure-button-large">
					Google+
				</a>
				<a href="http://twitter.com/sc2ctl" class="pure-button pure-button-twitter pure-button-large">
					Twitter
				</a>
			</div>

			<div class="pure-control-panel">
				<strong>TEAM GRAVITY</strong> &nbsp;
				<a href="https://www.facebook.com/TeamGravityOfficial" class="pure-button pure-button-facebook pure-button-large">
					Facebook
				</a>
				<a href="https://twitter.com/TeamGravitySC2" class="pure-button pure-button-twitter pure-button-large">
					Twitter
				</a>
			</div>

			<div class="pure-control-panel">
				<strong>ESC ICY BOX</strong> &nbsp;
				<a href="http://www.facebook.com/escgaming" class="pure-button pure-button-facebook pure-button-large">
					Facebook
				</a>
				<a href="https://twitter.com/ESCGaming/" class="pure-button pure-button-twitter pure-button-large">
					Twitter
				</a>
			</div>
		</div>
	</div>
</div>
@stop
