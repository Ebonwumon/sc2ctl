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

} 