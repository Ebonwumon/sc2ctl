<?php

namespace SC2CTL\DotCom\EloquentModels;

class Permission extends BaseModel
{

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'role_id', 'id');
    }
}
