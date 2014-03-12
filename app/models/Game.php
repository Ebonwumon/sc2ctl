<?php

class Game extends Eloquent {

	protected $fillable = array('winner', 'match_id', 'replay_url');

	protected $guarded = array('id');
	
	public function match() {
		return $this->belongsTo('Match');
	}

  public function players() {
    return $this->belongsToMany('User')->withPivot('team_id')->orderBy('game_user.team_id');
  }

  public function opponent($id) {
    if ($this->player1 == $id) return User::find($this->player2);
    if ($this->player2 == $id) return User::find($this->player1);
  }

  public function getWinner() {
    return $this->belongsTo('User', 'winner');
  }

  // TODO untested
  public function getWinningTeam() {
    $team_id = $this->players()->wherePivot('user_id', '=', $this->winner)->pivot->team_id;
    return $team_id;
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
	}

}
