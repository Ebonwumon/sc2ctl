<?php

namespace SC2CTL\DotCom\ViewComposers;

use Auth;
use Illuminate\View\View;
use SC2CTL\DotCom\Permissions\IsUserTrait;
use URL;

class UserShowComposer extends Composer {

    use IsUserTrait;

    /**
     * Handles the content of the view and composes any required data.
     *
     * @param View $view
     * @return mixed
     */
    function compose(View $view)
    {
        $page_actions = [];

        if ($this->isUser($view['user'])) {
            $page_actions[] = [
                'name' => 'Edit Profile',
                'url' => URL::route('user.edit', $view['user']->id)
            ];
        }

        if (count($page_actions) > 0) {
            $view->with('page_actions', $page_actions);
        }
    }
}