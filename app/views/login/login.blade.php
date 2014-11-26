@extends('layout')

@section('title')
Login
@stop

@section('content')
  <strong>Important!</strong>
  <p>
    If there are problems, or you have forgotten your email that you registered with,
    send an email to adult@sc2ctl.com and we'll get you set up with the proper account.
  </p>
  {{ Form::open([ 'route' => 'user.auth', 'class' => "pure-form pure-form-aligned" ]) }}
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
      <a href="{{ URL::route('login.start_reset') }}" class="pure-button pure-button-cancel">
        Reset Password
      </a>
    </div>
  {{ Form::close() }}

  <div class="call-to-action">
    <a href="{{ URL::route('user.register') }}" class="pure-button pure-button-primary pure-button-massive">
      No account? Register here
    </a>
  </div>

@stop
