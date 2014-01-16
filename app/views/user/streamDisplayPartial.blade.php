<div class="pure-g stream-teams">
  <div class="pure-u-1-2">
    <h2>{{ $match->teams->first()->name }}</h2>
  </div>
  <div class="pure-u-1-2">
    <h2>{{ $match->teams->last()->name }}</h2>
  </div>
  <?php $first = true;?>
  @for($i = 0; $i < count($players); $i++)
    @foreach ($players[$i] as $arr)
      @foreach ($arr as $player)
        <div class="pure-u-1-2">
          @if(!$first)
            @include('user/profileCardPartial', array('user' => $player, 'dispTip' => true, 'smallCard' => true, 'dispCharcode' => false))
          @else
            @include('user/profileCardPartial', array('user' => $player, 'dispTip' => true, 'dispCharcode' => false))
          @endif
        </div>
      @endforeach
      <?php $first = false; ?>
    @endforeach
  @endfor
</div>

