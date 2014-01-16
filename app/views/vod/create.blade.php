@extends('layout')

@section('title')
Create Stream VOD
@stop

@section('content')
<div class="padded-content">
  <div class="pure-g">
    <div class="pure-u-1 main-content-box">
      <div class="floating-color">
        {{ Form::open(array('route' => 'vod.store', 'class' => "pure-form pure-form-aligned")) }}
          <div class="pure-control-group">  
            {{ Form::label('title') }}
            {{ Form::text('title') }}
          </div>

<div class="pure-control-group">
{{ Form::label('description') }}
{{ Form::textarea('description') }}
</div>

<p>
  For the stream ID, you want to include everything after the ?v= and up to the end of the &list= property
  if there is one. For example, in the following URL, you'd want the highlighted section: <br />
  http://www.youtube.com/watch?v=<span style="color:red">4THdxt8XERM&list=PLAWvVvFNESftqH9hKoYlBcPL2ee8tfIA_</span>&index=1
  </p>
<div class="pure-control-group">
{{ Form::label('embed_url', "Stream ID:") }}
{{ Form::text('embed_url') }}
</div>

<div class="pure-controls">
  <input type="submit" class="pure-button pure-button-good" />
</div>
{{ Form::close() }}
</div>
</div>
</div>
@stop

