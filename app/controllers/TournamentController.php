<?php

class TournamentController extends \BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tournaments = Tournament::all()->groupBy('season_id');

        return View::make('tournament/index', array('tournaments' => $tournaments));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View::make("tournament/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        // Todo make this safe
        $tournament = Tournament::create(Input::all());

        return Redirect::route('tournament.index');
    }

    public function store_season()
    {
        // Todo make this safe
        Season::create(Input::all());
        return Redirect::route('tournament.create');
    }

    public function show($id, $phase = false)
    {
        /** @var $tournament Tournament */
        $tournament = Tournament::find($id);
        $phase = ($phase) ? $phase : $tournament->phase;
        $summary = array();

        switch ($phase) {
            case 0:
                $data = $tournament->teams;
                break;
            case 1:
                $data = $tournament->currentRound;
                $summary = $tournament->getRoundStandings();
                break;
        }

        return View::make('tournament/profile', array('tournament' => $tournament,
            'data' => $data,
            'phase' => $phase,
            'summary' => $summary));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var $tournament Tournament */
        $tournament = Tournament::findOrFail($id);
        return View::make('tournament/edit', array('tournament' => $tournament));
    }

    public function start($id)
    {
        /** @var $tournament Tournament */
        $tournament = Tournament::findOrFail($id);
        $due_date = Input::get('due_date');

        if ($due_date == null) {
            $errors = array("You did not provide a due date for the first week of matches");
            return Redirect::route('tournament.edit', $tournament->id)->withErrors($errors);
        }

        if (strtotime($due_date) === FALSE) {
            $errors = array("We could not interpret your entry as a date");
            return Redirect::route('tournament.edit', $tournament->id)->withErrors($errors);
        }

        $tournament->initial_swiss_round($due_date);

        return Redirect::route('tournament.profile', $tournament->id);
    }

    public function update($id)
    {
        $tournament = Tournament::find($id);
        $tournament->phase = Input::get('phase');
        $tournament->name = Input::get('name');
        $tournament->save();
        return Redirect::route('tournament.profile', $tournament->id);
    }

    public function register($id)
    {
        $tournament = Tournament::find($id);

        $lineup_id = Input::get('lineup_id');
        if ($lineup_id == null) {
            $errors = array("You did not provide a lineup to remove");
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }

        $lineup = Lineup::findOrFail($lineup_id);

        if (!$lineup->canRegister(Sentry::getUser())) {
            $errors = array('You do not have authorization to register that lineup in this tournament');
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }
        if ($tournament->teams->contains($lineup_id)) {
            $errors = array("That lineup is already registered for this tournament!");
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }

        if ($lineup->anyRegistration()) {
            $errors = array("That lineup is already registered in another tournament this season");
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }
        $tournament->teams()->attach($lineup_id);

        return Redirect::route('tournament.profile', $tournament->id);
    }

    public function leave($id)
    {
        $tournament = Tournament::find($id);

        $lineup_id = Input::get('lineup_id');
        if ($lineup_id == null) {
            $errors = array("You did not provide a lineup to remove");
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }

        $lineup = Lineup::findOrFail($lineup_id);

        if (!$lineup->canRegister(Sentry::getUser())) {
            $errors = array('You do not have authorization to remove that lineup from this tournament');
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }

        if (!$tournament->teams->contains($lineup_id)) {
            $errors = array("That lineup isn't registered for this tournament!");
            return Redirect::route('tournament.profile', $tournament->id)->withErrors($errors);
        }

        $tournament->teams()->detach($lineup_id);

        return Redirect::route('tournament.profile', $tournament->id);
    }

}
