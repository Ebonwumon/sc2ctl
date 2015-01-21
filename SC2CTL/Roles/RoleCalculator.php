<?php

namespace SC2CTL\DotCom\Roles;

use SC2CTL\DotCom\EloquentModels\BaseModel;
use SC2CTL\DotCom\EloquentModels\User;

interface RoleCalculator
{
    public function getGlobalRoles(User $user);

    public function getScopedRoles(BaseModel $scope, User $user);

    public function canGlobal(User $user);

    public function canScoped(BaseModel $scope, User $user, $scoped_id);
}
