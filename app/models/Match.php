<?php

class Match extends Eloquent {
	
	protected $fillable = array('bo', 'swiss_round_id', 'is_default');
	protected $guarded = array('id');

	public function games() {
		return $this->hasMany('Game')->orderBy('id');
	}

	public function teams() {
		return $this->belongsToMany('Lineup')->orderBy('team_id');
	}

	public function getDates() {
		return array('created_at', 'updated_at');
	}

	public function getFinishedGames() {
		return $this->games()->where('winner', '>', 0)->get();
	}

  public function canReport($user) {
    // Todo
    return true;
  }
	
	public function getTeams() {
		switch ($this->hasTeams()) {
		case 0: 
			return $this->teams->add(Team::getTBD())->add(Team::getTBD());
			break;
		case 1:
			return $this->teams->add(Team::getTBD());
			break;
		case 2:
			return $this->teams;
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

	public function score() {
		if ($this->is_default) {
      $team = Team::findOrFail($this->is_default);
      return [ $team->qualified_name => [ 'wins' => $this->bo, 
                                          'losses' => 0, 
                                          'id' => $team,
                                          'won' => true ] ];
    }
    $team1 = 0;
		$team2 = 0;
		$teams = $this->teams;
    
		foreach($this->games as $game) {
			if ($game->winner) {
        $winningTeam = $game->winningTeam();
				if ($winningTeam->id == $teams->first()->id) {
          $team1++;
        } else if ($winningTeam->id == $teams->first()->id) {
          $team2++;
        }
      }
		}
		return [ $teams->first()->qualified_name => 
              [ 'wins' => $team1, 
                'losses' => $team2, 
                'id' => $teams->first()->id,
                'won' => $team1 > $this->bo / 2 ],
             $teams->last()->qualified_name => 
              [ 'wins' => $team2, 
                'losses' => $team1, 
                'id' => $teams->last()->id,
                'won' => $team2 > $this->bo / 2 ]
           ];
	}

	public function won() {
		$score = $this->score();
    $keys = array_keys($score);
		if ($score[$keys[0]]['wins'] > $this->bo / 2) return $score[0]['id'];
    if ($score[$keys[1]]['wins'] > $this->bo /2 ) return $score[0]['id'];
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
  
	public function generateGames($rosters) {
		$teams = $this->teams;
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
