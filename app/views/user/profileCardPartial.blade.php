<?php if (!isset($winner)) $winner = 0; ?>
<div class="pure-card uid{{ $member->id }} @if ($winner && $member->id == $winner->id) winner @endif">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			<img src="{{ $member->img_url }}" />
		</div>
		<div class="pure-u-1-6"></div>
		<div class="pure-u-1-2">
			<h3>
				<a class="nolink" href="{{ URL::route('user.profile', $member->id) }}">
					<span class="username">{{ $member->username }}</span>
				</a>
			</h3>
			@if (isset($team))
					@if ($team->leader == $member->id)
						<em class="team-captain">Team Captain</em><br />
					@elseif ($team->contact == $member->id)
						<em class="team-contact">Team Contact</em><br />
					@endif
			@endif
			{{ $member->league }}
		</div>
	</div>
</div>
<div class="pure-control-panel panel-hidden">
	@if (Entrust::can('delete_users'))
	{{ Form::open(array('route' => array('user.destroy', $member->id), 'method' => 'DELETE')) }}
		{{ Form::submit('Delete', array('class' => "pure-button pure-button-bad")) }}
	{{ Form::close() }}
	@endif

</div>

