<a href="{{ URL::route('user.profile', $user->id) }}" class="nolink">
  <div class="profile-card @if($smallCard) profile-card-small @endif centered">
    <div class="logo-img">
      <img src="{{ $user->img_url }}" />
    </div>
    <span class="primary-name impact">{{ $user->username }}</span>
    @if ($dispCharcode)
      <span class="secondary-name impact">{{ $user->bnet_name }}#{{ $user->char_code }}</span>
    @endif
   </div>
</a>
@if ($dispTip)
  <a target="_blank" href="{{ URL::route('dogetip.create', $user->id) }}" class="pure-button tip-button">Tip!</a>
@elseif ($win)
  <button class="pure-button tip-button pure-button-good">Win</button>
@elseif ($loss)
  <button class="pure-button tip-button pure-button-bad">Loss</button>
@endif
