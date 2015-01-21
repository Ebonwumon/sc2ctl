<?php

namespace SC2CTL\DotCom\EloquentModels;

class Permission extends BaseModel
{

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [ self::FILLABLE ],
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'role_id', 'id');
    }
}
