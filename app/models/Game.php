<?php

/**
 * Game
 *
 * @property integer $id
 * @property integer $winner
 * @property integer $match_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $replay_url
 * @property boolean $is_default
 * @property-read \Match $match
 * @property-read \Map $map
 * @method static \Illuminate\Database\Query\Builder|\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereWinner($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereReplayUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereIsDefault($value)
 */
class Game extends Eloquent {

	protected $fillable = array('winner', 'match_id', 'replay_url');

	protected $guarded = array('id');
	
	public function match() {
		return $this->belongsTo('Match');
	}

  public function players() {
    $game_ids = $this->match->games->lists('id');
    $map = array_search($this->id, $game_ids);
    if ($map === FALSE || !$this->match->rostersComplete()) return $this->match->players();
    $map = $map + 1; 
    $rosters = $this->match->rosters;
    $players = new Illuminate\Database\Eloquent\Collection;
    foreach ($rosters as $roster) {
      $entries = $roster->entries()->where('map', '=', $map);
      if ($entries->count() == 0) continue;
      $players->add($roster->entries()->where('map', '=', $map)->first()->player);
    }
    if ($players->count() == 0) return $this->match->players();
    return $players;
  }
  /*public function players() {
    return $this->belongsToMany('User')->withPivot('team_id')->orderBy('game_user.team_id');
  }*/

  public function opponent($id) {
    if ($this->players->first()->id == $id) return $this->players->last();
    if ($this->players->last()->id == $id) return $this->players->first();
  }

  public function getWinner() {
    return $this->belongsTo('User', 'winner');
  }

  public function winningLineup() {
    $teams = $this->match->teams()->whereHas('players', function($query) {
          $query->withTrashed()->where('user_id', '=', $this->winner);
        });
    if ($teams->count() > 1) throw new Exception('Player is playing for multiple lineups');
    return $teams;
  }

	public function map() {
		return $this->belongsTo('Map');
	}
  
  public function won($id) {
    if (!$this->winner) return false;
    return ($this->winner == $id);
  }

	public function reportWinner($id) {
		$this->winner = $id;
		$this->save();
		if ($this->match->round_id) {
			if ($this->match->won()) {
				$user = User::find($id);
				$this->match->round->advance($this->match->id, $user->team->id);
			}
		}
	}
  
  /*
	public function setActives($bnet_ids) {
		$teams = $this->match->teams()->get();
		$user1 = $teams->first()->userInList($bnet_ids);
		if (!$user1) return false;
		
		$user2 = $teams->last()->userInList($bnet_ids);
		if (!$user2) return false;

		$this->player1 = $user1;
		$this->player2 = $user2;
		$this->save();
		return true;
	}*/

  public function canReport($user) {
    return $this->match->canReport($user);
  }

}
