<?php

namespace SC2CTL\DotCom\EloquentModels;

class Role extends BaseModel
{

    const MEMBER = 10;
    const OFFICER = 20;
    const CAPTAIN = 30;
    const TEAM_OWNER = 40;
    const CASTER = 50;
    const MOD = 100;
    const ADMIN = 1000;

    public function __construct(array $attributes = array()) {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [ self::GUARDED ],
        'name' => [ self::FILLABLE, self::UPDATEABLE ],
    ];
}
