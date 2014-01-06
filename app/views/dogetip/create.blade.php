@extends('layout')

@section('title')
New Tip
@stop

@section('additional_head')
<link href="/styles/select2.css" rel="stylesheet" />
<script src="/scripts/select2.min.js"></script>
@stop

@section('content')
{{ Form::open(array('route' => 'dogetip.store', 'class' => 'pure-form pure-form-aligned')) }}
  <div class="pure-control-group">
    {{ Form::label('reciever', "Reciever") }}
    {{ Form::select('reciever', $players, $default) }}
  </div>

  <div class="pure-control-group">
    {{ Form::label('tipper', "Your Name") }}
    {{ Form::text('tipper', "Anonymous") }}
  </div>

  <div class="pure-control-group">
    {{ Form::label('message') }}
    {{ Form::textarea('message', "You're grand") }} 
  </div>

  <div class="pure-control-group">
    {{ Form::label('amount', "Amount") }}
    {{ Form::input('number', 'amount', 100) }} doge
  </div>
  
  <div class="pure-controls">
    <input type="submit" value="much tip" class="pure-button pure-button-good" />
  </div>
{{ Form::close() }}

<script>
  $(document).ready(function() {
      $('select').select2({ width: "400px" });
      });
</script>
@stop
