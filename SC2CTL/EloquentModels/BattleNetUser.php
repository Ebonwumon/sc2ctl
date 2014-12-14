<?php

namespace SC2CTL\DotCom\EloquentModels;

class BattleNetUser extends BaseModel
{

    public $table = "bnet_users";

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [self::GUARDED],
        'user_id' => [self::FILLABLE, self::UPDATEABLE],
        'bnet_id' => [self::FILLABLE, self::UPDATEABLE],
        'realm' => [self::FILLABLE, self::UPDATEABLE],
        'name' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'display_name' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'profile_url' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'race' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'league' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'terran_wins' => [self::FILLABLE, self::UPDATEABLE],
        'protoss_wins' => [self::FILLABLE, self::UPDATEABLE],
        'zerg_wins' => [self::FILLABLE, self::UPDATEABLE],
        'season_total_games' => [self::FILLABLE, self::UPDATEABLE],
        'career_total_games' => [self::FILLABLE, self::UPDATEABLE],
    ];

    public function getQualifiedNameAttribute()
    {
        return $this->name;
    }

    public function getLeagueImgAttribute()
    {
        $league = strtolower($this->league);
        return "/img/icon/leagues/{$league}.png";
    }

    public function getRaceAttribute($race)
    {
        return ucfirst(strtolower($race));
    }

    public function getSeasonWinsAttribute()
    {
        switch ($this->getRaceAttribute($this->race)) {
            case "Terran":
                return $this->terran_wins;
                break;
            case "Zerg":
                return $this->zerg_wins;
                break;
            case "Protoss":
                return $this->protoss_wins;
                break;
            default:
            case "Random":
                return $this->getAllRaceSeasonWinsAttribute();
                break;
        }
    }

    public function getAllRaceSeasonWinsAttribute()
    {
        return $this->terran_wins + $this->protoss_wins + $this->zerg_wins;
    }

    public function getSeasonLossesAttribute()
    {
        return $this->season_total_games - $this->getAllRaceSeasonWinsAttribute();
    }

    public function getSeasonWinrateAttribute()
    {
        if ($this->season_total_games == 0) {
            return 0;
        }
        return $this-> getAllRaceSeasonWinsAttribute() / $this->season_total_games;
    }

} 