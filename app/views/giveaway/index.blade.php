@extends('layout')

@section('title')
Giveaways
@stop

@section('additional_head')
<script src="//connect.facebook.net/en_US/all.js" type="text/javascript"></script>
@stop
@section('content')
<div class="splash" style="position: relative;">
    <h2 class="splash-head">SC2CTL Giveaways!</h2>
    <p class="splash-subhead">
        <span class="mythlogic">MYTHLOGIC</span> computers has sponsored SC2CTL this season with some fantastic prize support!
        To enter a giveaway below you'll need the unique code given away on stream or on Twitter.
    </p>
    <p>
        Giveaways are treated as raffles. Winners are randomly selected from the available pool of entrants, with an equal
        probability of any particular entry being selected. In order to increase your odds and earn multiple entries, you
        can like or follow the pages below. If you have already liked or followed the pages, you've already earned the bonus
        entries!
    </p>
    <div class="pure-form">
        <legend>Like MYTHLOGIC and SC2CTL on Facebook!</legend>
    </div>
    <div id="fb-root"></div>
    <div class="pure-g-r">
        <div class="pure-u-1-2">
            <h3 class="mythlogic">MYTHLOGIC</h3>
            <div class="fb-like" data-share="false" data-href="https://www.facebook.com/mythlogiccorp" data-send="true" data-width="450" data-show-faces="true"></div>
        </div>
        <div class="pure-u-1-2">
            <h3>SC2CTL</h3>
            <div class="fb-like" data-share="false" data-href="https://www.facebook.com/sc2ctl" data-send="true" data-width="450" data-show-faces="true"></div>
        </div>
    </div>

    <div class="pure-form">
        <legend>Follow us on Twitter</legend>
    </div>
    <div class="pure-g-r">
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
    </div>

    {{ Form::open(array('class' => 'pure-form pure-form-aligned')) }}
        <legend>Enter secret code and submit</legend>
        <div class="pure-control-group">
            {{ Form::label('email') }}
            <?php $email = (Sentry::check()) ? Sentry::getUser()->email : null; ?>
            {{ Form::text('email', $email, array('required' => "")) }}
        </div>
        <div class="pure-control-group">
            {{ Form::label('code', "Secret Code") }}
            {{ Form::text('code', null, array('required' => "")) }}
        </div>

            <label for="accept">
                <input type="checkbox" required />
                I accept the terms of the Giveaway. If I am outside of the continental US, I agree that in the event
                of winning, I will pay shipping costs for the prize.
            </label>

        <div class="pure-controls">
            <input type="submit" value="Enter!" class="pure-button pure-button-good" />
        </div>

    {{ Form::close() }}




</div>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1437821873132248',
            status     : true, // check login status
            cookie     : true, // enable cookies to allow the server to access the session
            xfbml      : true  // parse XFBML
        });

        // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
        // for any authentication related change, such as login, logout or session refresh. This means that
        // whenever someone who was previously logged out tries to log in again, the correct case below
        // will be handled.
        FB.Event.subscribe('auth.authResponseChange', function(response) {
            // Here we specify what we do with the response anytime this event occurs.
            if (response.status === 'connected') {
                // The response object is returned with a status field that lets the app know the current
                // login status of the person. In this case, we're handling the situation where they
                // have logged in to the app.
                testAPI();
            } else if (response.status === 'not_authorized') {
                // In this case, the person is logged into Facebook, but not into the app, so we call
                // FB.login() to prompt them to do so.
                // In real-life usage, you wouldn't want to immediately prompt someone to login
                // like this, for two reasons:
                // (1) JavaScript created popup windows are blocked by most browsers unless they
                // result from direct interaction from people using the app (such as a mouse click)
                // (2) it is a bad experience to be continually prompted to login upon page load.
                FB.login();
            } else {
                // In this case, the person is not logged into Facebook, so we call the login()
                // function to prompt them to do so. Note that at this stage there is no indication
                // of whether they are logged into the app. If they aren't then they'll see the Login
                // dialog right after they log in to Facebook.
                // The same caveats as above apply to the FB.login() call here.
                FB.login();
            }
        });
    };

    // Here we run a very simple test of the Graph API after login is successful.
    // This testAPI() function is only called in those cases.
    function testAPI() {
        console.log('Welcome!  Fetching your information.... ');
        FB.api('/me', function(response) {
            console.log('Good to see you, ' + response.name + '.');
        });
    }

    function liked(page) {
        FB.api({
            method: "pages.isFan",
            page_id: 393980247373524
        }, function(response) {
            console.log(response);
            if (response.data.length == 1) {
                alert ("liked page");
            } else {
                alert('no like');
            }
        });
    }
</script>


@stop