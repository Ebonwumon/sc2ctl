<?php 

/**
 * Lineup
 *
 * @property integer $id
 * @property integer $team_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $name
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $historicalPlayers
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $players
 * @property-read \Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tournament[] $registrations
 * @property-read \Illuminate\Database\Eloquent\Collection|\Tournament[] $tournaments
 * @property-read mixed $qualified_name
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Lineup whereDeletedAt($value)
 */
class Lineup extends Eloquent {
  protected $fillable = array('name', 'team_id');
  protected $guarded = array('id');
  protected $softDelete = true;
	
	public function historicalPlayers() {
		return $this->belongsToMany('User')->withPivot('role_id')->withTimestamps()->withTrashed();
	}

	public function players() {
		return $this->belongsToMany('User')->withPivot('role_id')->withTimestamps();
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

  public function remove($user_id) {
    $user = User::findOrFail($user_id);
    $entry = $this->players()->where('user_id', '=', $user_id)->firstOrFail();
    $entry->pivot->role_id = 0;
    $entry->pivot->delete();
    $user->recalculateGroups();
    if ($this->players()->count() == 0) {
      $this->delete();
    }
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
    if ($user->hasAccess('register_lineups')) return true;

    if ($user->hasAccess('register_team_lineups')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('register_team_lineup')) {
      $entry = $this->players()->where('user_id', '=', $user->id);
      if ($entry->count() > 0) return true;
    }

    return false;
  }

  public function canChangeRanks($user) {
    if ($user->hasAccess('modify_ranks')) return true;

    if ($user->hasAccess('modify_team_ranks')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('modify_team_rank')) {
      $entry = $this->players()->where('user_id', '=', $user->id);
      if ($entry->count() > 0) return true;
    }

    return false;

  }
  
  public function canRemoveMembers($user) {
    if ($user->hasAccess('remove_members')) return true;

    if ($user->hasAccess('remove_lineups_members')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('remove_lineup_members')) {
      $entry = $this->players()->where('user_id', '=', $user->id);
      if ($entry->count() > 0) return true;
    }

    return false;

  }

  public function canCreateRoster($user) {
    if ($user->hasAccess('create_rosters')) return true;

    if (!$user->team_id) return false;

    if ($user->hasAccess('create_team_rosters')) {
      if ($this->team->id == $user->team_id) return true;
    }

    if ($user->hasAccess('create_roster')) {
      if ($this->players->contains($user->id)) return true; // Todo verify roles
    }

    return false;
  }

    public function canViewRoster($user) {
        if ($user->hasAccess('view_rosters')) return true;

        if (!$user->team_id) return false;
        if ($user->team_id != $this->team->id) return false;
        if ($user->hasAccess('view_team_rosters')) return true;
        if ($user->hasAccess('view_roster')) {
            if ($this->players->contains($user->id)) return true;
        }

        return false;
    }
  public static function validate($input) {

    $rules = array(
        'name' => 'sometimes|Required|Between:1,128'
    );

    return Validator::make($input, $rules);
  }
}
