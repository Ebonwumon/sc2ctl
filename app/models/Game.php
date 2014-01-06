<?php

class Game extends Eloquent {

	protected $fillable = array('player1', 'player2', 'winner', 'match_id', 'replay_url');

	protected $guarded = array('id');
	
	public function match() {
		return $this->belongsTo('Match');
	}

	public function playerone() {
		return $this->belongsTo('User', 'player1');
	}

	public function playertwo() {
		return $this->belongsTo('User', 'player2');
	}

  public function players() {
    return $this->belongsToMany('User')->withPivot('team_id')->orderBy('team_id');
  }

	public function map() {
		return $this->belongsTo('Map');
	}

	public function winner() {
		if($this->winner) {
			return User::find($this->winner);
		}
		return 0;
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
