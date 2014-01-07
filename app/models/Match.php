<?php

class Match extends Eloquent {
	
	protected $fillable = array('bo', 'due', 'winner', 'doodle_id', 'position', 'bracket_id', 'group_id');
	protected $guarded = array('id');

	public function games() {
		return $this->hasMany('Game');
	}

	public function teams() {
		return $this->belongsToMany('Team')->orderBy('team_id');
	}

	public function group() {
		return $this->belongsTo('Group');
	}

	public function bracket() {
		return $this->belongsTo('Bracket');
	}

	public function getDates() {
		return array('created_at', 'updated_at', 'due');
	}

	public function getFinishedGames() {
		return $this->games()->where('winner', '>', 0)->get();
	}
	
	public function getTeams() {
		switch ($this->hasTeams()) {
		case 0: 
			return $this->teams()->get()->add(Team::getTBD())->add(Team::getTBD());
			break;
		case 1:
			return $this->teams()->get()->add(Team::getTBD());
			break;
		case 2:
			return $this->teams()->get();
			break;
		}
	}

  public function getPlayers() {
    $prev = true;
    $players = array();
    $team1 = $this->teams->first()->id ;
    $team2 = $this->teams->last()->id;
    $i = 1;
    foreach ($this->games as $game) {
      // Todo handle one player
      if ($game->players()->count() < 2) { continue; }
      if (!$game->winner && $prev) {
        $players[0][] = [ 
                          $game->players()->wherePivot('team_id', '=', $team1)->get()[0],
                          $game->players()->wherePivot('team_id', '=', $team2)->get()[0]
                         ];
        $prev = false;
      } else {
        $players[$i][] = [ 
                         $game->players()->wherePivot('team_id', '=', $team1)->get()[0], 
                         $game->players()->wherePivot('team_id', '=', $team2)->get()[0], 
                       ];

        $i++;
      }
    }
    return $players;
  }

	public function getTournament() {
		if ($this->round_id) {
			return $this->round->tournament;
		}
		if ($this->group_id) {
			return $this->group->tournament;
		}
		return false;
	}
	public function score() {
		$team1 = 0;
		$team2 = 0;
		$teams = $this->teams()->get();

		foreach($this->games as $game) {
			if ($game->winner) {
				$user = User::find($game->winner);
				if ($teams->first()->id == $user->team_id) {
					$team1++;
				} else if ($teams->last()->id == $user->team_id) {
					$team2++;
				} else if ($game->player1 == $user->id) {
					$team1++;
				} else if ($game->player2 == $user->id) {
					$team2++;
				}
			}
		}

		return [ $team1, $team2 ];
	}

	public function won() {
		$score = $this->score();

		if ($score[0] > $this->bo / 2) return $this->getTeams()->first()->id;
		if ($score[1] > $this->bo /2 ) return $this->getTeams()->last()->id;
		return 0;
	}

	public function teamInMatch($id) {
		$teams = $this->teams()->get();
		if ($this->hasTeams()) {
			return $teams->first()->id == $id || $teams->last()->id == $id;
		}
		return false;
	}

	public function hasTeams() {
		return $this->teams()->count();
	}
  
	public function generateGames($team1, $team2) {
		$teams = $this->teams()->get();
		for ($i = 0; $i < $this->bo; $i++) {
			$game = new Game;
			$game->match_id = $this->id;
			$game->save();
      $player1 = (array_key_exists($i, $team1) && $team1[$i]) ? $team1[$i]: null;
			$player2 = (array_key_exists($i, $team2) && $team2[$i]) ? $team2[$i]: null;
      if ($player1 != null) $game->players()->attach($player1, array('team_id' => $teams[0]->id));
      if ($player2 != null) $game->players()->attach($player2, array('team_id' => $teams[1]->id));

		}
	}
}
