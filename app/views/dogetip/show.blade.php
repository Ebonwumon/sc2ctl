@extends('layout')

@section('background')
background-wrapper doge-background
@stop

@section('title')
View Dogetip
@stop

@section('content')
<div id="mainpage">
  <div class="splash">
    <div class="centered">
      @if (!$dogetip->confirmed)
        <h1 class="splash-head">Send {{ $dogetip->amount }} doge to: {{ $dogetip->address }}</h1>
        <h2 class="splash-subhead" style="color:rgb(181, 91, 2);">
          Note: it may take up to 15 minutes to confirm the dogetip
        </h2>
      @else
        <h1 class="pure-button-good">Tip Confirmed: {{ $dogetip->amount }} doge</h1>
      @endif
    </div>
  </div>
  <div class="pure-g">
    <div class="pure-u-1-3">
      <div class="main-content-box floating-color">
        <h2 class="content-box-title">Message</h2>
        <p>{{ $dogetip->message }}</p>
      </div>
    </div>
    <div class="pure-u-1-3">
      <div class="main-content-box floating-color">
        <h2 class="content-box-title">Sent By</h2>
        <p>{{ $dogetip->tipper }}</p>
      </div>
    </div>
   <div class="pure-u-1-3">
      <div class="main-content-box floating-color">
        <h2 class="content-box-title">Receiver</h2>
        <p>{{ $dogetip->receiver->bnet_name }}#{{ $dogetip->receiver->char_code }}</p>
      </div>
    </div>

</div>
@stop

