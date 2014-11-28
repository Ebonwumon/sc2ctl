@extends('layout')

@section('title')
Edit Profile
@stop

@section('content')
{{ Form::model($user, [ 'route' => [ 'user.update', $user->id ], 'method' => 'PUT', 'class' => "pure-form pure-form-aligned" ]) }}

    <legend>Edit Profile</legend>

    <div class="pure-control-group">
        {{ Form::label('email') }}
        {{ Form::input('email', 'email') }}
    </div>

    <div class="pure-control-group">
        {{ Form::label('username') }}
        {{ Form::text('username') }}
    </div>

    <div class="file-upload">
        <i class="fa fa-cloud-upload fa-lg"></i>
        <span class="file-upload-text">
            Change Picture
        </span>
        <span class="spinner"></span>
        <input type="file" name="img" class="upload"
             data-action-url="{{ URL::route('user.update', $user->id) }}"/>
    </div>

    <div class="pure-controls">
      {{ Form::submit('Update', [ 'class' => 'button success' ]) }}
    </div>

{{ Form::close() }}

<a href="{{ URL::route('bnet.connect') }}" class="button">Connect Battle.net Account</a>

{{ Form::close() }}
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
