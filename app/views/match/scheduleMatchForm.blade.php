	@if (Entrust::can('schedule_match') && $match->hasTeams())
		{{ Form::open(array('url' => 'http://doodle.com/polls/wizard.html', 'target' => '_blank', 'class' => 'doodleCreate')) }}
			
			{{ Form::hidden('type', "date") }}
			{{ Form::hidden('levels', 3) }}
			{{ Form::hidden('title', $title) }}
			{{ Form::hidden('name', Auth::user()->bnet_name) }}
			{{ Form::hidden('location', "SC2CTL.com") }} 
			{{ Form::hidden('eMailAddress', Auth::user()->email) }}
			{{ Form::hidden('description', "View this match at " . Request::url()) }}
			@while ($now <= $match->due)
				{{ Form::hidden($now->format('Ymd'), "8AM-12PM||12PM-4PM||4PM-8PM||8PM-12AM") }}
				<?php $now->add(new DateInterval('P1D')); ?>
			@endwhile
			{{ Form::submit('Set up Scheduling', array('class' => 'pure-button pure-button-good')) }}
		{{ Form::close() }}

		<div style="display:none;">
		{{ Form::open(array('route' => array('match.update', $match->id), 'method' => 'put', 'class' => 'pure-form')) }}
			{{ Form::text('doodle_id', null, array('placeholder' => 'Paste Doodle URL here')) }}
			{{ Form::hidden('return_url', Request::path()) }}
			{{ Form::submit('Save', array('class' => 'pure-button pure-button-good')) }}
		{{ Form::close() }}
		</div>

		<script>
			$('.doodleCreate').submit(function() {
				$(this).hide('fast');
				$(this).next().show('fast');
			});
			
		</script>
	@else
		<button class="pure-button" disabled>Set up Scheduling</button>
	@endif

