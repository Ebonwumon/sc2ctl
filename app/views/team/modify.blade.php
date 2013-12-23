@extends('layout')

@section('title')
Edit Team Info
@stop

@section('content')
<div class="padded-content">
	<h2>Modify Team Info</h2>
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		plugins: "link",
		selector: "textarea",
		toolbar: "undo redo | bold italic | link",
		menubar: false,
		width: "600px"
	});
</script>

{{ Form::model($team, array('route' => [ 'team.update', $team->id ], 'method' => 'POST', 'files' => true, 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
		{{ Form::label('website', "Website") }}
		{{ Form::text('website') }}
	</div>
	
	<div class="pure-control-group">
		{{ Form::label('social_twitter', "Twitter") }}
		{{ Form::text('social_twitter') }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('social_fb', "Facebook") }}
		{{ Form::text('social_fb') }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('social_twitch', "Twitch") }}
		{{ Form::text('social_twitch') }}
	</div>

	Description
	<br />
	<textarea name="description">{{ $team->description }}</textarea>
	
	<h3>Images</h3>
	<div class="pure-control-group">
		{{ Form::label('team_banner_img', "Banner (750 x 170 pixels)") }}
		<input type="file" name="team_banner_img" />
	</div>
	
	<div class="pure-control-group">
		{{ Form::label('team_logo_img', "Logo (150 x 150 pixels)") }}
		<input type="file" name="team_logo_img" />
	</div>
	
	<div class="pure-controls">
		<input type="submit" value="Save" class="pure-button pure-button-good" />
	</div>
{{ Form::close() }}
</div>
@stop
