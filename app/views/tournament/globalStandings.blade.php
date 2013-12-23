<table class="pure-table pure-table-horizontal">
	<tr>
		<th>Tag</th>
@foreach($globalStandings as $tag => $score)
	<td>{{ $tag }}</td>
@endforeach
	</tr>
	<tr>
		<th>Score</th>
@foreach ($globalStandings as $tag => $score)
	<td>{{ $score }}</td>
@endforeach
</table>
