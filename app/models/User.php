<?php
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

/**
 * User
 *
 * @property integer $id
 * @property string $email
 * @property string $username
 * @property integer $bnet_id
 * @property string $bnet_name
 * @property integer $char_code
 * @property string $league
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $bnet_url
 * @property integer $team_id
 * @property string $img_url
 * @property \Carbon\Carbon $deleted_at
 * @property string $password
 * @property string $permissions
 * @property boolean $activated
 * @property string $activation_code
 * @property \Carbon\Carbon $activated_at
 * @property \Carbon\Carbon $last_login
 * @property string $persist_code
 * @property string $reset_password_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\Notification[] $notifications
 * @property-read \Team $team
 * @property-read \Illuminate\Database\Eloquent\Collection|\Lineup[] $lineups
 * @property-read \Illuminate\Database\Eloquent\Collection|\Lineup[] $lineupsForTournament
 * @property-read mixed $qualified_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\static::$groupModel[] $groups
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereBnetId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereBnetName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCharCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLeague($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereBnetUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereTeamId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereImgUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivated($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePersistCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereResetPasswordCode($value)
 */
class User extends SentryUserModel
{

    protected $fillable = array(
        'username',
        'password',
        'email',
        'bnet_url',
        'bnet_id',
        'bnet_name',
        'char_code',
        'league',
        'img_url',
        'team_id'
    );
    protected $hidden = array( 'password' );
    protected $guarded = array( 'id' );

    public function notifications()
    {
        return $this->belongsToMany('Notification')->withPivot('read')->withTimestamps();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function team()
    {
        return $this->belongsTo('Team');
    }

    public function lineups()
    {
        return $this->belongsToMany('Lineup')->withPivot("role_id");
    }

    public function lineupsForTournament($id)
    {
        $tournament = Tournament::findOrFail($id);
        $ids = $tournament->teams()->lists('lineup_id');
        return $this->belongsToMany('Lineup')->whereIn('lineup_id', $ids);
    }

    public function lineupsForMatch($id)
    {
        return $this->belongsToMany('Lineup')->whereHas('matches', function ($query) use ($id) {
            $query->where('match_id', '=', $id);
        });
    }

    public function getQualifiedNameAttribute()
    {
        return $this->bnet_name . "#" . $this->char_code;
    }

    public function recalculateGroups()
    {
        $groups = $this->getGroups();
        $team_owner = Team::where('user_id', '=', $this->id)->count();
        if ($team_owner) {
            try {
                $owner_group = Sentry::findGroupById(Role::TEAM_OWNER);
                if (!$this->inGroup($owner_group)) {
                    $this->addGroup($owner_group);
                }
            } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e) {
                //TODO should probably do something
            }
        }

        $unmovable_groups = $this->groups()->where('persistent', '=', false)->get();
        foreach ($unmovable_groups as $ugroup) {
            $this->removeGroup($ugroup);
        }

        $role_pivots = $this->lineups()->lists('role_id');
        if (in_array(Role::CAPTAIN, $role_pivots)) {
            $new_group = Role::CAPTAIN;
        } else {
            if (in_array(Role::OFFICER, $role_pivots)) {
                $new_group = Role::OFFICER;
            } else {
                if (in_array(Role::MEMBER, $role_pivots)) {
                    $new_group = Role::MEMBER;
                } else {
                    return;
                }
            }
        }

        switch ($new_group) {
            case Role::CAPTAIN:
                $group = Sentry::findGroupById(Role::CAPTAIN);
                $this->addGroup($group);
            case Role::OFFICER:
                $group = Sentry::findGroupById(Role::OFFICER);
                $this->addGroup($group);
            case Role::MEMBER:
                $group = Sentry::findGroupById(Role::MEMBER);
                $this->addGroup($group);
                break;
        }
    }

    public static function validates($input)
    {
        $rules = array(
            'username' => 'sometimes|required|alpha_dash|between:3,80|unique:users',
            'email' => 'sometimes|email|unique:users|required',
            'bnet_name' => 'sometimes|required|alpha_num|between:3,80',
            'bnet_id' => 'sometimes|required|numeric|unique:users',
            'char_code' => 'sometimes|required|numeric',
            'league' => 'sometimes|required|in:Bronze,Silver,Gold,Platinum,Diamond,Master,Grandmaster',
            'bnet_url' => 'sometimes|required|url',
            'password' => 'sometimes|required|confirmed',
        );
        return Validator::make($input, $rules);
    }

