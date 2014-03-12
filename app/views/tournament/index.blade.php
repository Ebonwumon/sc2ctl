@extends('layout')

@section('title')
Tournaments
@stop

@section('content')
@foreach ($tournaments as $season)
  <div class="splash about">
    <h3>{{ $season[0]->season->name }}</h3>
    <div class="box">
      @foreach ($season as $tournament)

        {{ $tournament->name }} 

        <a href="{{URL::route('tournament.profile', $tournament->id)}}" 
           class="pure-button pure-button-primary">
          View Tournament
        </a>
        <br />
        <br />
      @endforeach
    </div>
  </div>
@endforeach
@stop
