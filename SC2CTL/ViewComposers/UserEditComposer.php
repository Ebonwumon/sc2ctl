<?php

namespace SC2CTL\DotCom\ViewComposers;

use Illuminate\View\View;
use SC2CTL\DotCom\EloquentModels\User;
use SC2CTL\DotCom\Permissions\IsUserTrait;
use URL;

class UserEditComposer extends Composer {
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

        /** @var User $user */
        $user = $view['user'];
        if ($this->isUser($user)) {
            if ($user->hasConnectedBattleNet()) {
                $page_actions[] = [
                    'name' => 'Remove B.Net',
                    'url' => URL::route('bnet.disconnect')
                ];
            } else {
                $page_actions[] = [
                    'name' => 'Connect B.Net',
                    'url' => URL::route('bnet.connect')
                ];
            }

        }

        if (count($page_actions) > 0) {
            $view->with('page_actions', $page_actions);
        }
    }
}
