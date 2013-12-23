@extends('layout')

@section('title')
Manage Team
@stop

@section('additional_head')

@stop

@section('content')
<div class="padded-content">
<h2>{{ $team->name }}</h2>	
	<div id="members" class="selectable">
	<?php $members = $team->members; ?>
	@include('user/multipleCardPartial')

	</div>
@if (Auth::user()->canManageTeam($team->id)) 
<div class="pure-control-panel">
<button class="pure-button pure-button-secondary selectOne expand-left" data-dest="{{ URL::route('team.addleader', $team->id) }}" data-class="team-captain">
	Promote to Captain <span class="spinner"></span>
</button>
<button class="pure-button pure-button-secondary selectOne expand-left" data-dest="{{ URL::route('team.addcontact', $team->id) }}" data-class="team-contact">
	Make Team Contact <span class="spinner"></span>
</button>
<button class="pure-button pure-button-bad selectOne expand-left" data-dest="{{ URL::route('team.evict') }}">
	<span class="spinner"></span>Remove from Team
</button>
{{ Form::open(array('url' => 'user/leaveteam')) }}

	{{ Form::submit('Leave Team', array('id' => 'leaveTeam', 'class' => 'pure-button pure-button-bad')) }}

{{ Form::close() }}

<span class="error"></span>
</div>
@endif

<h3>Roster</h3>
<p>
	This search will only return users who are not already on a team. Make sure the member you want
	leaves his team first. It also only searches users registered with SC2CTL. Make sure your team signs up!
</p>


@include('user/selectableSearchPartial', array('searchParams' => "hasTeam-false"))

<button class='selectMany pure-button pure-button-good expand-left'>
	<span class="spinner"></span>Add Selected
</button>
<br />
<br />
@if (Entrust::can("delete_teams"))
{{ Form::open(array('route' => array('team.destroy', $team->id), 'method' => 'delete')) }}

{{ Form::submit('Delete Team', array('class' => 'pure-button pure-button-bad')) }}

{{ Form::close() }}
@endif
</div>
<script>
	function selectOneAction(selected, obj) {
		var id = gatherSelected(selected)[0];
		$.ajax({
			url: $(obj).data('dest'),
			type: "PUT",
			dataType: "html",
			data: { id: id },
			success: function(data) {
				selected.hide('fast').remove();
				$('#members').find('.'+ $(obj).data('class')).hide('fast').remove();
				$(data).appendTo($('#members'));
				$('.selectOne').removeAttr('data-loading');
			},
			error: function(jqxhr, statustext, errorThrown) {
				console.log(errorThrown);
			}
		});
	}
	
	function selectManyAction(selected, obj) {
		$(obj).attr('data-loading', "true");
		var result = gatherSelected(selected);
		$.ajax({
			type:"POST",
			url: "/team/" + {{ $team->id }} + "/addmembers",
			dataType:"json",
			data: { ids: result },
			success: function(data) {
				moveCards(selected);
				$(obj).removeAttr('data-loading');
			}
		});
	}

	function moveCards(selected) {
		selected.each(function(i) {
			$(selected[i]).hide('fast', function() { $(this).appendTo('#members').show('fast'); });
		});
	}

</script>
@stop
