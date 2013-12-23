@if ($notifications->count())
	@foreach ($notifications as $notification)
		@include('notification/notificationPartial')
	@endforeach
@else
	No notifications
@endif
