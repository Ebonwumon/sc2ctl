@extends('layout')

@section('title')
Choose new Password
@stop

@section('content')
<div class="floating-color">
  {{ Form::open(array('route' => 'login.complete_reset', 'class' => 'pure-form pure-form-aligned')) }}
    {{ Form::hidden('user_id', $user_id) }}
    {{ Form::hidden('token', $token) }}
    <div class="pure-control-group">
      {{ Form::label('password', "New Password") }}
      {{ Form::password('password') }}
    </div>
    <div class="pure-controls">
      <input type="submit" class="pure-button pure-button-good" />
      <a href="{{ URL::route('user.login') }}" class="pure-button pure-button-cancel">Cancel</a>
    </div>
{{ Form::close() }}
</div>
@stop
