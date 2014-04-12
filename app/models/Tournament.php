<?php

/**
 * Class Tournament
 * Represents a tournament object within the database and the methods upon it
 *
 * @property integer $id
 * @property string $name
 * @property string $division
 * @property integer $phase
 * @property integer $winner
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $season_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Group[] $groups
 * @property-read \Bracket $brackets
 * @property-read \Illuminate\Database\Eloquent\Collection|\Lineup[] $teams
 * @property-read \Illuminate\Database\Eloquent\Collection|\SwissRound[] $swissRounds
 * @property-read \Illuminate\Database\Eloquent\Collection|\SwissRound[] $currentRound
 * @property-read \Season $season
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereDivision($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament wherePhase($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereWinner($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Tournament whereSeasonId($value)
 */
class Tournament extends Eloquent
{

    protected $fillable = array('name', 'phase', 'division', 'winner', 'season_id');

    protected $guarded = array('id');

    public function groups()
    {
        return $this->hasMany('Group');
    }

    public function brackets()
    {
        return $this->hasOne('Bracket');
    }

    public function teams()
    {
        return $this->belongsToMany('Lineup');
    }

    public function swissRounds()
    {
        return $this->hasMany('SwissRound');
    }

    public function currentRound()
    {
        return $this->hasMany('SwissRound')->orderBy('id')->take(1);
    }

    public function season()
    {
        return $this->belongsTo('Season');
    }

    public function teamsWithAllMembersPlaying()
    {
        $arr = array();
        foreach ($this->teams as $lineup) {
            $playing = true;
            foreach ($lineup->players as $player) {
                if (!$player->hasPlayedGamesInTournaments(array($this->id))) {
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

    /**
     * Filters the array
     */
    public function filterEnrolledLineups($lineup_arr, $inverse = false)
    {
        if (count($lineup_arr) == 0) return array();

        if ($inverse) {
            $ret = array();
            foreach ($lineup_arr as $id => $lineup) {
                if ($this->teams->contains($id)) continue;
                $ret[$id] = $lineup;
            }
            return $ret;
        }
        return $this->teams()->whereIn('lineup_id', array_keys($lineup_arr))
            ->lists('name', 'id');
    }

    public function userInTournament($user)
    {
        foreach ($user->lineups()->lists('lineup_id') as $lineup_id) {
            if ($this->teams->contains($lineup_id)) {
                return true;
            }
        }
        return false;
    }

    // Todo what if I want to call this without the context of a user?
    public function isInTournament($id)
    {
        $teams = $this->teams->toArray();
        foreach ($teams as $team) {
            $registered = array_first($team, function ($key, $value) {
                return ($key == 'id' && $value == Sentry::getUser()->team_id);
            });
            if ($registered) return true;
        }

        return false;
    }

    public function initial_swiss_round($due)
    {
        DB::transaction(function () use ($due) {
            $swiss_round = SwissRound::create(array('due_date' => $due,
                'tournament_id' => $this->id));
            $teams = $this->teams()->orderBy(DB::raw('RAND()'))->get()->toArray();
            $numMatches = floor(count($teams) / 2);
            $odd = count($teams) % 2 != 0;

            // we generate all the full matches
            for ($i = 0; $i < $numMatches; $i++) {
                $match = new Match;
                $match->bo = 7;
                $match->swiss_round_id = $swiss_round->id;
                $match->save();
                $match->teams()->sync(array(array_pop($teams)['id'], array_pop($teams)['id']));
                $match->generateGames();
            }
            if ($odd) {
                // We have an odd number of teams, so we'll need to generate a bye
                $team = array_pop($teams)['id'];
                $match = Match::create(array('bo' => 7,
                    'swiss_round_id' => $swiss_round->id,
                    'is_default' => $team,
                ));
                $match->teams()->attach($team);
            }
            $this->phase = 1;
            $this->save();
        });
        DB::commit();
    }

    /*public function next_swiss_round($due) {
      $swiss_round = new SwissRound;
      $swiss_round->due_date = $due;
      $swiss_round->save();

    }*/
    public static function filterPhase($args, $phase)
    {
        $filter = array();
        foreach ($args as $arg) {
            if ($arg->phase == $phase) {
                $filter[] = $arg;
            }
        }
        return $filter;
    }

    /* Deprecated functions
    public function generateGroups() {
        $count = $this->teams->count();

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
  */

    /**
     * Calculates the current standings of all the swiss rounds that have occurred so far, ordered by ranking
     * of teams.
     * @return SwissRoundScore[]
     */
    public function getRoundStandings() {
        /**
         * @var $overallScore SwissRoundScore[]
         */
        $overallScore = array();
        foreach ($this->swissRounds as $round) {
            /**
             * @var $round SwissRound
             */
            foreach ($round->summarize() as $roundSummary) {
                if (array_key_exists($roundSummary->name, $overallScore)) {
                    $overallScore[$roundSummary->name]->wins += $roundSummary->wins;
                    $overallScore[$roundSummary->name]->losses += $roundSummary->losses;
                } else {
                    $overallScore[$roundSummary->name] = $roundSummary;
                }
            }
        }

        return $overallScore;
    }

    //Deprecated
    /*public function getGlobalStandings()
    {
        $globalStandings = array();
        foreach ($this->groups as $group) {
            array_radsum($globalStandings, $group->standings());
        }
        arsort($globalStandings);
        return $globalStandings;
    }*/

    public function getDivision()
    {
        switch ($this->division) {
            case 'BSG':
                return "Bronze/Silver/Gold";
            case 'PD':
                return "Platinum/Diamond";
            case 'DM':
                return "Diamond/Masters";
            case 'M':
                return "Masters";
            case 'MGM':
                return "Masters/Grandmasters";
        }
    }

    public function getPhase()
    {
        switch ($this->phase) {
            case '-1':
                return "Completed";
            case '0':
                return "Not yet started";
            case '1':
                return "Group Stage 1";
            case '2':
                return "Group Stage 2";
            case '3':
                return "Playoff Bracket";
        }
    }

}
