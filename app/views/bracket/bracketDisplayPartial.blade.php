<div class="pure-g-r">
<?php $current = 0; ?>
	@foreach ($tournament->rounds as $round)
		<div class="pure-u-1-4">
			<?php $j = false; ?>
			@foreach ($round->matches as $match) 
				@for ($i = 0; $i < $current; $i++)
					<div class="match match-empty match-half"></div>
					@if ($j && $current)
						<div class="match match-empty match-half"></div>
					@endif

				@endfor

				@include('match/matchCardPartial')
				<?php $j = !$j; ?>
			@endforeach
			<?php $current++; ?>
		</div>

	@endforeach
</div>
