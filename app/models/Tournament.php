<?php

class Tournament extends Eloquent {

	protected $fillable = array('name', 'phase', 'division', 'winner');
	
	protected $guarded = array('id');

	public function groups() {
		return $this->hasMany('Group');
	}

	public function brackets() {
		return $this->hasOne('Bracket');
	}
	
	public function teams() {
		return $this->belongsToMany('Team');
	}

	public function teamsWithAllMembersPlaying() {
		$arr = array();
		foreach ($this->teams as $team) {
			$playing = true;
			foreach ($team->members as $member) {
				if (!$member->hasPlayedGamesInTournaments(array($this->id))) {
					$playing = false;
					break;
				}
			}
			if ($playing) {
				$arr[] = $team;
			}
		}

		return $arr;
	}

	public function isInTournament($id) {
		$teams = $this->teams()->get()->toArray();
		foreach ($teams as $team) {
			$registered = array_first($team, function($key, $value) {
				return ($key == 'id' && $value == Auth::user()->team_id);
			});
			if ($registered) return true;
		}

		return false;
	}

	public static function filterPhase($args, $phase) {
		$filter = array();
		foreach ($args as $arg) {
			if ($arg->phase == $phase) {
				$filter[] = $arg;
			}
		}
		return $filter;
	}

	
	public function generateGroups() {
		$count = $this->teams()->count();
		
		switch ($count % 4) {
			case 0: $numThrees = 0; 
			break;
			case 1: $numThrees = 3; 
			break;
			case 2: $numThrees = 2;
			break;
			case 3: $numThrees = 1; 
			break;
		}

		$teams = $this->teams()->orderBy(DB::raw('RAND()'))->get();
		$result = array();

		foreach ($teams as $team) {
			$result[]= $team->id;
		}

		$teams = $result;

		if ($count == 5) {
			$group = Group::create(array('tournament_id' => $this->id, 'phase' => 0, 'multiplier' => 1));
			$group->teams()->sync($teams);
			return;
		}

		for ($i = 0; $i < $numThrees; $i++) {
			$group = Group::create(array('tournament_id' => $this->id, 'phase' => 0, 'mulitiplier' => 1));
			for ($k = 0; $k < 3; $k++) {
				$group->teams()->attach(array_pop($teams));
			}
		}
		if (!$teams) return;

		$i = 0;
		$group = Group::create(array('phase' => 0, 'mulitiplier' => 1, 'tournament_id' => $this->id));
		while ($teams) {
			$group->teams()->attach(array_pop($teams));
			
			if ($i == 3) {
				if (!$teams) return;
				$group = Group::create(array('phase' => 0, 'mulitiplier' => 1, 'tournament_id' => $this->id));
				$i = 0;
			} else {
				$i++;
			}
		}
	}

	public function generateBracket($teams) {
		$ro = Round::calculateRo(count($teams));

		$round = new Round;
		$round->ro = $ro;
		$round->tournament_id = $this->id;
		$round->save();

		$i = 1;
		$pos = 1;
		$teams = array_reverse($teams);
		$match = Match::create(array('bo' => 9, 'round_id' => $round->id, 'position' => $pos));
		
		while($teams) {
			$match->teams()->attach(array_pop($teams));

			if ($i == 2) {
				$pos += 1;
				$i = 0;
				if (!$teams) break;	
				$match = Match::create(array('bo' => 9, 'round_id' => $round->id, 'position' => $pos));
			}
			$i++;
		}

		$ro = $ro / 2;
		$pos = 1;
		$round = new Round;
		$round->ro = $ro;
		$round->tournament_id = $this->id;
		$round->save();

		while ($ro > 1) {
			for ($i = 0; $i < $ro / 2; $i++) {
				$match = Match::create(array('bo' => 9, 'round_id' => $round->id, 'position' => $pos));
				$pos += 1;
			}
			$pos = 1;
			$ro = $ro / 2;
			if ($ro > 1) {
				$round = Round::create(array('ro' => $ro, 'tournament_id' => $this->id));
			}
		}
	}

	public function getGlobalStandings() {
		$globalStandings = array();
		foreach ($this->groups as $group) {
			array_radsum($globalStandings, $group->standings());
		}
		arsort($globalStandings);
		return $globalStandings;
	}
	
	public function getDivision() {
		switch($this->division) {
			case 'BSG': return "Bronze/Silver/Gold";
			case 'PD': return "Platinum/Diamond";
			case 'DM': return "Diamond/Masters";
			case 'M': return "Masters";
			case 'MGM': return "Masters/Grandmasters";
		}
	}

	public function getPhase() {
		switch($this->phase) {
			case '0': return "Not yet started";
			case '1': return "Group Stage 1";
			case '2': return "Group Stage 2";
			case '3': return "Playoff Bracket";
		}
	}

	}
