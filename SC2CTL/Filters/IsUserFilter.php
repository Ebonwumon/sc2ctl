<?php

namespace SC2CTL\DotCom\Filters;

use App;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Redirect;

class IsUserFilter extends BeforeFilter {

    /**
     * Perform the filtering of the route.
     *
     * Will be permitted iff the user is the same user as the one loaded on the page or the user has the edit_profiles
     * permission.
     *
     * @param Route $route
     * @param Request $request
     * @param $value
     * @return Redirect|void
     */
    function filter(Route $route, Request $request, $value = null)
    {
        // TODO check for edit_profiles permission
        if (Auth::user()->id != $route->getParameter('id')) {
            App::abort('401', "You are not authorized to access that resource");
        }

    }
}