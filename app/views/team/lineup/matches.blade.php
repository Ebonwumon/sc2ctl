@extends('layout')

@section('title')
Matches for {{ $lineup->qualified_name }}
@stop

@section('content')

@foreach ($matches as $matchSet)
  <h2>{{ $matchSet['tournament']->name }}</h2>
  <table class="pure-table">
    <thead>
      <tr>
        <th>Opponent</th>
        <th>Score</th>
      </tr>
    </thead>
    @foreach ($matchSet['matches'] as $match)
      <tr>
        <td>{{ $match->opponent($lineup)->qualified_name }}</td>
        <td>Some</td>
    @endforeach
    
  </table>
@endforeach

@stop
