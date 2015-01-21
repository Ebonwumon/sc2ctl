<?php

namespace SC2CTL\DotCom\Filters;

use App;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Redirect;
use SC2CTL\DotCom\Roles\Calculator;

class RequiresTeamPermission extends BeforeFilter {

    /**
     * Perform the filtering of the route.
     *
     * @param Route $route
     * @param Request $request
     * @param string $value The current permission to check against. Takes the form of comma-separated permissions.
     * @return Redirect|void
     */
    function filter(Route $route, Request $request, $value = null)
    {
        $permissions = explode(",", $value);
        $calculator = new Calculator(Auth::user());
        foreach ($permissions as $permission) {
            if (!$calculator->canTeamPermission($permission)) {
                return App::abort(401, "You do not have the Team Permission to do that");
            }
        }

    }
}
