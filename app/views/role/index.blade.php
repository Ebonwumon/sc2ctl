@extends('layout')

@section('content')

@foreach ($roles as $role)

<a href="{{ URL::route('role.profile', $role->id) }}">{{ $role->name }}</a>
<br />
@endforeach

<a href="{{ URL::route('role.create') }}" class="pure-button pure-button-good">Create New</a>
@stop
