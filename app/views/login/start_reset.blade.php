@extends('layout')

@section('title')

@stop

@section('content')
<div class="floating-color">  
  {{ Form::open(array('route' => 'login.send_token', 'class' => 'pure-form pure-form-aligned')) }}
    <div class="pure-control-group">
      {{ Form::label('email') }}
      {{ Form::text('email') }}
    </div>
    <div class="pure-controls">
      <input type="submit" class="pure-button pure-button-good" value="Reset" />
      <a href="{{ URL::route('user.login') }}" class="pure-button pure-button-cancel">Cancel</a>
    </div>
  {{ Form::close() }}
</div>
@stop
