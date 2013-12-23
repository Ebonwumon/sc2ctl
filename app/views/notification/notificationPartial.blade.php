<div class="notification @if ($notification->pivot->read) read @else unread @endif" data-nid="{{$notification->id}}">
	{{ $notification->text }}
	<a href="{{ $notification->action_url }}" class="pure-button pure-button-gplus">
		View
	</a>
</div>


