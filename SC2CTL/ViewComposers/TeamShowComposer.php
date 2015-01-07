<?php

namespace SC2CTL\DotCom\ViewComposers;

use Illuminate\View\View;
use SC2CTL\DotCom\EloquentModels\Team;
use SC2CTL\DotCom\Permissions\IsUserTrait;

class TeamShowComposer extends Composer {

    use IsUserTrait;

    /**
     * Handles the content of the view and composes any required data.
     *
     * @param View $view
     * @return mixed
     */
    function compose(View $view)
    {
        /** @var Team $team */
        $team = $view['team'];

        if ($this->isUser($team->getOwner())) {
            if (!$user->hasConnectedBattleNet()) {
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