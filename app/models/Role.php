<?php

class Role
{
    const CAPTAIN = 6;
    const OFFICER = 7;
    const MEMBER = 8;
    const TEAM_OWNER = 5;

    public static function recalculateRolesForUser($user)
    {
        $groups = $user->getGroups();
    }

    public static function find($id)
    {
        try {
            return Sentry::findGroupById($id)->name;
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $exception) {
            return "Unknown Role";
        }
    }
}
