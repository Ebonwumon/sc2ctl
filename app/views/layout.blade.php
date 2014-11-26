<!DOCTYPE html>
<html>
	<head>
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" >
	    <script src="/scripts/jquery-2.0.3.min.js"></script>
        <script src="/scripts/icheck.min.js"></script>
		@yield('additional_head', "")
		<title>@yield('title') - SC2CTL</title>
	</head>
	<body>
	<header class="navigation">
	    <nav>
	        <ul>
	            <li>
	                <a href="{{ URL::route('home.index') }}">Home</a>
                </li>
                <li>
                    <a href="{{ URL::route('home.about') }}">About</a>
                </li>
                <li>
                    <a href="{{ URL::route('team.index') }}">Teams</a>
                </li>
                <li>
                    <a href="{{ URL::route('tournament.index') }}">Tournaments</a>
                </li>
                <li>
                    <a href="{{ URL::route('home.sponsors') }}">Sponsors</a>
                </li>
                <li>
                    <a href="http://reddit.com/r/sc2ctl">Subreddit</a>
                </li>
                <li>
                    <a href="http://twitch.tv/sc2ctl">Stream</a>
                </li>
                @if (Auth::check())
                    <li>
                        <a href="{{ URL::route('user.show', Auth::user()->id) }}">
                            {{ Auth::user()->username }}'s Profile
                        </a>
                    </li>
                    <li>
                        {{ Form::open([ 'route' => 'user.logout', 'method' => 'POST', 'class' => '' ]) }}
                            <input type="submit" value="Log Out" />
                        {{ Form::close() }}
                    </li>
                @else
                    <li>
                        <a href="{{ URL::route('user.login') }}">Sign In</a>
                    </li>
                @endif
	        </ul>
	    </nav>
	</header>
    @include('errors/errorPartial')
    @yield('content')
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
