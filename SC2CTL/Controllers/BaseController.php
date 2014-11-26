<?php

namespace SC2CTL\DotCom\Controllers;

use Depotwarehouse\Toolbox\DataManagement\Repositories\BaseRepositoryInterface;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    /** @var  BaseRepositoryInterface */
    protected $repository;

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = \View::make($this->layout);
        }
    }
}
