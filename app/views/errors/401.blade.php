@extends('layout')

@section('title')
Not Authorized!
@stop

@section('content')

<div class="pure-g">
    <div class="pure-u-1-3">
        <img src="/img/naniwa-unauthorized.jpg" />
    </div>
    <div class="pure-u-2-3">
        <h1>401 - Don't try that with me</h1>
        <p>
            You're not allowed here. You're not allowed to do that. Stop that. If you're hitting
            this page in error, please <a href="{{ URL::route('home.contact') }}">contact an adult</a>.
        </p>
        <p>
            <a href="{{ URL::route('home.index') }}" class="button success">
                Take me Somewhere Safe
            </a>
        </p>
        <p>
            <a href="{{ URL::route('home.contact') }}" class="button primary-action">
                Contact an Adult
            </a>
        </p>
    </div>
</div>

@stop
