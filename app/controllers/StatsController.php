<?php

class StatsController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    public function allPlayedInTournament($id)
    {
        $tournament = Tournament::find($id);
        $arr = $tournament->teamsWithAllMembersPlaying();
        $tournament = Tournament::find($id);
        $arr = array_merge($arr, $tournament->teamsWithAllMembersPlaying());
        return View::make('stats/every_man_on_the_field', array('teams' => $arr));
    }

    public function highestMedianWR()
    {
        $arr = array();
        $max = 0;
        $winner = null;
        foreach (Team::all() as $team) {
            $wr = $team->getMedianWinrate();
            if ($wr > $max) {
                $max = $wr;
                $winner = $team;
            } else if ($max == $wr) {
            }
        }
        return View::make('stats/highest_median_winrate', array('winner' => $winner));
    }

    public function walkovers()
    {
        foreach (Tournament::all() as $tournament) {

        }
    }


}
