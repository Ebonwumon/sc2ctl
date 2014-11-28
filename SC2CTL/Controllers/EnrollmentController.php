<?php

namespace SC2CTL\DotCom\Controllers;

class EnrollmentController {

    public function add($id)
    {
        $team = Team::findOrFail($id);
        $user_id = Input::get('user_id');

        $user = User::findOrFail($user_id);
        if ($user->team_id) {
            $errors = array("That user is already on a team");
            return Redirect::route('team.edit', $team->id)->withErrors($errors);
        }

        $user->team_id = $id;
        $user->save();

        return Redirect::route('team.edit', $team->id);
    }

    public function remove($id)
    {
        $team = Team::findOrFail($id);
        $user_id = Input::get('user_id');

        $user = User::findOrFail($user_id);
        if (!$user->team_id || $user->team_id != $team->id) {
            $errors = array("User is not currently on this team");
            return Redirect::route('team.edit', $team->id)->withErrors($errors);
        }

        if ($team->user_id == $user->id) {
            $errors = array("Cannot remove the team owner");
            return Redirect::route('team.edit', $team->id)->withErrors($errors);
        }
        foreach ($user->lineups as $lineup) {
            $lineup->remove($user->id);
        }

        $user->team_id = 0;
        $user->save();

        return Redirect::route('team.edit', $team->id);
    }
} 