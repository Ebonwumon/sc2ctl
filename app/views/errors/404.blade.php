@extends('layout')

@section('title')
404 - Not found
@stop

@section('content')

<div class="splash">
	<div class="pure-g-r">
		<div class="pure-u-1-3">
			<div class="l-box">
				<img src="/img/sup.jpg" />
			</div>
		</div>
		<div class="pure-u-2-3">
			<h1 class="splash-head">404 - Gubbins Not Found</h1>
			<h2 class="splash-subhead">The gubbins you were looking for are either not here, or you're not
				authorized to view it. If this is in error, please contact an adult.
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
