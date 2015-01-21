<?php

namespace SC2CTL\DotCom\EloquentModels;

class Role extends BaseModel
{

    const MEMBER = "member";
    const OFFICER = "officer";
    const CAPTAIN = "captain";
    const TEAM_OWNER = "owner";
    const CASTER = "caster";
    const MOD = "mod";
    const ADMIN = "admin";

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [ self::FILLABLE ],
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'permission_id', 'id');
    }
}
