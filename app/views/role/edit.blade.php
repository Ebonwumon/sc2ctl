@extends('layout')

@section('content')
<h3>{{ $role->name }}</h3>
Add permissions:

{{ Form::open(array('route' => array('role.update', $role->id), 'method' => 'put')) }}

	{{ Form::select('permission', $permissions) }}
	{{ Form::submit('Add', array('class' => 'pure-button pure-button-good')) }}
{{ Form::close() }}

<br />

@include('user/selectableSearchPartial')
<button id="addSelected" class="pure-button pure-button-good">
	Add Selected
</button> 
<span class="error"></span>

<script>
	$('#addSelected').click(function() {
		var selected = $('#results').find('.selected');
		var result = gatherSelected(selected);
		$(this).attr('data-loading', "true");
		
	});

	$('#addSelected').click(function() {
		
	});
</script>
@stop
