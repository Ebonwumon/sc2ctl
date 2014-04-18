@extends('layout')

@section('title')
Edit Profile
@stop

@section('content')
<div class="splash">
  {{ Form::model($user, array('route' => array('user.update', $user->id), 'class' => "pure-form pure-form-aligned")) }}
    <legend>Edit Profile</legend>
    <div class="pure-control-group">
      {{ Form::label('email') }}
      {{ Form::input('email', 'email') }} 
    </div>
    <div class="pure-control-group">
      {{ Form::label('bnet_name') }}
      {{ Form::text('bnet_name') }}
    </div>

    <div class="pure-control-group">
      {{ Form::label('bnet_url') }}
      {{ Form::text('bnet_url') }}
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

    <div class="fileUpload pure-button pure-button-secondary expand-left">
      <i class="fa fa-cloud-upload fa-lg"></i>
      <span class="fileUpload-text">
        Change Picture 
      </span>
      <span class="spinner"></span>
      <input type="file" name="img" class="upload" 
             data-action-url="{{ URL::route('user.update', $user->id) }}"/>
    </div>
    
    <div class="pure-controls">
      {{ Form::submit('Update', array('class' => "pure-button pure-button-good")) }}
    </div>
  {{ Form::close() }}
</div>
<script>
$('input[name=img]').change(function() {
  var obj = this;	
  var button = $(obj).parents('.fileUpload');
  var form = new FormData();
  button.attr('data-loading', "true");
	
  form.append("image", this.files[0]);

	$.ajax({
		type: "POST",
		url: $(obj).data('action-url'),
		data: form,
		contentType: false,
		processData: false,
		enctype: "multipart/form-data",
		success: function(data) {
			console.log(data);
      button.removeClass('pure-button-secondary').removeClass('pure-button-bad').removeClass('pure-button-good');
			if (data.status) {
				alert(data.message);
        button.addClass('pure-button-bad');
			} else {
        button.addClass('pure-button-good');
        button.find('.fileUpload-text').html("Completed");
      }
			button.removeAttr('data-loading');
		},
		error: function(jqxhr) { 
			alert("AJAX Error. Try again or contact an adult");
			console.log(jqxhr); }
	});
});

</script>
@stop
