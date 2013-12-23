@extends('layout')

@section('title')
Enter Stream Code
@stop

@section('content')
<div class="padded-content centered">
<p class="">
	Each stream, the casters of SC2CTL will give out at least two codes, which can be redeemed here. For each
	code entered, the user gains a ticket into the draw for the current prize!
</p>
<h2 class="splash-subhead">Current prize:</h2>
<p>
	A custom-written, personally addressed and handwritten <strong>Love Letter</strong> from the SC2CTL admin.
	It will be scented (actual love letter will be different than pictured
	</p>
<br />
<img src="https://lh3.googleusercontent.com/-GTL3gUjvAHU/Uh071a0U_LI/AAAAAAAACcs/RbuRAWmz2z4/w674-h899-no/IMG_20130827_175238.jpg" />
<br />
</div>
<div class="pure-g-r">
	{{ Form::open(array('route' => 'code.submit', 'class' => 'pure-form centered')) }}
		<div class="pure-u-1-6"></div>
		<div class="pure-u-2-3">
		{{ Form::text('text', null, array('class' => "pure-input-1-2 large-text centered", 'placeholder' => 'Stream Code')) }}
		</div>
		<div class="pure-u-1-6"></div>
		<br /><br />
		<div class="pure-u-1">
		<button class="expand-left pure-button pure-button-good pure-button-xlarge centered">
		<span class="spinner"></span><span class="pure-button-xlarge">Submit Code</span>
	</button> <div class="error"></div>
		</div>
	{{ Form::close() }}
</div>

<script>
	$('button').click(function(e) {
		e.preventDefault();
		var obj = this;
		$(obj).attr('data-loading', 'true');

		$.ajax({
			type: "POST",
			url: "{{ URL::route('code.submit') }}",
			dataType: "json",
			data: { text: $('input[name=text]').val() },
			success: function(data) {
				console.log(data);
				$(obj).removeAttr('data-loading');
				if (data.status) {
					dispError(obj, data.message);
					return;
				}
				$(obj).html('Code Redeemed Successfully!');
			},

			error: function(jqxhr) {
				console.log(jqxhr);
			}
		});
	});

</script>
@stop
