<div class="pure-g-r">
@foreach ($users as $user)
	<div class="pure-u-1-3">
		@include('user/profileCardPartial')
	</div>
@endforeach
</div>


