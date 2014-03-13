<?php

class RosterController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id)
	{
    $tournament = Tournament::findOrFail($id);
    $lineups = Sentry::getUser()->lineupsForTournament($id)->get();

    return View::make('roster.index', array('lineups' => $lineups, 'tournament' => $tournament));	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($match_id, $lineup_id)
	{
    $match = Match::findOrFail($match_id);
    $lineup = Lineup::findOrFail($lineup_id);
    return View::make('roster/create', array('match' => $match, 'lineup' => $lineup));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $user_ids = Input::get('user_id');
    $match_id = Input::get('match_id');
    $lineup_id = Input::get('lineup_id');
    $confirmed = (Input::get('confirmed') != null);

    if (count(array_unique($user_ids)) < count($user_ids)) {
      $errors = array("You are not allowed to play the same player twice");
      return Redirect::route('roster.create', array('match_id' => $match_id, 
                                                    'lineup_id' => $lineup_id))
          ->withInput()->withErrors($errors);
    }
	  dd(Input::all());	
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
