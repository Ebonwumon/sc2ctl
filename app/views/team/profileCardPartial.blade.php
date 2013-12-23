<div class="pure-card tid{{ $team->id }}">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			<h2>[{{ $team->tag }}]</h2>
		</div>
		<div class="pure-u-1-6"></div>
		<div class="pure-u-1-2">
			<h4><a class="nolink" href="{{ URL::route('team.profile', $team->id) }}">{{ $team->name }}</a></h4>
			<strong>Members:</strong> {{ $team->members->count() }}
		</div>
	</div>
</div>

