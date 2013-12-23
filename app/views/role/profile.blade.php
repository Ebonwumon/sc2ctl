@extends('layout')

@section('content')

<h3>{{ $role->name }}</h3>

Users in Role:

@foreach ($users as $user) 
	{{ $user->username }}
	<br />
@endforeach
<br />
@foreach ($role->perms()->get() as $permission)
{{ $permission->name }}
<br />
@endforeach
<a href="{{ URL::route('role.edit', $role->id) }}" class="pure-button pure-button-secondary">
	Edit
</a>
@stop


