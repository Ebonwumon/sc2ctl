@extends('layout')

@section('additional_head')
<link href="/styles/select2.css" rel="stylesheet"/>
<script src="/scripts/select2.min.js"></script>
@stop

@section('title')
Create Lineup 
@stop

@section('content')
<h2>Create Roster for {{ $team->name }}</h2>
{{ Form::open(array('route' => array('lineup.store', $team->id), 'method' => "POST", 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
		{{ Form::label('name') }}
		{{ Form::text('name') }}
	</div>
	<div class="pure-control-group">
		{{ Form::label('users[]', "Players to Add") }}
		{{ Form::select('users[]', $select, null, array('multiple')) }}
	</div>
	
	<div class="pure-controls">
		<input type="submit" class="pure-button pure-button-good" value="Create" />
	</div>
{{ Form::close() }}

<script>
$(document).ready(function() {
	$('select[name="users[]"]').select2({
		width: "400px"
		}
	);
});
</script>

@stop


