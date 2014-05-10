@extends('layout')

@section('title')
Create Giveaway
@stop

@section('content')
<div class="splash">
    {{ Form::open(array('route' => 'giveaway.store', 'class' => 'pure-form pure-form-aligned')) }}
        <div class="pure-control-group">
        {{ Form::label('name', "Giveaway Name") }}
        {{ Form::text('name') }}
        </div>
        <div class="pure-control-group">
            {{ Form::label('description', "Giveaway Description") }}
            {{ Form::textarea('description') }}
        </div>
        <div class="pure-control-group">
            {{ Form::label('close_date') }}
            {{ Form::input('date', "close_date") }}
        </div>
        <div class="pure-controls">
            {{ Form::submit('Create Giveaway', array('class' => 'pure-button pure-button-good')) }}
        </div>
    {{ Form::close() }}
</div>
@stop
