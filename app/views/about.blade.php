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
					The SC2CTL is designed as the premier, non-professional team league.
					From the ground up, the league was designed for maximum participation
					of those involved, while not forgetting the joy that can be found from
					being determined as the sole winner. The league spans a minimum 10 weeks
					and every team involved will play a minimum of six weeks
				</h2>
				<p>
					@if (Auth::check())
					<a href="{{ URL::route('team.create') }}" class="pure-button pure-button-primary pure-button-large">Register a Team</a>
					@else
					<a href="{{ URL::route('user.register') }}" class="pure-button pure-button-primary pure-button-large">Register Now</a>
					@endif
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
			until after the second group stage. The league focuses on your fun, and will do everything it
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
        Map pool for Season 2 is TBD currently
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
				<td>TBD</td>
			</tr>
			<tr>
				<td>2</td>
				<td>TBD</td>
			</tr>
			<tr>
				<td>3</td>
				<td>TBD</td>
			</tr>
			<tr>
				<td>4</td>
				<td>TBD</td>
			</tr>
			<tr>
				<td>5</td>
				<td>TBD</td>
			</tr>
			<tr>
				<td>6</td>
				<td>TBD</td>
			</tr>
			<tr>
				<td>7</td>
				<td>TBD</td>
			</tr>
		</table>
	</div>
</div>


<div class="splash about">	
	<div class="pure-u-1">
		<h2 style="display:inline;">Prizes</h2>
			<span class="splash-subhead">Awaiting on sponsorship</span>
		</h2>
		<br />
    <p>
      SC2CTL does its best to provide the community with the best possible prizes to award
      the considerable dedication that we see every team put in every week. This prizing
      is only made possible through the generousity of our sponsors.
    </p>
    <strong>
      Prizes for Season 2 are still TBD and should be announced before the start date
    </strong>
  </div>
</div>

<div class="splash about">
	<div class="pure-u-1">
		<h2>Features</h2>
	</div>
	<div class="pure-u-1-3">
		<h3>Replays with GGTracker</h3>
		<p class="feature">
			Reporting of every match in the league is done automatically. You upload your replay, which is then processed by
			<a href="http://ggtracker.com">GGTracker</a> to determine players and winners. All members of every team can take
			advantage of this incredible tool to drastically improve their play before the playoffs!
		</p>
	</div>
	<div class="pure-u-1-3">
		<h3>Scheduling</h3>
		<p class="feature">
			Every match contains a reference to a <a href="http://doodle.com">Doodle</a> schedule that can be filled out
			by the members of both participating teams. This makes co-ordinating matches, even across timezones a breeze.
		</p>
	</div>
	<div class="pure-u-1-3">
		<h3>Autopilot</h3>
		<p class="feature">
			The site required minimal admin intervention in the league, except to advance to playoffs, and resolve conflicts.
			That means that there's no waiting on admins to update groups and brackets, just you and your teams playing
			Starcraft II.
		</p>
	</div>
</div>

<div class="splash about">	
	<div class="pure-u-1">
		<h2>Rules</h2>
	</div>
	<div class="pure-u-1-4">
		<h3>Rosters</h3>
		<ul class="feature">
			<li>Must have a minimum of five members</li>
			<li>The highest ranked member must be less than or equal to the division a team enters, at time of registration</li>
		</ul>
		<h3>Conduct</h3>
		<ul class="feature">
			<li>No team must engage in excessive BM or personal attacks. Frustration at a loss is fine, but you must respect the
				other team, no exceptions</li>
			<li>You must respect the admins discretion on this issue. You will recieve at least one warning before being removed,
				so you will know where the line is. Please don't cross it.
			</li>
			<li>A minimum of sixty (60) percent of your team must have fun, or else you're disqualified.</li>
		</ul>
	</div>
	
	<div class="pure-u-1-4">
		<h3>Timeliness</h3>
		<p class="feature">
			Teams must have their match played by the posted due dates on the bracket. If one team no-shows, they will recieve a DQ
			for that round (and if the round is playoffs, they're eliminated). If both teams are no-shows, we will use a 
			pseudorandom number generator to determine the result of each game.
		</p>
		<p class="feature">
			No shows are defined as: Not showing up to a scheduled match or not making an effort to schedule a match.
		</p>
		<p class="feature">
			We recognize scheduling is hard. If you can't make the deadline, but have a resolution for the near future, contact
			an admin. We'll work something out, admins want to do everything they can to make sure the 60% rule is honoured.
		</p>
	</div>
	
	<div class="pure-u-1-2">
		<h3>Miscellaneous rules</h3>
		<ul>
			<li><strong><a href="https://twitter.com/wilw/status/5966220832">Wheatons Law</a> is in Full Effect</strong></li>
			<li>If players become unavailable mid-match and you run out, you lose the rest of your matches. You can reschedule
				the remainder of the matches for another time before the due date, only if the the other team agrees to it.
			</li>
			<li>The team captains are always allowed to observe games. If the team captain is playing, he may appoint an observer.
				Other players are allowed to observe, only if both teams agree to it.
			</li>
			<li>Streaming is allowed. If you are caught streamcheating or ghosting, you will be immediately removed from the league,
				and banned from participating in any subsequent seasons.
			</li>
			<li>Matches will have a starting map, and from there it will be loser-chooses from the map pool. Each map may only be played
				once.</li>
			<li>Zerg is IMBA, Hellbats are OP, Protoss EZ A-Move Race</li>
		</ul>
	</div>
</div>		
		
</div>

@stop
