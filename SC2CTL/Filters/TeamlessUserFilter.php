<?php

namespace SC2CTL\DotCom\Filters;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Redirect;
use SC2CTL\DotCom\EloquentModels\User;
use SC2CTL\DotCom\Exceptions\MustBeTeamlessException;

class TeamlessUserFilter extends BeforeFilter
{

    /**
     * Perform the filtering of the route.
     *
     * Will allow a user through iff they currently are not enrolled on any team.
     *
     * @param Route $route
     * @param Request $request
     * @param $value
     * @throws MustBeTeamlessException
     * @return Redirect|void
     */
    function filter(Route $route, Request $request, $value = null)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->currentlyOnATeam()) {
            throw new MustBeTeamlessException();
        }
    }
}