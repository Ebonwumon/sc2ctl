@extends('layout')

@section('content')
<div class="padded-content">
	<div class="pure-g-r">
		@foreach ($groups as $group) 
			<div class="pure-u-1-4">
				{{ $group->currentStatus()['status'] }}

				@include('group/tableDisplayPartial')

				{{ Form::open(array('route' => array('group.generate', $group->id))) }} 
					{{ Form::submit('Generate Match', array('class' => "pure-button pure-button-good")) }}
				{{ Form::close() }}
			</div>
		@endforeach
	</div>
</div>
@stop
