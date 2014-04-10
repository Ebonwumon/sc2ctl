@extends('layout')

@section('title')
About the League
@stop

@section('content')

<div class="pure-g-r" id="mainpage">
	<div class="splash">
		<div class="pure-u-1-3">
			<div class="l-box">
				<img src="/img/main_logo_med.jpg" />
			</div>
		</div>
		<div class="pure-u-2-3">
			<div class="l-box splash-content">
				<h1 class="splash-head">SC2CTL</h1>
				<h2 class="splash-subhead">
					The SC2CTL is designed as the premier, community-oriented team league.
					From the ground up, the league was designed for maximum participation
					of those involved, while not forgetting the joy that can be found from
					being determined as the sole winner. The league spans a minimum 10 weeks
					and every team involved will play a minimum of six weeks
				</h2>
				<p>
					@if (Sentry::check())
					<a href="{{ URL::route('team.create') }}" 
             class="pure-button pure-button-primary pure-button-large">
            Register a Team
          </a>
         	@else
					<a href="{{ URL::route('user.register') }}" class="pure-button pure-button-primary pure-button-large">Register Now</a>
					@endif
          <br />
          <a href="{{ URL::route('help') }}"
             class="pure-button pure-button-secondary pure-button-large">
            Help
          </a>

				</p>
			</div>
		</div>
	</div>
<br />
<div class="splash about">
  <div class="pure-u-3-4">
		<h2>League Format Summary</h2>
		<p class="l-box">
			The league has three phases, two group phases and a playoff bracket. In the group phases
			you fight out round robin games against your peers to vie for your place in the playoffs
			and find the rival you need to defeat on your way there.
			<br />
			The league format is designed for optimal playtime and inclusiveness of those involved.
			Every single team in the league will play a minimum of six matches, and you can't be eliminated
			until after the six-week group stage. The league focuses on your fun, and will do everything it
			can to make sure you continue having it.
		</p>
	</div>
	<div class="pure-u-1-4">
		<div class="l-box">
			<h3>Interested in the full details of the format?</h3>
			<a href="{{ URL::route('home.format') }}" class="pure-button pure-button-primary pure-button-large">
				View Format
			</a>
		</div>
	</div>
</div>
<div class="splash about">
	<div class="pure-u-3-4">
		<h2>Maps</h2>
		<div class="l-box">
			<p>
        The SC2CTL map pool is designed to be reminicent of the current ladder map
        pool, with key variations that allow for exciting play. We tend to use the
        best core maps from the map pool, and add a couple additional maps from the
        community to round out our pool of seven. This setup allows us to get the
        best play possible through showing the maps that people are comfortable with
        while adding an extra competitive element: if one practices the unique maps
        and their opponent does not, one might get the upper hand!
      </p>
      
      <strong>
        Map pool reorders each week and will be updated here. 
      </strong>
		</div>
	</div>
	<div class="pure-u-1-4">
		<table class="pure-table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
				</tr>
			</thead>
			<tr>
				<td>1</td>
				<td>Habitation Station LE</td>
			</tr>
			<tr>
				<td>2</td>
				<td>King Sejong Station LE</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Merry Go Round LE</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Overgrowth LE</td>
			</tr>
			<tr>
				<td>5</td>
				<td>Waystation LE</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Galaxy - Veridian</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Galaxy - Bloodmist Refuge</td>
			</tr>
		</table>
	</div>
</div>


<div class="splash about">	
	<div class="pure-u-1">
		<h2 style="display:inline;">Prizes</h2>
	  <span class="splash-subhead">provided by MYTHLOGIC.COM</span>
		<br />
    <p>
      SC2CTL does its best to provide the community with the best possible prizes to award
      the considerable dedication that we see every team put in every week. This prizing
      is only made possible through the generousity of our sponsors. This season, MYTHLOGIC computers has
      signed on to afford every Starcraft II Community team the opportunity to play in a competitive environment.
    </p>
    <strong>SC2CTL Competitive</strong>
    $400/$200/$100 (for first, second and third respectively)
    <br />
    <strong>SC2CTL Advanced</strong>
    $50/$20 (for first and second respectively)
    <br />
    <strong>SC2CTL Casual</strong>
    $20 (for first place)
    <br />
    <br />
    <strong>Other prizes will be made available at a later date for all participants!</strong>
  </div>
</div>

<div class="splash about">
	<div class="pure-u-1">
		<h2>Features</h2>
	</div>
	<div class="pure-u-1-3">
		<h3>Replays with GGTracker</h3>
		<p class="feature">
	    All replays for matches are uploaded to <a href="http://ggtracker.com">GGTracker</a>
      which allows for every team to easily track their progress and make improvements
      to their game throughout the season. It also allows us to perform interesting statistics
      like programmatically determining improvement.
    </p>
	</div>
	<div class="pure-u-1-3">
		<h3>Format</h3>
		<p class="feature">
      Every part of the format, from proleague matches to Swiss Rounds, is designed to
      allow for every member of each team to participate in the maximum number of games
      possible throughout the league before being eliminated.
    </p>
	</div>
	<div class="pure-u-1-3">
		<h3>Autopilot</h3>
		<p class="feature">
			The site required minimal admin intervention in the league, except to advance to 
      playoffs, and resolve conflicts. That means that there's no waiting on admins to 
      update results and brackets, just you and your teams playing Starcraft II.
		</p>
	</div>
</div>

  <div class="splash about">	
    <div class="pure-u-1">
      <h2>Rules</h2>
    </div>
    <div class="pure-u-2-3">
      <p>
        SC2CTL is a fun league, which is run mostly on the principle of <a href="https://twitter.com/wilw/status/5966220832">Wheaton's Law</a>.
        In general if you have a rules question, a good way to figure out the answer is to ask yourself: "is what I'm about to do promoting
        the spirit of having a fun and enjoyable experience for all". If yes, you're likely good. But you should still probably read the full
        rules anyway. Just to be sure. And cultural differences. And stuff.
      </p>
    </div>
    <div class="pure-u-1-3">
      For more information read the:<br />
      <a href="{{ URL::route('home.rules') }}" class="pure-button pure-button-primary pure-button-large">
        Full Rules
      </a>
    </div>
  </div>		
		
</div>

@stop
