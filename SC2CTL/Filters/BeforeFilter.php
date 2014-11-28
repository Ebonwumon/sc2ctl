<?php

namespace SC2CTL\DotCom\Filters;

use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Redirect;

abstract class BeforeFilter
{
    /**
     * Perform the filtering of the route.
     *
     * @param Route $route
     * @param Request $request
     * @param $value
     * @return Redirect|void
     */
    abstract function filter(Route $route, Request $request, $value = null);
} 