@extends('layout')

@section('title')
Edit Profile
@stop

@section('content')
{{ Form::open() }}
	<div class="hidden-file">
		<input type="file" name="img" />	
		<button class="pure-button pure-button-large pure-button-primary expand-left submit replayLink">
			<span class="spinner"></span>
			Change Photo
		</button><span class="error"></span>
	</div>
{{ Form::close() }}
<br />

{{ Form::model($user, array('route' => array('user.update', $user->id), 'method' => "PUT", 'class' => "pure-form pure-form-aligned")) }}
	<div class="pure-control-group">
		{{ Form::label('bnet_name') }}
		{{ Form::text('bnet_name') }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('char_code') }}
		{{ Form::input('number', 'char_code') }}
	</div>

	<div class="pure-control-group">
	{{ Form::label('league') }}
	{{ Form::select('league', array('Bronze' => 'Bronze', 'Silver' => 'Silver', 'Gold' => 'Gold', 
											'Platinum' => 'Platinum', 'Diamond' => 'Diamond', 'Master' => 'Master', 
											'Grandmaster' => 'Grandmaster')) }}
	</div>
	
	<div class="pure-controls">
		{{ Form::submit('Update', array('class' => "pure-button pure-button-good")) }}
	</div>
{{ Form::close() }}

<script>
$('input[name=img]').change(function() {
	$('.expand-left').attr('data-loading', "true");
	var obj = this;	
	var form = new FormData();
	form.append("image", this.files[0]);

	$.ajax({
		type: "POST",
		url: "{{ URL::route('user.changepic', $user->id) }}",
		data: form,
		contentType: false,
		processData: false,
		enctype: "multipart/form-data",
		success: function(data) {
			console.log(data);
			if (data.status) {
				dispError(obj, data.message);	
			} 
			$(obj).next().removeAttr('data-loading');
		},
		error: function(jqxhr) { 
			dispError(obj, "AJAX Error. Try again or contact an adult");
			console.log(jqxhr); }
	});
});

</script>
@stop
