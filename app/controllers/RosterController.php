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
    $match = Match::findOrFail($match_id);

    if (count(array_unique($user_ids)) < count($user_ids)) {
      $errors = array("You are not allowed to play the same player twice");
      return Redirect::route('roster.create', array('match_id' => $match_id, 
                                                    'lineup_id' => $lineup_id))
          ->withInput()->withErrors($errors);
    }
   
    $roster = new Roster;
    $roster->match_id = $match_id;
    $roster->lineup_id = $lineup_id;
    $roster->confirmed = $confirmed;
    $roster->save();

    $i = 1;
    foreach ($user_ids as $user_id) {
      $entry = new RosterEntry;
      $entry->player_id = $user_id;
      $entry->map = $i;
      $entry->roster_id = $roster->id;
      $entry->save();

      $i++;
    }
    return Redirect::route('roster.index', $match->tournament->id); 
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
	  $roster = Roster::findOrFail($id);
    if ($roster->confirmed) {
      $errors = array("You cannot edit a confirmed roster");
      return Redirect::route('roster.index', $roster->match->tournament->id)->withErrors($errors);
    }
    $player_list = array();
    foreach ($roster->entries as $entry) {
      $player_list[$entry->player->id] = $entry->player->qualified_name;
    }
    if (count($player_list) == 0) {
      $player_list = $roster->lineup->players->lists('qualified_name', 'id');
    }
    return View::make('roster/edit', array('roster' => $roster, 'player_list' => $player_list));
  }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
    $roster = Roster::findOrFail($id);
    if ($roster->confirmed) {
      $errors = array("You cannot edit a confirmed roster");
      return Redirect::route('roster.index', $roster->match->tournament->id)->withErrors($errors);
    }
    $user_ids = Input::get('user_id');

    if (count(array_unique($user_ids)) < count($user_ids)) {
      $errors = array("You are not allowed to play the same player twice");
      return Redirect::route('roster.edit', $roster->id)->withErrors($errors);
    }
   
    $i = 0;
    foreach ($roster->entries as $entry) {
      $entry->player_id = $user_ids[$i];
      $entry->save();
      $i++;
    }
    $roster->confirmed = (Input::get('confirmed') != null);
    $roster->save();

    return Redirect::route('match.profile', $roster->match_id);
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
