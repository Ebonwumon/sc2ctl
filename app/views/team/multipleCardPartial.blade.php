<div class="pure-g-r">
@foreach ($teams as $team)
	<div class="pure-u-1-3">
		@include('team/profileCardPartial')
	</div>
@endforeach
</div>

