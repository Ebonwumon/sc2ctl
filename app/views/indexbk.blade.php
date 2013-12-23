@extends('layout')

@section('title')
Main Page
@stop


@section('content')

@include('ad')
<div class="padded-content">
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

	@foreach ($blogs as $blog) 
		@include('blog/post')
	@endforeach
</div>
@stop