    /**
     * Takes an array of tournament ids
     */
    public function hasPlayedGamesInTournaments($ids)
    {
        $played = DB::table('games')
            ->leftJoin('matches', 'games.match_id', '=', 'matches.id')
            ->leftJoin('groups', 'matches.group_id', '=', 'groups.id')
            ->whereIn('groups.tournament_id', $ids)
            ->where(function ($query) {
                $query->where('games.player1', '=', $this->id)
                    ->orWhere('games.player2', '=', $this->id);
            })
            ->count();
        return $played;

    }

    public function getWinrate()
    {
        $wins = Game::where('winner', '=', $this->id)->count();
        $losses = Game::whereRaw('(player1 = ? OR player2 = ?) AND winner > 0 AND winner <> ?',
            array( $this->id, $this->id, $this->id ))->count();
        if ($losses == 0) {
            $ratio = 0;
        } else {
            $ratio = number_format($wins / ($wins + $losses) * 100, 2);
        }

        return array( 'wins' => $wins, 'losses' => $losses, 'ratio' => $ratio );

    }

    public function canManageTeam($id)
    {
        if (Entrust::can('manage_teams')) {
            return true;
        } elseif (Entrust::can('manage_own_team')) {
            if ($this->team_id == $id) {
                return true;
            }
        }
        return false;
    }

    public function bnetInfo()
    {
        return $this->bnet_name . "#" . $this->char_code;
    }

    public function leaveTeam()
    {
        $team = $this->team;
        if ($team->members->count() < 2) {
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

    public function registerableLineups()
    {
        if ($this->hasAccess('register_lineups')) {
            return Lineup::all();
        }
        // Only team-based access remaining, if user is not on a team, return
        if (!$this->team_id) {
            return new Illuminate\Database\Eloquent\Collection;
        }

        if ($this->hasAccess('register_team_lineups')) {
            return Lineup::where('team_id', '=', $this->team_id)->get();
        }
        if ($this->hasAccess('register_team_lineup')) {
            return Lineup::whereHas('players', function ($query) {
                $query->where('user_id', '=', $this->id);
            })->get();
        }

    }

    public function listAccess($asset)
    {
        switch ($asset) {
            case "Lineup":
                if ($this->hasAccess('register_lineups')) {
                    return Lineup::get()->lists('qualified_name', 'id');
                }
                // Only team-based access remaining, if user is not on a team, return
                if (!$this->team_id) {
                    return array();
                }

                if ($this->hasAccess('register_team_lineups')) {
                    return Lineup::where('team_id', '=', $this->team_id)->get()->lists('qualified_name', 'id');
                }
                if ($this->hasAccess('register_team_lineup')) {
                    return Lineup::whereHas('players', function ($query) {
                        $query->where('user_id', '=', $this->id);
                    })->get()->lists('qualified_name', 'id');
                }
                break;

            case "Lineup-Report":
                if ($this->hasAccess('report_matches')) {
                    return Lineup::lists('id');
                }
                if (!$this->team_id) {
                    return array();
                }
                if ($this->hasAccess('report_team_matches')) {
                    return Lineup::where('team_id', '=', $this->team_id)->lists('id');
                }

                if ($this->hasAccess('report_team_match')) {
                    return Lineup::wherePivot('user_id', '=', $this->id)->lists('id');
                }
                break;
        }
    }

    static function getCaptains()
    {
        $arr = array();
        $role = Role::find(ROLE_TEAM_CAPTAIN);
        $users = $role->users()->get();
        foreach ($users as $user) {
            $arr[] = $user->id;
        }
        return $arr;
    }

    static function getAll()
    {
        return DB::table('users')->lists('id');
    }

    static function listTeamless()
    {
        return User::where('team_id', '=', 0)->get()->lists('qualified_name', 'id');
    }

    static function listAll()
    {
        $list = array();
        $users = DB::table('users')->select('id', 'bnet_name', 'char_code')->get();
        foreach ($users as $user) {
            $list[$user->id] = $user->bnet_name . "#" . $user->char_code;
        }
        return $list;
    }

}
