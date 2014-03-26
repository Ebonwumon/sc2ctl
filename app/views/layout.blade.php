<!DOCTYPE html>
<html>
	<head>
	  <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.3.0/pure-min.css" >
	  <link rel="stylesheet" href="/styles/style.css" >
    <link rel="stylesheet" href="/styles/purple.css" >
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" >
	  <script src="/scripts/jquery-2.0.3.min.js"></script>
    <script src="/scripts/icheck.min.js"></script>
		@yield('additional_head', "")
		<script src="/scripts/scripts.js"></script>
		<title>SC2CTL : @yield('title')</title>
	</head>
	<body>
		<div class="wrapper @yield('background', 'background-wrapper sc2ctl-main-logo')">
			<nav class="pure-menu pure-menu-open pure-menu-horizontal">
				<a href="{{ URL::action('HomeController@index') }}" class="pure-menu-heading">
					SC2CTL
				</a>
			<ul>
				<li><a href="{{ URL::action('HomeController@index') }}">Home</a></li>
				<li><a href="{{ URL::route('home.about') }}">About</a></li>
				<!--<li><a href="{{ URL::route('user.index') }}">Users</a></li>-->
				<li><a href="{{ URL::route('team.index') }}">Teams</a></li>
				<li><a href="{{ URL::route('tournament.index') }}">Tournaments</a></li>
        <li><a href="{{ URL::route('home.sponsors') }}">Sponsors</a></li>
				<li><a href="http://reddit.com/r/sc2ctl">Subreddit</a></li>
        <li><a href="http://twitch.tv/sc2ctl">Stream</a></li>
				@if (Sentry::check())
				<?php $user = Sentry::getUser(); ?>
					<li>
						<div class="notification-container">
							<a href="{{ URL::route('user.profile', $user->id) }}">
								{{ $user->username }}'s Profile
							</a>
							<?php $count = $user->notifications()->where('read', '=', 'false')->count(); ?>
							@if ($count)
							<div class="notification-bubble">
								{{$count}}
							</div>
							@endif
						</div>
					</li>
					<li><a href="{{ URL::route('user.logout') }}">Log Out</a></li>
				@else
          <li><a href="{{ URL::route('user.login', urlencode(Request::url())) }}">Sign In</a></li>
				@endif
			</ul>
		</nav>
    @include('errors/errorPartial')
		@yield('content')
		<!--<div class="push"></div>
		</div>
		<div class="footer">
			<hr />
			<a href="http://daskeyboard.com">
				<img src="/img/das-logo-small.png" />
			</a>
			  |
			<a href="{{ URL::route('home.contact') }}">Contact</a> | 
			&copy; Website by Troy Pavlek.
		</div>-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				  ga('create', 'UA-42940238-1', 'sc2ctl.com');
					  ga('send', 'pageview');

						</script>
	</body>
</html>
