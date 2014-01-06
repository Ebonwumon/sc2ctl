<?php
class Team extends Eloquent { 

	protected $fillable = array('name', 'user_id', 'contact', 'img_url', 'tag');
	protected $guarded = array('id');

	public function user() {
		return $this->belongsTo('User');
	}

	public function members() {
		return $this->hasMany('User');
	}

	public function lineups() {
		return $this->hasMany('Lineup');
	}

	public function matches() {
		// TOdo will not retun
		return $this->hasMany('Match');
	}

	public function tournaments() {
		return $this->belongsToMany('Tournament');
	}

	//Todo maybe bug from not deleting bnet_ids
	public function userInList($bnet_ids) {
		foreach ($this->members as $member) {
			if (in_array($member->bnet_id, $bnet_ids)) {
				return $member->id;
			}
		}

		return false;
	}

  public function playerSelect() {
    $list = array();
    foreach ($this->members as $user) {
      $list[$user->id] = $user->bnet_name . "#" . $user->char_code;
    }
    return $list;
  }

	public function getMedianWinrate() {
		$arr = array();
		foreach ($this->members as $member) {
			$arr[] = $member->getWinrate()['ratio'];
		}
		if (count($arr) == 0) {
			return 0;
			// We don't want to divide by zero if the team has no members
		}
		sort($arr);
		$median = $arr[ceil(count($arr) / 2) -1];	

		return $median;
	}

	public static function getTBD() {
		$team = new Team;
		$team->name = "TBD";
		$team->tag = "TBD";
		$team->id = 0;
		return $team;
	}
}
