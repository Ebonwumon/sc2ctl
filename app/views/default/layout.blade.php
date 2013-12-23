<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>@yield('title')</title>
		<link href='//fonts.googleapis.com/css?family=OFL+Sorts+Mill+Goudy+TT' rel='stylesheet' type='text/css'/>
		<link href="{{ asset(theme_path('css/style.css')) }}" rel="stylesheet" media="screen">
	</head>
	<body>
		<div class="container">
			<header>
				<h1><a href="{{ Wardrobe::route('/') }}">{{ site_title() }}</a></h1>
				<nav>
					<ul>
						<li><a href="{{ Wardrobe::route('posts.archive') }}">Posts</a></li>
						<li><a href="{{ Wardrobe::route('posts.rss') }}">RSS</a></li>
					</ul>
				</nav>
			</header>
			<div class="content">
				@yield('content')
			</div>
			<footer>
				<p>Powered by <a href="http://wardrobecms.com">Wardrobe</a></p>
			</footer>
		</div>
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
