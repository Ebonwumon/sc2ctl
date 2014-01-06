<?php

use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {
	
	protected $fillable = array('username', 'email', 'bnet_url', 'bnet_id', 'bnet_name', 'char_code', 'league', 'img_url', 'team_id');

	protected $guarded = array('id');

	
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	public function getAuthPassword() {
		return Hash::make($this->email);
	}

	public function notifications() {
		return $this->belongsToMany('Notification')->withPivot('read')->withTimestamps();
	}

	public function team() {
		return $this->belongsTo('Team');
	}

	/**
	* Takes an array of tournament ids
	*/
	public function hasPlayedGamesInTournaments($ids) {
		$played = DB::table('games')
		                ->leftJoin('matches', 'games.match_id', '=', 'matches.id')
										->leftJoin('groups', 'matches.group_id', '=', 'groups.id')
										->whereIn('groups.tournament_id', $ids)
										->where(function($query) {
												$query->where('games.player1', '=', $this->id)
													->orWhere('games.player2', '=', $this->id);
										})
										->count();
		return $played;

	}

	public function getWinrate() {
    $wins = Game::where('winner', '=', $this->id)->count();
		$losses = Game::whereRaw('(player1 = ? OR player2 = ?) AND winner > 0 AND winner <> ?',
		                          array($this->id, $this->id, $this->id))->count();
		if ($losses == 0) {
			$ratio = 0;
		} else {
			$ratio = number_format($wins / ($wins + $losses) * 100, 2);
		}

		return array('wins' => $wins, 'losses' => $losses, 'ratio' => $ratio);

	}
	public function canManageTeam($id) {
		if (Entrust::can('manage_teams')) {
			return true;
		} elseif (Entrust::can('manage_own_team')) {
			if ($this->team_id == $id) { 
				return true;
			}
		}
		return false;
	}
	
	public function leaveTeam() {
		$team = $this->team;
		if ($team->members->count() < 2 ) {
			Team::destroy($team->id);
			$this->detachRole(ROLE_TEAM_CAPTAIN);
		} elseif ($team->leader == $this->id) {
			return;
		}

		if ($team->contact == $this->id) {
			$team->contact = $team->leader;
			$team->save();
		}
		$this->team_id = null;
		$this->save();
	}

	static function getCaptains() {
		$arr = array();
		$role = Role::find(ROLE_TEAM_CAPTAIN);
		$users = $role->users()->get();
		foreach ($users as $user) {
			$arr[]= $user->id;
		}
		return $arr;
	}
	static function getAll() {
		return DB::table('users')->lists('id');
	}

  static function listAll() {
    $list = array();
    $users = DB::table('users')->select('id', 'bnet_name', 'char_code')->get();
    foreach ($users as $user) {
      $list[$user->id] = $user->bnet_name . "#" . $user->char_code;
    }
    return $list;
  }

}
