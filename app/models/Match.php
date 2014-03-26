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

  public function swissRound() {
    return $this->belongsTo('SwissRound');
  }

  public function rosters() {
    return $this->hasMany('Roster');
  }

  public function players() {
    $players = new Illuminate\Database\Eloquent\Collection;
    foreach ($this->teams as $lineup) {
      $players = $lineup->players->merge($players);
    }
    return $players;
  }

  public function rosterForLineup($id) {
    return $this->hasOne('Roster')->where('lineup_id', '=', $id);
  }

	public function getDates() {
		return array('created_at', 'updated_at');
	}

  public function getQualifiedNameAttribute() {
    return $this->teams->first()->qualified_name . " vs. " . $this->teams->last()->qualified_name;
  }

  public function game($no) {
    $games = $this->games;
    if ($no < ($games->count())) {
      return $games->get($no);
    }
    return null;
  }

	public function getFinishedGames() {
		return $this->games()->where('winner', '>', 0)->get();
	}

  public function registerAce($winner, $loser) {
    $winningRoster = $this->rosterForLineup($winner->lineups->first()->id)->first();
    $losingRoster = $this->rosterForLineup($loser->lineups->first()->id)->first();

    $winningEntry = new RosterEntry;
    $winningEntry->player_id = $winner->id;
    $winningEntry->map = $this->bo;
    $winningEntry->roster_id = $winningRoster->id;
    $winningEntry->save();
    
    $losingEntry = new RosterEntry;
    $losingEntry->player_id = $loser->id;
    $losingEntry->map = $this->bo;
    $losingEntry->roster_id = $losingRoster->id;
    $losingEntry->save();

  }
  
  public function tournament() {
    if ($this->swissRound()->count() != 0) {
      return $this->swissRound->tournament();
    }
  }
  
  public function rostersComplete() {
    foreach ($this->teams as $lineup) {
      if ($this->rosterStatus($lineup->id) != Roster::STATUS_COMPLETE) {
        return false;
      }
    }

    return true;
  }
  public function rosterStatus($lineup_id) {
    $roster = $this->rosterForLineup($lineup_id);
    if ($roster->count() == 0) return Roster::STATUS_UNSTARTED; 
    $roster = $roster->get()->first();
    if (!$roster->confirmed) {  return Roster::STATUS_UNCONFIRMED; }
    return Roster::STATUS_COMPLETE;
  }
  
  public function canReport($user) {
    if ($user->hasAccess('report_matches')) return true;
    
    // user will need to have a team to continue
    if (!$user->team_id) return false;

    if ($user->hasAccess('report_team_matches')) {
      foreach ($this->teams as $lineup) {
        if ($lineup->team->id == $user->team_id) return true;
      }
    }

    if ($user->hasAccess('report_team_match')) {
      foreach ($this->teams as $lineup) {

        $authorized_roles = $lineup->players()->wherePivot(function($query) {
              $query->whereIn('role_id', array(Role::CAPTAIN, Role::OFFICER));
            })->where('user_id', '=', $user->id);
        if ($authorized_roles->count() > 0) return true;
      }
    }
    return false;
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
        $winning_lineup_id = $game->winningLineup->first()->id;

				if ($winning_lineup_id == $teams->first()->id) {
          $team1++;
        } else if ($winning_lineup_id == $teams->first()->id) {
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
		foreach ($this->score() as $score) {
      if ($score['won']) {
        return $score['id'];
      }
    }
    return false;
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
 

  public function generateGames() {
    for ($i = 0; $i < $this->bo; $i++) {
			$game = new Game;
			$game->match_id = $this->id;
			$game->save();
		}
  }
  //Deprecated
	/*public function generateGames($rosters) {
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
	}*/
}
