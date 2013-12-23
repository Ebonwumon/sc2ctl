@extends('layout')

@section('content')

<a href="{{ URL::action('UserController@auth') }}" class="pure-button pure-button-good">Login With Google</a>

@stop