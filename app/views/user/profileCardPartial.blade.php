<a href="{{ URL::route('user.profile', $user->id) }}" class="nolink">
  <div class="profile-card @if($smallCard) profile-card-small @endif centered">
    <div class="logo-img">
      <img src="{{ $user->img_url }}" />
    </div>
    <span class="primary-name impact">{{ $user->username }}</span>
    <span class="secondary-name impact">{{ $user->bnet_name }}#{{ $user->char_code }}</span>
  </div>
</a>
@if ($dispTip)
  <a target="_blank" href="{{ URL::route('dogetip.create', $user->id) }}" class="pure-button tip-button">Tip!</a>
@endif
