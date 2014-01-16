<a href="{{ URL::route('team.profile', $team->id) }}" class="nolink">
  <div class="profile-card @if($smallCard) profile-card-small @endif centered">
    <div class="logo-img">
      <img src="{{ $team->logo_url }}" />
    </div>
    <span class="primary-name impact">[{{ $team->tag }}]</span>
    <span class="secondary-name impact">{{ $team->name }}</span>
   </div>
</a>
