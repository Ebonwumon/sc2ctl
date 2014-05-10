@extends('layout')

@section('title')
Giveaways
@stop

@section('additional_head')
<script src="//connect.facebook.net/en_US/all.js" type="text/javascript"></script>
<style>
.box-item {
display: inline-block;
  border: 1px solid black;
padding: 0.5em;
}
</style>
@stop
@section('content')
<div class="splash" style="position: relative;">
    <h2 class="splash-head">SC2CTL Giveaways!</h2>
    <p class="splash-subhead">
        <span class="mythlogic">MYTHLOGIC</span> computers has sponsored SC2CTL this season
        with some fantastic prize support!
        To enter a giveaway below you'll need a couple things: a unique code, which is given away on stream
        or on Twitter and your email address. Make sure the email address is valid, as we will use that to
        contact you if you've won!
    </p>
    <p>
        Giveaways are treated as raffles. Winners are randomly selected from the available pool of entrants, 
        with an equal
        probability of any particular entry being selected. In order to increase your odds and earn multiple 
        entries, you
        can like or follow the pages below. If you have already liked or followed the pages, you've already 
        earned the bonus entries!
    </p>
    <div class="pure-form">
        <legend>Like MYTHLOGIC, Chairs4Gaming and SC2CTL on Facebook!</legend>
    </div>
    
    @if (Facebook::getUser())
    <div id="fb-root"></div>
    <div class="pure-g-r">
        <div class="pure-u-1-2">
          <div class="box-item">
            <h3 class="mythlogic">MYTHLOGIC</h3>
            <div class="fb-like" data-share="false" data-href="https://www.facebook.com/mythlogiccorp" data-send="true" data-width="450" data-show-faces="true"></div>
          </div>
        </div>
        
        <div class="pure-u-1-2">
          <div class="box-item">
            <h3>SC2CTL</h3>
            <div class="fb-like" data-share="false" data-href="https://www.facebook.com/sc2ctl" data-send="true" data-width="450" data-show-faces="true"></div>
          </div>
        </div>

        <div class="pure-u-1-2">
          <div class="box-item">
            <h3>Chairs4Gaming</h3>
            <div class="fb-like" data-share="false" data-href="https://www.facebook.com/chairs4gaming" data-send="true" data-width="450" data-show-faces="true"></div>
          </div>
        </div>
    </div>
    @else
    <a href="{{ URL::route('auth.fbLogin') }}" class="pure-button pure-button-facebook" target="_blank">
      Login with Facebook
    </a>
    @endif

    <div class="pure-form">
        <legend>Follow us on Twitter</legend>
        <a href="#" class="pure-button pure-button-twitter" target="_blank">
            Login with Twitter
        </a>
    </div>
    <div class="pure-g-r">
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
        <div class="pure-u-1-2"></div>
    </div>

    {{ Form::open(array('route' => array('giveaway.enter', $giveaway->id), 'class' => 'pure-form pure-form-aligned')) }}
        <legend>Secret Code and Email</legend>
        <div class="pure-control-group">
            {{ Form::label('email') }}
            <?php $email = (Sentry::check()) ? Sentry::getUser()->email : null; ?>
            {{ Form::text('email', $email, array('required' => "")) }}
        </div>
        <div class="pure-control-group">
            {{ Form::label('code', "Secret Code") }}
            {{ Form::text('code', null, array('required' => "")) }}
        </div>
        
        <legend>Choose your Giveaways</legend>
       <div style="border:1px solid black;padding:0.5em;">
          <label for="corsair">
              <input type="checkbox" name="accept" required />
              I would like to be entered to win one of the following:
              <ul>
                <li>Corsair Raptor HS30 Headset with MYTHLOGIC mousepad and T-Shirt. Drawing: May 20</li>
                <li>Corsair Raptor M40 Mouse with MYTHLOGIC mousepad and T-Shirt. Drawing: May 29</li>
                <li>Corsair Vengeance K65 Mechanical Keyboard with MYTHLOGIC mousepad and T-Shirt. Drawing:
                  <strong>Finals</strong>
                </li>
              </ul>
              This prize has free shipping to the continential US. Winners outside of the continental US must
              pay for shipping costs.
          </label>
      </div>

        <div class="pure-controls">
            <input type="submit" value="Enter!" class="pure-button pure-button-good" />
        </div>

    {{ Form::close() }}




</div>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=1437821873132248&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
@stop
