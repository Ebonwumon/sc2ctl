
<?php $teamCount = $group->teams()->count();
	$numRounds = ($teamCount < 5) ? 4 : 5; 
	$count = 0; 
	$i =1;
	$class = "pure-u-1";
	$class .= ($numRounds > 1) ? "-".$numRounds : "";
	?>

<h3>Standings @if($group->phase == 2) @if ($group->multiplier == 2) (Upper Group) @else (Lower Group) @endif @endif</h3>
<div class="pure-g-r" data-gid={{$group->id}}>
<div class="{{ $class }}">
	<table class="pure-table">
		<thead>
			<tr>
				<th>
					#
				</th>
				<th>
					Tag
				</th>
				<th>
					Score
				</th>
			</tr>
		</thead>
		@foreach($group->standings() as $tag => $score)
		<tr>
			<td>{{$i}}</td>
			<td>{{ $tag }}</td>
			<td> {{ $score }} </td>
		</tr>
		<?php $i++; ?>
		@endforeach
	</table>
</div>
@if	($group->currentStatus()['code'] > 0) 

		@foreach ($group->matches()->get() as $match)
			@if ($count % 2 == 0 || $teamCount == 3) 
				<div class="{{ $class }}"> 
				<strong>Due:</strong> {{ $match->due->format('F j') }}
			@endif
				@include ('match/matchCardPartial')
			@if ($count % 2 == 1 || $teamCount == 3) 
				</div> 
			@endif
			<?php $count++; ?>
		@endforeach
@endif
</div>
