<div class="pure-g-r">
@foreach ($lineups as $lineup)
	<div class="pure-u-1-3">
		@include('team/lineup/profileCardPartial')
	</div>
@endforeach
</div>

