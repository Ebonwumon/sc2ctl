<?php

namespace SC2CTL\DotCom\EloquentModels;

class Role extends BaseModel
{

    const ROLE_MEMBER = "member";
    const ROLE_OFFICER = "officer";
    const ROLE_CAPTAIN = "captain";
    const ROLE_TEAM_OWNER = "owner";
    const ROLE_CASTER = "caster";
    const ROLE_MOD = "mod";
    const ROLE_ADMIN = "admin";

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'permission_id', 'id');
    }
}
