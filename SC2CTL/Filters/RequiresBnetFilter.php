<?php

namespace SC2CTL\DotCom\Filters;

use App;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\MessageBag;
use Redirect;
use SC2CTL\DotCom\EloquentModels\User;

class RequiresBnetFilter extends BeforeFilter
{

    /**
     * Perform the filtering of the route.
     *
     * Will let a user through iff they have a Battle.net account connected to their current user account.
     *
     * @param Route $route
     * @param Request $request
     * @param $value
     * @return Redirect|void
     */
    function filter(Route $route, Request $request, $value = null)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->hasConnectedBattleNet()) {
            return Redirect::route('user.show', $user->id)
                ->withErrors(new MessageBag([
                    "You need to associate a Battle.net account to do that."
                ]));
        }
    }
}
