@extends('layout')

@section('title')
Create Bracket
@stop
<?php $default_size = 8; ?>

@section('content')
<h2>Create Bracket</h2>
@if (isset($error))
	<span class="error" style="display:inline">{{ $error }}</span>
@endif
{{ Form::open(array('route' => 'bracket.store', 'class' => 'pure-form pure-form-aligned')) }}
	<div class="pure-control-group">
		{{ Form::label('size', 'Tournament Size') }}
		{{ Form::input('number', 'size', $default_size) }}
	</div>
	<div class="pure-control-group">
		{{ Form::label('tournament_id', 'Attach To Tournament') }}
		{{ Form::select('tournament_id', $tournaments) }}
	</div>
	
	<hr />
	Types are: 0) no match
	<div id="form-positions" data-size="{{ $default_size }}">
		@for($i = 1; $i <= $default_size; $i++)
			<div data-form_position="{{$i}}">
				<div class="pure-control-group">
					{{ Form::label('position[]', 'Position ' . $i) }}
					{{ Form::input('number', 'position[]') }}
					<span style="display:none"></span>
				</div>
			</div>
		@endfor
	</div>

	<div class="pure-controls">
		{{ Form::submit('Create Bracket', array('class' => 'pure-button pure-button-good')) }}
	</div>

{{ Form::close() }}

<script>
	$('input[name="position[]"]').change(function() {
		var obj = this;
		$.ajax({
			type: "GET",
			url: "/team/" + $(this).val(),
			dataType: "json",
			success: function(data) {
				$(obj).next().html(data.name).show('fast');
			},
			error: function(data) {
				console.log(data);
			}
		});
	});
	$('input[name=size]').change(function() {
		var size = $(this).val();
		if ($('#form-positions').data('size') > size) {
			var list = $('#form-positions').children().toArray().reverse();
			for (var i in list) {
				if ($(list[i]).data('form_position') > size) {
					$(list[i]).hide('fast', function() { 
						$(this).remove(); 
					});
				} else {
					break;
				}
			}
		} else if ($('#form-positions').data('size') < size) {
			drawFormOptions(size);
		}

		$('#form-positions').data('size', size);
	
	 	console.log($('#form-positions').data('size'));	
		return;
	});

	function drawFormOptions(size) {
		var start = $('#form-positions').children().last().data('form_position');	
			for (var i = start + 1; i <= size; i++) {
				var str = '<div data-form_position="' + i + '">' +
						  	'<div class="pure-control-group">' +
								'<label for="position">Position ' + i + '</label>' +
								'<input name="position" type="number" id="position" />' +
								'<label for="position_type">Type:</label>' +
								'<input name="position_type" type="number" />' +
								'<span style="display:none"></span>' +
							'</div>' +
						'</div>';
				$('#form-positions').append(str);
			}
	}

</script>
@stop
