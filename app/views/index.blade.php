@extends('layout')

@section('title')
Main Page
@stop

@section('background')
background-wrapper sc2ctl-main-logo
@stop

@section('content')
<div id="mainpage">
<!--<style>
		body {
			z-index: 1;
		}
		#ggmodal {
			display:none;
			width:40%;
			position:absolute;
			left: 30%;
			top:20%;
			background: lightblue;
			padding: 2em;
			opacity:1;
			z-index:900;
		}
		#close {
			float:right;
		}
		.grey {
			opacity: 0.4;
		}
	</style>
	<div id="ggmodal">
		<h2>Global Finals are coming up, and we've made a special page to enjoy them!</h2>
		<a class="pure-button pure-button-large pure-button-good" href="http://sc2ctl.com/finals">CLICK HERE</a>
		<button id="close" class="pure-button">Close</button>
	</div>
	<script>
	 $(document).ready(function() {
	 	$('.blog').addClass('grey');
		$('#ggmodal').show('slow');

		$('#close').click(function() {
			$('.blog').removeClass('grey');
			$('#ggmodal').hide('fast');
		});
	 });
	</script>-->
	<div class="pure-g">
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
				<h2 class="content-box-title mythlogic">MYTHLOGIC Computers Sponsorship</h2>
        <p>
          SC2CTL Season 2 is now proudly brought to you by 
          <span class="mythlogic">MYTHLOGIC</span> Computers!
        </p>
        <p>
          <span class="mythlogic">MYTHLOGIC</span>
          provides high-performance, custom computers tailored for the needs of 
          Gamers and Professionals alike. They have provided SC2CTL with the means to 
          operate by signing on as a title sponsor and providing all of the available prize 
          pool!
        </p>
        <p>
          If you're in the market for a computer, feel free to check out their available offerings!
        </p>
        <p>
          <a href="https://www.mythlogic.com/" class="pure-button pure-button-primary">
            Mythlogic.com
          </a>
          <a href="https://twitter.com/mythlogic" class="pure-button pure-button-twitter">
            @MYTHLOGIC
          </a>
          <a href="https://www.facebook.com/mythlogiccorp" 
             class="pure-button pure-button-facebook">
            Facebook Page
          </a>
        </p>
			</div>
		</div>
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
				<h2 class="content-box-title">Random Team</h2>
			  @include('team/profileCardPartial', array('team' => $randTeam))	
        
        <h2 class="content-box-title">Random Player</h2>
			  @include('user/profileCardPartial', array('user' => $randUser))
			</div>
		</div>
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
			  <h2 class="content-box-title">HELP</h2>
        <p>
          Welcome to Season 2 of SC2CTL. If you're confused about how some new things
          work, we've compiled a set of how-to's and tutorials to get you started.
        </p>
        <p>
          <a href="{{ URL::route('help') }}" class="pure-button pure-button-primary">
            View Help
          </a>
      </div>
		</div>
	</div>
  <br />
  <br />
  <div class="pure-u-1 main-content-box">
    <div class="floating-color stream-container">
      <br />
      <object type="application/x-shockwave-flash"
              height="432"
              width="768"
              id="live_embed_player_flash"
              data="http://www.twitch.tv/widgets/live_embed_player.swf?channel=sc2ctl"
              bgcolor="#000000">
        <param name="allowFullScreen" value="true" />
        <param name="allowScriptAccess" value="always" />
        <param name="allowNetworking" value="all" />
        <param name="movie" value="http://www.twitch.tv/widgets/live_embed_player.swf" />
        <param name="flashvars" value="hostname=www.twitch.tv&channel=sc2ctl&auto_play=true&start_volume=25" />
      </object>
      <iframe frameborder="0"
              scrolling="no"
              id="chat_embed"
              src="http://twitch.tv/chat/embed?channel=sc2ctl&amp;popout_chat=true"
              height="432"
              width="350">
       </iframe>
   </div>
  </div>

  <!-- new row -->
  <div class="pure-u-1-6"></div>
  <div class="pure-u-2-3 main-content-box">
    <div class="floating-color">
      <h2 class="content-box-title">{{ $vod->title }}</h2>
      <p>
        {{ $vod->description }}
      </p>
      {{ $vod->embed() }}
    </div>
  </div>
  
  <!-- new row -->
	<div class="pure-u-1-6"></div>
	<div class="pure-u-2-3 main-content-box">
		<div class="floating-color">
			<h2 class="content-box-title">We've got some big ideas</h2>
			<p>
					SC2CTL is ramping up for season 2 - more will be known about that in the coming months. I can't 
					do it all alone, however. If you're interested in helping out in the league or if you are a 
					<strong>sponsor or interested entity</strong> drop me an email and we can chat - I'd love to work
					with you and have you be a part of the Starcraft Community's largest Team League!
      </p>
      <a href="{{URL::route('home.contact')}}" class="pure-button pure-button-primary pure-button-large">
        Contact
      </a>
	  </div>
	</div>
	<div class="pure-u-1-6"></div>
</div>

	<br />
	<br />
	</div>
</div>
@stop
