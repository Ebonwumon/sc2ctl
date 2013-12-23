<?php
define("UNSTARTED_GROUP", 1);
define("UNFINISHED_GAMES", 2);
define("FINISHED_STAGE_1", 3);

class Group extends Eloquent {
	
	protected $fillable = array('mulitplier', 'phase', 'tournament_id');

	protected $guarded = array('id');
	
	public function teams() {
		return $this->belongsToMany('Team');
	}

	public function tournament() {
		return $this->belongsTo('Tournament');
	}

	public function matches() {
		return $this->hasMany('Match');
	}

	public function currentStatus() {
		$matches = $this->matches()->get();

		if ($matches->count() == 0) {
			return array('code' => UNSTARTED_GROUP, 'status' => 'Unstarted Group');
		}

		$gamesFinished = true;
		
		foreach ($matches as $match) {
			if ($match->winner == 0) {
				$gamesFinished = false;
				break;
			}
		}

		if (!$gamesFinished) {
			return array('code' => UNFINISHED_GAMES, 'status' => 'Games being played out'); 
		}
	}

	public function standings() {
		$multiplier = ($this->multiplier) ? $this->multiplier : 1;
		$result = array();
		foreach ($this->matches()->get() as $match) {
			$teams = $match->teams()->get();
			$i = 0;
			foreach ($teams as $team) {
				if (!array_key_exists($team->tag, $result)) $result[$team->tag] = 0;
				$score = $match->score();
				$result[$team->tag] += ($score[$i] * 2 * $multiplier);
				$result[$team->tag]	-= ($score[($i+1) % 2] * $multiplier);
				$i++;
			}
		}

		arsort($result);
		return $result;
	}

	public function calculatePairings($teams) {
		switch ($teams->count()) {
			case 5:
				$first = array([$teams[0]->id, $teams[3]->id], [$teams[1]->id, $teams[2]->id]);
				$second = array([$teams[2]->id, $teams[0]->id], [$teams[3]->id, $teams[4]->id]);
				$third = array([$teams[4]->id, $teams[2]->id], [$teams[0]->id, $teams[1]->id]);
				$fourth = array([$teams[1]->id, $teams[4]->id], [$teams[2]->id, $teams[3]->id]);
				$fifth = array([$teams[3]->id, $teams[1]->id], [$teams[4]->id, $teams[0]->id]);
				return array($first, $second, $third, $fourth, $fifth);
				break;
			case 4:
				$first = array(array($teams[0]->id, $teams[1]->id), array($teams[2]->id, $teams[3]->id));
				$second = array([ $teams[0]->id, $teams[2]->id ], [ $teams[1]->id, $teams[3]->id ]);
				$third = array([ $teams[0]->id, $teams[3]->id ], [ $teams[1]->id, $teams[2]->id ]);
				return array($first, $second, $third);
				break;
			case 3:
				$first = array(array($teams[0]->id, $teams[1]->id));
				$second = array(array($teams[0]->id, $teams[2]->id));
				$third = array(array($teams[1]->id, $teams[2]->id));
				return array($first, $second, $third);
				break;
		}
	}
	
	public function generateMatch() {
		$teams = $this->teams()->get();
		switch($this->currentStatus()['code']) {
			case UNSTARTED_GROUP:
				$now = new DateTime();
				foreach($this->calculatePairings($teams) as $column) {
					$now = $now->add(new DateInterval('P7D'));
					$now->setTime(0,0);
					foreach($column as $pairing) {
						$match = Match::create(array('bo' => 9, 'group_id' => $this->id, 'due' => $now));
						$match->teams()->sync($pairing);
						$match->generateGames();
					}
				}
				$this->phase = $this->tournament->phase + 1;
				$this->save();
			break;
		}
			
	}
}
