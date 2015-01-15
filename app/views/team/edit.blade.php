@extends('layout')

@section('title')
Edit Team - {{ $team->qualified_name }}
@stop

@section('content')

<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<script type="text/javascript">
	tinymce.init({
		plugins: "link",
		selector: "textarea",
		toolbar: "undo redo | bold italic | link",
		menubar: false,
		width: "600px",
		height:"300px"
	});
</script>

{{ Form::model($team, [ 'route' => [ 'team.update', $team->id ], 'files' => true, 'class' => 'pure-form pure-form-aligned']) }}

	<legend>Team Information</legend>

	<div class="pure-control-group">
		{{ Form::label('name') }}
		{{ Form::text('name') }}
	</div>

	<div class="pure-control-group">
		{{ Form::label('tag') }}
		{{ Form::text('tag') }}
	</div>

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

	<div class="pure-control-group">
		<textarea name="description">{{ $team->description }}</textarea>
	</div>

	<legend>Images</legend>
		<div class="pure-control-group">
			{{ Form::label('team_banner_img', "Banner (750 x 170 pixels)") }}
		<input type="file" name="team_banner_img" />
	</div>

	<div class="pure-control-group">
		{{ Form::label('team_logo_img', "Logo (150 x 150 pixels)") }}
		<input type="file" name="team_logo_img" />
	</div>

	<legend>Save and Submit</legend>

	<div class="pure-controls">
		<input type="submit" value="Save" class="button success" />
	</div>
{{ Form::close() }}
@stop
