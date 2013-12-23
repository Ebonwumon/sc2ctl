<table class="pure-table gid{{$group->id}}">
	<thead>
		<tr>
			<th>Tag</th>
			<th>Name</th>
		</tr>
	</thead>
	@foreach ($group->teams()->get() as $team)
		<tr>
			<td>{{ $team->tag }}</td>
			<td>{{ $team->name }}</td>
		</tr>
	@endforeach
</table>

