@extends('layout')

@section('title')
About the League
@stop

@section('content')

<div class="pure-g-r">
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

	<div class="padded-content about">
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

	<div class="pure-u-3-4">
		<h2>Maps</h2>
		<div class="l-box">
			<p>
				The map pool for the SC2CTL is quite similar to the ladder map pool. We have
				removed a couple maps that we deemed not fun or competitive. We've also added
				the maps ESV Phoenix Cluster and Gwangalli Beach. The reasoning behind this is that while we want
				people to be comfortable with the maps being played so that we get the best game
				possible, there's also fun to be had with playing new maps, and especially
				practicing one that your opponents may not be practicing to get an upper hand.
				<br />
				<br />
				Maps need not be played in this order. The number represents the "starting map" for each week. 
				eg. Week one, the bo9 starts on Akilon Wastes, Week 5 the bo9 starts on Newkirk Precinct. From
				there, it is loser choses from the remaining maps in the map pool. Maps may not be repeated in a
				bo9.
			</p>
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
				<td>Akilon Wastes</td>
			</tr>
			<tr>
				<td>2</td>
				<td>Bel'Shir Vestige</td>
			</tr>
			<tr>
				<td>3</td>
				<td>Derelict Watcher</td>
			</tr>
			<tr>
				<td>4</td>
				<td>Neo Planet S</td>
			</tr>
			<tr>
				<td>5</td>
				<td>Newkirk Redevelopment Precint</td>
			</tr>
			<tr>
				<td>6</td>
				<td>Star Station</td>
			</tr>
			<tr>
				<td>7</td>
				<td>Whirlwind</td>
			</tr>
			<tr>
				<td>8</td>
				<td>Gwangalli Beach</td>
			</tr>
			<tr>
				<td>9</td>
				<td>ESV Phoenix Cluster</td>
			</tr>
		</table>
	</div>
	<hr />
	
	<div class="pure-u-1">
		<h2 style="display:inline;">Prizes</h2>
			<span class="splash-subhead">Proudly sponsored by Das Keyboard</span>
		</h2>
		<br />
		<div class="pure-g-r">
		<div class="pure-u-1-4">
			<h3 class="splash-subhead">Masters/Grandmasters</h3>
			<p class="l-box">The winning team of the Masters/Grandmasters global finals will be awarded 
				<strong>five (5) Das Keyboards!</strong>
			</p>
		</div>
		<div class="pure-u-3-4">
			<h3 class="splash-subhead">Bronze/Silver/Gold & Platinum/Diamond</h3>
			<p>The winning team of each of the lower divisions will recieve their choice of:
			A Das Keyboard T-Shirt
			or A Das Keyboard WASD Keycap set. But that's not all! We will also be awarding an additional
			8 prizes (from our pool of 5 keycap sets and 5 t-shirts) based on each of the following
			achievements.</p>
			<div class="pure-g-r">
			<div class="pure-u-1-2">
				<p class="l-box">
				<strong>Most Improved</strong>: Three prizes, awarded to a Terran, a Zerg and a Protoss who have
					shown great improvement in Macro, Micro, and overall gameplay. We will be liberally
					using GGTracker's wonderful features to determine this
					<br/>
				<strong>Every Man on the Field</strong>: Every team who at some point in the league fields
					<em>every</em> player on their team at least once will be entered in a raffle for a prize
					<br/>
				<strong>CombatEXtreme</strong>: Awarded for best or most interesting cheese, allin or altogether
					gimmicky play.
					</p>
			</div>
			<div class="pure-u-1-2">
				<p class="l-box">
				<strong>Group Killer</strong>: Best overall record in the group stages<br/>
				<strong>Playoff MVP</strong>: MVP in the playoff stage, things like incredible play or reverse
					allkills.<br/>
				<strong>No Team-mate Left Behind (The Bellcurve Award)</strong>: Awarded to the team with the
					highest median win-rate.
				</p>
			</div>
			</div>
		</div>
		</div>
	</div>

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
	
	<hr />
	
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
