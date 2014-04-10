@extends('layout')

@section('title')
Not Authorized!
@stop

@section('content')

<div class="splash">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			<div class="l-box">
				<img src="/img/naniwa-unauthorized.jpg" />
			</div>
		</div>
		<div class="pure-u-2-3">
			<h1 class="splash-head">401 - Don't try that with me</h1>
			<h2 class="splash-subhead">
        You're not allowed here. You're not allowed to do that. Stop that. If you're hitting
        this page in error, please <a href="{{ URL::route('home.contact') }}">contact an adult</a>.
      </h2>
			<p>
				<a href="{{ URL::route('home') }}" class="pure-button pure-button-good pure-button-large">
					Take me Somewhere Safe
				</a>
			</p>
			<p>
				<a href="{{ URL::route('home.contact') }}" class="pure-button pure-button-primary pure-button-large">
					Contact an Adult
				</a>
			</p>
		</div>
	</div>
</div>

@stop
