@extends('layout')

@section('title')
Login
@stop

@section('content')

{{ Form::open(array('route' => 'user.auth', 'class' => "pure-form pure-form-aligned")) }}
  <div class="pure-control-group">
    {{ Form::label('email') }}
    {{ Form::text('email') }}
  </div>

  <div class="pure-control-group">
    {{ Form::label('password') }}
    {{ Form::password('password') }}
  </div>

  <div class="pure-controls">
    <input type="submit" value="Log in" class="pure-button pure-button-good" />
  </div>
{{ Form::close() }}

<div class="centered">
  <a href="{{ URL::route('user.register') }}" class="pure-button pure-button-primary pure-button-massive">
    No account? Register here
  </a>
</div>


@stop
