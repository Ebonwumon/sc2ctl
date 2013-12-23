@extends('layout')

@section('title')
Format
@stop

@section('content')
<h1 class="splash-head centered">Format</h1>
<div class="padded-content">
	<div class="pure-g-r">
		<div class="pure-u-1">
			<h2 class="splash-subhead">Format Overview</h2>
			<ol class="about">
				<li>Teams are divided into groups of four, who then play round robin</li>
				<li>Matches are best-of nine allkill format</li>
				<li>During Group stages a "Revive" rule will be in effect. If 4 of your teammates die, you can revive one of them to
					try and save your team. This will not be allowed in the playoff stage</li>
				<li>Teams advance into upper and lower groups, before playing a second round robin</li>
				<li>Successful teams then advance into the playoff bracket, playing it out until a winner
					is crowned</li>
				<li><em>(Optional)</em> if there is both a Europe and NA bracket for a division, the
					winners will play a match to determine the global champion</li>
			</ol>
		</div>
		<div class="pure-u-3-4">
			<h2 class="splash-subhead">Group Stage 1</h2>
			<ul class="about">
				<li>Teams are divided into groups of four, who then play round robin matches.</li>
				<li>The winner of the group is <em>guaranteed</em> a spot in the playoff bracket</li>
				<li>The top two from each group advance into "Upper" groups in Stage 2</li>
				<li>The bottom two from each group advance into "Lower" groups in Stage 2</li>
			</ul>
		</div>
		<div class="pure-u-1-4">
			<h3>Points Awarded</h3>
		<table class="pure-table righthalf">
			<tr>
				<td>Game Win</td> <td>+2</td>
			</tr>
			<tr>
				<td>Game Loss</td> <td>-1</td>
			</tr>
			<tr>
				<td>Game Win (Upper Group)</td> <td>+4</td>
			</tr>
			<tr>
				<td>Game Loss (Upper Group)</td> <td>-2</td>
			</tr>
		</table>

		</div>
		<div class="pure-u-1-2">
			<h2 class="splash-subhead">Group Stage 2 (Upper Groups)</h2>
			<ul class="about">
				<li>Point values are all doubled</li>
				<li>The winner of each group advances to the playoff bracket in one of the "best" positions</li>
				<li>Second Place from each group advances to the playoff bracket in one of the "good" positions</li>
			</ul>
		</div>
		<div class="pure-u-1-2">
			<h2 class="splash-subhead">Group Stage 2 (Lower Groups)</h2>
			<ul class="about">
				<li>Point values remain the same</li>
				<li>Teams are competing for an "average" spot in the playoff bracket.</li>
			</ul>
		</div>
		<div class="pure-u-1">
			<h2 class="splash-subhead">Playoff Bracket</h2>
			<ul class="about">
				<li>There are three types of slots in the bracket: "Best", "Worst", "Good" and "Average". "Best" slots get a first round 
				bye, "Good" slots also get a first round bye, but will be playing against the winner of an "average" slot, 
				"Worst" slots will be competing to play against the "Best" slot in the second round (Don't worry, there's a graphic below)
				</li>
				<li>The "Best" position is always filled by whoever wins their group in group stage 2. The "Good" Position is always filled
					by whoever takes second in their group in group stage 2</li>
				<li>If a team won group stage one, but took third or fourth in group stage 2, they're guaranteed a spot. They are added into
					the list of teams qualified for the playoffs and the rest of the space is filled with remaining teams who scored
					the highest overall. The "Worst" spots go to whoever scored lowest, but still qualified for the playoffs. The remainder
					of the qualified teams are seeded randomly into the "Average" slots</li>
			</ul>
		</div>
		<div class="pure-u-1">
			<span class="splash-subhead">Example of a tournament that started with 16 teams</span>
			<div class="centered"> 
				<img src="/img/bracket.png" />
			</div>
		</div>
		<div class="pure-u-1">
			<h2 class="splash-subhead">Divisions</h2>
			<p class="about">Season 1 will function as a placement season of sorts. The divisions present here will not be the same divisions
				that exist in Season 2. The top 20 overall teams will be invited into the top division for Season 2 "SC2CTL - Invite".
				This will be the premier league, which will be eligible for any available prizing. The other divisions will be 
				"SC2CTL - Advanced" and "SC2CTL - Casual". Each season, the top 12 teams from Advanced division will be invited to play
				in Invite, the subsequent season. Only the top 16 teams in Invite will be invited to remain for the next season, the other
				teams will drop down to advanced.
			</p>
			<p class="about">
				Those wishing to join SC2CTL after Season 1 will be automatically placed based on their team's average ladder league.
				Platinum and below will be placed into casual, Diamond and above will be placed into Advanced. Should platinum and below 
				teams want to participate in Advanced instead, they are able to.
			</p>
		</div>
		
	</div>
</div>
@stop
