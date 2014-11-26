<table class="pure-table team-roster pure-table-horizontal" data-lineup-id="{{ $lineup->id }}">
	<thead>
		<tr>
			<th colspan="3">
        @if($edit)
          @if ($lineup->canRename(Sentry::getUser()))
            {{ Form::open(array('route' => array('lineup.update', $lineup->id), 'class' => 'inline-form')) }}
              <input type="text" name="name" 
                     value="{{ $lineup->name }}" />
              <input type="submit" class="pure-button pure-button-small pure-button-good" value="Change" />
            {{ Form::close() }}
          @else
            {{ $lineup->name }}
          @endif
          @if ($lineup->canRemoveMembers(Sentry::getUser()))
            {{ Form::open(array('route' => array('lineup.delete', $lineup->id), 
                                'method' => "delete", 
                                'class' => "inline-form")) }}
              <input type="submit" class="pure-button pure-button-small pure-button-bad" value="Delete" />
            {{ Form::close() }}
          @endif
        @else
          {{ $lineup->name }}
        @endif
      </th>
		</tr>
	</thead>
	<?php $i = 1; ?>
	@foreach ($lineup->players as $player)
		<tr>
			<td>{{ $i }}</td>
			<td>
				<a href="{{ URL::route('user.show', $player->id) }}">
					{{ $player->bnet_name }}#{{ $player->char_code }}
				</a>
			</td>
			<td>
				@if ($edit)
          @if($lineup->canChangeRanks(Sentry::getUser()))
            <button data-role-id="{{ Role::CAPTAIN }}" data-user-id="{{ $player->id }}" 
                data-remote-url="{{ URL::route('lineup.change_rank', $lineup->id) }}"
                class="remoteAction pure-button pure-button-small @if($player->pivot->role_id == Role::CAPTAIN) selected @endif">
              C
            </button>
            <button data-role-id="{{ Role::OFFICER }}" data-user-id="{{ $player->id }}" 
                data-remote-url="{{ URL::route('lineup.change_rank', $lineup->id) }}"
                class="remoteAction pure-button pure-button-small @if($player->pivot->role_id == Role::OFFICER) selected @endif">
              O
            </button>
            <button data-role-id="{{ Role::MEMBER }}" data-user-id="{{ $player->id }}" 
                data-remote-url="{{ URL::route('lineup.change_rank', $lineup->id) }}"
                class="remoteAction pure-button pure-button-small @if($player->pivot->role_id == Role::MEMBER) selected @endif">
              M
            </button>
          @endif
          @if ($lineup->canRemoveMembers(Sentry::getUser()))
            <button data-user-id="{{ $player->id }}"
                data-remote-url="{{ URL::route('lineup.remove_user', $lineup->id) }}"
                class = "remoteAction delete pure-button-bad pure-button-small pure-button">
              X
            </button>
          @endif
				@else
					{{ Role::find($player->pivot->role_id) }}
				@endif
				
			</td>
		</tr>
		<?php $i++; ?>
	@endforeach
	@if ($edit)
	<tr>
		<td colspan="3">
		{{ Form::open(array(
          'route' => array('lineup.add_user', $lineup->id),
          'class' => 'pure-form pure-form-aligned')) }}
			<span class="plus">+</span>
			<select name="user_id">
				<option selected disabled>Choose Player</option>
				@foreach($select as $id => $user)
					@if (!$lineup->players->contains($id))
						<option value="{{ $id }}">{{ $user }}</option>
					@endif
				@endforeach
			</select>
      <input type="submit" class="pure-button pure-button-primary" value="Add" />
		{{ Form::close() }}
		</td>
	</tr>
	@endif
</table>
<br />

@if($edit)
<script>
$(document).ready(function() {
	$('select[name="user_id"]').select2({
		width: "300px",
		placeholder: "Choose Player"	
	});
  $('input[name=lineup_name]').unbind('change');
  $('input[name=lineup_name]').change(function() {
    $.ajax({
      url: $(obj).data('action-url'),
      type: "POST",
      data: {
        name: $(obj).val()
      },
      success: function(data) {
        console.log(data);
      }, 
      error: function(jqxhr) {
        alert("There was an error");
        console.log(jqxhr);
      }
    });
  });
});
</script>
<!--$('select[name="user_id"]').change(function(e) {
		var obj = this;
		$.ajax({
			url: "{{ URL::route('lineup.add_user', $lineup->id) }}",
			method: "POST",
			dataType: "html",
			data: {
				user_id: e.val
			},
			success: function(data) {
			  reloadById({{ $lineup->id }});
			},
			error: function(jqxhr) {
				console.log(jqxhr);
			}
		});
	});
});

function reloadById(id) {
  $('.team-roster').each(function() {
    if ($(this).data('lineup-id') == id) {
      $.ajax({
        url: "{{ URL::route('lineup.show', $lineup->id) }}",
        method: "GET",
        dataType: "html",
        success: function(data) {
          $(obj).replaceWith(data);
        }
        error: function(jqxhr) {
          console.log(jqxhr);
        }
      });
    }
  });
}
</script>-->
@endif
