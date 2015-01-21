<?php

namespace SC2CTL\DotCom\Roles;

use Illuminate\Database\Eloquent\Collection;
use SC2CTL\DotCom\EloquentModels\BaseModel;
use SC2CTL\DotCom\EloquentModels\Role;
use SC2CTL\DotCom\EloquentModels\User;

class Calculator
{

    /** @var User  */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get a list of the global roles for the user.
     *
     * @param User $user
     * @return \Illuminate\Support\Collection
     */
    public static function getGlobalRoles(User $user)
    {
        return $user->roles()->get()->toBase();
    }


    /**
     * Checks the global permissions to see if the user can perform the specific permission
     *
     * @param $permission
     * @return bool
     */
    public function canGlobalPermission($permission)
    {
        /** @var Collection $roles */
        $roles = $this->user->roles;

        return $roles->toBase()->contains($this->roleHasPermission($permission));
    }

    /**
     * Get a closure that takes a Role argument, and will return whether that role contains $permission.
     *
     * @param $permission
     * @return callable
     */
    private function roleHasPermission($permission) {
        return function(Role $role) use ($permission) {
            return $role->permissions()->contains($permission);
        };
    }

    /**
     * Checks if the current permission is available on the user's current team enrollments.
     *
     * Will check global permissions first - global permissions short-circuit. If they're true, this will be too.
     * @param $permission
     * @return bool
     */
    public function canTeamPermission($permission)
    {
        if ($this->canGlobalPermission($permission)) {
            return true;
        }

        // A user without a team cannot have a team permission.
        if (!$this->user->hasTeam()) {
            return false;
        }

        /** @var Role $role */
        $role = $this->user->getTeam()->pivot->role;

        $func = $this->roleHasPermission($permission);
        return $func($role);

    }

}
