<a href="{{ URL::route('team.show', $lineup->team->id) }}" class="nolink">
  <div class="profile-card @if($smallCard) profile-card-small @endif centered">
    <div class="logo-img">
      <img src="{{ $lineup->team->logo_url }}" />
    </div>
    <span class="primary-name impact">{{ $lineup->name }}</span>
    <span class="secondary-name impact">[{{ $lineup->team->tag }}]</span>
   </div>
</a>
