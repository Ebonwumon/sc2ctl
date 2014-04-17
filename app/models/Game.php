<?php

/**
 * Game
 *
 * @property integer $id
 * @property integer $winner
 * @property integer $match_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $replay_url
 * @property boolean $is_default
 * @property-read \Match $match
 * @property-read \Map $map
 * @method static \Illuminate\Database\Query\Builder|\Game whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereWinner($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereMatchId($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereReplayUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\Game whereIsDefault($value)
 */
class Game extends Eloquent
{

    protected $fillable = array('winner', 'match_id', 'replay_url');

    protected $guarded = array('id');

    public function match()
    {
        return $this->belongsTo('Match');
    }

    /**
     * Get the players for the current Game
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function players()
    {
        $game_ids = $this->match->games->lists('id');
        $map = array_search($this->id, $game_ids);
        if ($map === FALSE || !$this->match->rostersComplete()) return $this->match->players();
        $map = $map + 1;
        $rosters = $this->match->rosters;
        $players = new Illuminate\Database\Eloquent\Collection;
        foreach ($rosters as $roster) {
            $entries = $roster->entries()->where('map', '=', $map);
            if ($entries->count() == 0) continue;
            $players->add($roster->entries()->where('map', '=', $map)->first()->player);
        }
        if ($players->count() == 0) return $this->match->players();
        return $players;
    }

    /*public function players() {
      return $this->belongsToMany('User')->withPivot('team_id')->orderBy('game_user.team_id');
    }*/

    public function opponent($id)
    {
        if ($this->players->first()->id == $id) return $this->players->last();
        if ($this->players->last()->id == $id) return $this->players->first();
    }

    public function getWinner()
    {
        return $this->belongsTo('User', 'winner');
    }

    public function winningLineup()
    {
        $teams = $this->match->teams()->whereHas('historicalPlayers', function ($query) {
            $query->where('user_id', '=', $this->winner);
        });
        if ($teams->count() > 1) throw new Exception('Player is playing for multiple lineups');
        if ($teams->count() == 0) {
          throw new Exception('No winning lineup found, Game ID: ' . $this->id 
                                                        . " Winner ID: " . $this->winner);
        }
        return $teams;
    }

    public function map()
    {
        return $this->belongsTo('Map');
    }

    public function won($id)
    {
        if (!$this->winner) return false;
        return ($this->winner == $id);
    }

    public function reportWinner($id)
    {
        $this->winner = $id;
        $this->save();
        if ($this->match->round_id) {
            if ($this->match->won()) {
                $user = User::find($id);
                $this->match->round->advance($this->match->id, $user->team->id);
            }
        }
    }

    /*
      public function setActives($bnet_ids) {
          $teams = $this->match->teams()->get();
          $user1 = $teams->first()->userInList($bnet_ids);
          if (!$user1) return false;

          $user2 = $teams->last()->userInList($bnet_ids);
          if (!$user2) return false;

          $this->player1 = $user1;
          $this->player2 = $user2;
          $this->save();
          return true;
      }*/

    /**
     * Checks if a user can report the result of this Game.
     * @param $user \Cartalyst\Sentry\Users\Eloquent\User
     * @return bool
     */
    public function canReport($user)
    {
        if ($user->hasAccess('report_matches')) return true;

        // user will need to have a team to continue
        if (!$user->team_id) return false;
        // If the match doesn't involve any lineups that belong to the user's team, he can't report
        if ($this->match->teams()->where('team_id', '=', $user->team->id)->count() == 0) return false;


        if ($user->hasAccess('report_team_matches')) return true;

        if ($user->hasAccess('report_team_match')) {
            foreach ($this->match->teams as $lineup) {
                $authorized_roles = $lineup->players()->where(function ($query) {
                    $query->whereIn('role_id', array(Role::CAPTAIN, Role::OFFICER));
                })->where('user_id', '=', $user->id);
                if ($authorized_roles->count() > 0) return true;
            }
        }
        // Check if the user can at least report a single game in the match
        if ($user->hasAccess('report_match')) {
            if ($this->players()->contains($user->id)) return true;
        }
        return false;
    }

}
