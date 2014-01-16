@extends('layout')

@section('title')
All Dogetips
@stop

@section('content')

<table class="pure-table">
  <thead>
    <tr>
      <th>#</th>
      <th>Receipient</th>
      <th>From</th>
      <th>Amount</th>
      <th>Message</th>
      <th>Actions</th>
  </thead>
  @foreach($dogetips as $dogetip)
    <tr>
      <td>{{ $dogetip-> id }}</td>
      <td>{{ $dogetip->receiver->bnet_name }}#{{ $dogetip->receiver->char_code }}</td>
      <td>{{ $dogetip->tipper }}</td>
      <td>{{ $dogetip->amount }}</td>
      <td>{{ $dogetip->message }}</td>
      <td>
        <a href="{{ URL::route('dogetip.show', $dogetip->id) }}" class="pure-button pure-button-primary">
          Details
        </a>
      </td>
    </tr>
  @endforeach
</table>
if you haven't yet paid your doge, your transaction is unconfirmed. View it and pay below
<a href="{{ URL::route('dogetip.list', 'unconfirmed') }}" class="pure-button pure-button-secondary">
  Show Unconfirmed Transactions
</a>
@stop
