@extends('layout')

@section('title')
Main Page
@stop

@section('background')
background-wrapper sc2ctl-main-logo
@stop

@section('content')
<div id="mainpage">
<!--<style>
		body {
			z-index: 1;
		}
		#ggmodal {
			display:none;
			width:40%;
			position:absolute;
			left: 30%;
			top:20%;
			background: lightblue;
			padding: 2em;
			opacity:1;
			z-index:900;
		}
		#close {
			float:right;
		}
		.grey {
			opacity: 0.4;
		}
	</style>
	<div id="ggmodal">
		<h2>Global Finals are coming up, and we've made a special page to enjoy them!</h2>
		<a class="pure-button pure-button-large pure-button-good" href="http://sc2ctl.com/finals">CLICK HERE</a>
		<button id="close" class="pure-button">Close</button>
	</div>
	<script>
	 $(document).ready(function() {
	 	$('.blog').addClass('grey');
		$('#ggmodal').show('slow');

		$('#close').click(function() {
			$('.blog').removeClass('grey');
			$('#ggmodal').hide('fast');
		});
	 });
	</script>-->
	<div class="pure-g">
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
				<h2 class="content-box-title">Latest Posts</h2>
			  Blog is down, friend	
			</div>
		</div>
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
				<h2 class="content-box-title">Random Team</h2>
				Placeholder
			</div>
		</div>
		<div class="pure-u-1-3 main-content-box">
			<div class="floating-color">
				<h2 class="content-box-title">Random Player</h2>
				Placeholder
			</div>
		</div>
	</div>
	<div class="pure-u-1-6"></div>
	<div class="pure-u-2-3 main-content-box">
		<div class="floating-color">
			<h2 class="content-box-title">We've got some big ideas</h2>
			<p>
					SC2CTL is ramping up for season 2 - more will be known about that in the coming months. I can't 
					do it all alone, however. If you're interested in helping out in the league or if you are a 
					<strong>sponsor or interested entity</strong> drop me an email and we can chat - I'd love to work
					with you and have you be a part of the Starcraft Community's largest Team League!
				</p>
				<a href="{{URL::route('home.contact')}}" class="pure-button pure-button-primary pure-button-large">
					Contact
				</a>
			</div>
		</div>
		<div class="pure-u-1-6"></div>
	</div>

	<br />
	<br />
	</div>
</div>
@stop
