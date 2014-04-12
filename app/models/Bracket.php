<?php

/**
 * Bracket
 *
 * @property-read \Match $match
 * @property-read \Tournament $tournament
 */
class Bracket extends Eloquent {
	protected $fillable = array('tournament_id', 'match_id');
	protected $guarded = array('id');

	public function match() {
		return $this->hasOne('Match');
	}

	public function tournament() {
		return $this->belongsTo('Tournament');
	}

	public function advance($mid, $tid) {
		if ($this->ro == 2) return;
		$match = Match::find($mid);
		$destination = $this->nextUpBracket($this->ro, $match->position);
		$destination->teams()->attach($tid);
		if ($destination->teams()->count() == 2) {
			$destination->generateGames();
		}
	}

	public function nextUpBracket($ro, $pos) {
		$position = ceil($pos / 2);
		$ro = $ro / 2;
		$rid = Round::where('tournament_id', '=', $this->tournament_id)->where('ro', '=', $ro)->get()->first()->id;
		return Match::where('position', '=', $position)->where('round_id', '=', $rid)->get()->first();
	}

	public static function calculateRo($count) {
		if ($count == 1 || $count == 0) return false;

		$log = log($count, 2);
		if ($log % 1 != 0) {
			return false;
		}
		else return $count;
	}

	public function generateMatches() {
		foreach ($this->matches as $match) {
			$match->generateGames();
		}
	}
}
