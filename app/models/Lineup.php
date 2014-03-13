<?php 

class Lineup extends Eloquent {
	
	
	public function historicalPlayers() {
		return $this->belongsToMany('User')->withPivot('active', 'role_id')->withTimestamps();
	}

	public function players() {
		return $this->belongsToMany('User')->withPivot('active', 'role_id')->withTimestamps()->where('active', '=', 1);
	}

  public function team() {
    return $this->belongsTo('Team');
  }

  public function registrations() {
    return $this->belongsToMany('Tournament');
  }

  public function tournaments() {
    return $this->belongsToMany('Tournament');
  }

  public function activeTournaments() {
    $active_seasons = DB::table('seasons')->where('end_date', '>', new DateTime('NOW'))
                          ->lists('id');
    if (count($active_seasons) == 0) return new Illuminate\Support\Collection;
    
    return $this->tournaments()->whereIn('season_id', $active_seasons)->get();
  }

  public function activeMatchesForTournament($id) {
    return $this->belongsToMany('Match')->whereHas('swissRound', function($q) use ($id) {
          $q->whereHas('tournament', function($q) use ($id) {
              $q->where('id', '=', $id);
            });
        });
  }

  public function getQualifiedNameAttribute() {
    return $this->attributes['name'] . "#" . "[" . $this->team->tag . "]";
  }

  public function anyRegistration() {
    return $this->activeTournaments()->count();
  }

  public function canRename($user) {
    if ($user->hasAccess('rename_lineups')) return true;
    
    if ($user->hasAccess('rename_team_lineups')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('rename_lineup')) {
      $entry = $this->players()->where('user_id', '=', $user->id);
      if ($entry->count() > 0) return true;
    }
    return false;
  }

  public function canRegister($user) {
    if ($user->hasAccess('register_rosters')) return true;

    if ($user->hasAccess('register_team_rosters')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('register_roster')) {
      $entry = $this->players()->where('user_id', '=', $user->id);
      if ($entry->count() > 0) return true;
    }

    return false;
  }
}
