<?php $count = $groups->count(); 
if ($count > 4) $count = 4; 
$class= ($count > 1) ? "-".$count : "";
?>

<div class="pure-g-r">
@foreach ($groups as $group)
	<div class="pure-u-1{{$class}}">
		@include('group/tableDisplayPartial')
		<a href="{{ URL::route('group.profile', $group->id) }}" class="pure-button pure-button-primary">
			View Group
		</a>
	</div>

@endforeach
</div>
