<?php

namespace SC2CTL\DotCom\Permissions;

use Auth;

trait IsUserTrait
{
    /**
     * Looks at the current authentication session, and returns if the current user matches the passed in User.
     *
     * @param \SC2CTL\DotCom\EloquentModels\User $user
     * @return bool
     */
    public function isUser(\SC2CTL\DotCom\EloquentModels\User $user) {
        return (Auth::check() && Auth::user()->id == $user->id);
    }

}