<?php

namespace SC2CTL\DotCom\ViewComposers;

use Illuminate\View\View;
use SC2CTL\DotCom\EloquentModels\Team;
use SC2CTL\DotCom\Permissions\IsUserTrait;
use URL;

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
        $page_actions = [];

        /** @var Team $team */
        $team = $view['team'];

        if ($this->isUser($team->getOwner())) {
            //TODO maybe there are other permissions to do this.
            $page_actions[] = [
                'name' => "Edit Info",
                'url' => URL::route('team.edit', $team->id)
            ];
        }

        if (count($page_actions) > 0) {
            $view->with('page_actions', $page_actions);
        }
    }
}
