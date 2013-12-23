@extends('layout')

@section('title')
STATS
@stop

@section('content')
<table class ="pure-table">
@foreach($teams as $team)
<tr>
	<td>{{ $team->name }}</td>
</tr>
@endforeach
</table>
@stop
