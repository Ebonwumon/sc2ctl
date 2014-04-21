<?php

class MatchController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('match/index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$select = Lineup::get()->lists('qualified_name', 'id');
    return View::make('match/create', array('teams' => $select));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $match = new Match;

    $match->bo = Input::get('bo');
    $match->swiss_round_id = Input::get('swiss_round_id');
    $match->is_default = false;

    $match->save();
    $match->teams()->sync(Input::get('teams'));
    if (count(Input::get('teams')) > 1) {
      $match->generateGames();
    } else {
      $match->is_default = Input::get('teams')[0];
      $match->save();
    }

    return Redirect::route('match.edit', $match->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$match = Match::findOrFail($id);
		
		return View::make('match/profile', array('match' => $match));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$match = Match::find($id);
		$teams = $match->teams()->get();
    $team1Players = $teams[0]->playerSelect();
    $team1Players[0] = "Ace Player";
    $team2Players = $teams[1]->playerSelect();
    $team2Players[0] = "Ace Player";
		return View::make('match/edit', array(
          'match' => $match, 
          'teams' => $teams,
          'team1Players' => $team1Players,
          'team2Players' => $team2Players
       ));	
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$match = Match::find($id);
		
		if (Input::has('bo')) {
			$match->bo = Input::get('bo');
		}
		if (Input::has('doodle_id')) {
			$match->doodle_id = Input::get('doodle_id');
		}

		$match->save();
    if (Input::has('team1Players') && Input::has('team2Players')) {
      $match->generateGames(Input::get('team1Players'), Input::get('team2Players'));
    }
		if (Input::has('team1') && Input::has('team2')) {
			$match->teams()->sync(array(Input::get('team1'), Input::get('team2')));
		}

		if (Input::has('return_url')) {
			return Redirect::to(Input::get('return_url'));
		} else {
			return Redirect::route('match.profile', $match->id);
		}
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

  public function report($id, $override = false) {
    $override = ($override === 'true');
    
    $match = Match::findOrFail($id);
    $lineups = $match->teams;
    
    foreach ($lineups as $lineup) {
      if (Sentry::getUser()->hasAccess('override_roster_create') && $override) continue;
      if (!$lineup->canCreateRoster(Sentry::getUser())) continue;

      $roster_status = $match->rosterStatus($lineup->id);
      if ($roster_status == Roster::STATUS_UNSTARTED) {
        return Redirect::route('roster.create', array('match_id' => $match->id, 
                                                      'lineup_id' => $lineup->id))
                              ->withErrors(array("You must create a roster for this match first"));
      }

      if ($roster_status == Roster::STATUS_UNCONFIRMED) {
        return Redirect::route('roster.edit', Roster::getIdFromMatchLineup($match->id, $lineup->id))
                              ->withErrors(array("You must confirm this roster first"));

      }
    }
    
    return View::make('match/report', array('match' => $match));
  }

  public function report_default($id) {
    $match = Match::findOrFail($id);
    $winner = Input::get('winner');
    
    if ($winner == null) {
      $errors = array('You did not select a winning lineup');
      return Redirect::route('match.report', array('id' => $match->id, 'override' => 'true'))->withErrors($errors);
    }
    
    // Type cast the string to an int, for use with the type-hinted report_default on match.
    $winner = (int) $winner;
    try {
      $match->report_default($winner);
    } catch (Exception $ex) {
      Log::error($ex);
      $errors = array('There was an error setting the match as a default win');
      return Redirect::route('match.report', array('id' => $match->id, 'override' => 'true'))->withErrors($errors);
    }
    return Redirect::route('match.profile', $match->id);
  }
	
	public function wizard($id, $gno = 1) {
		$match = Match::find($id);
		$game = $match->games[$gno - 1];	
		$teams = $match->teams()->get();
		$maps = Map::all()->toArray();
		$maps = array_combine(array_pluck($maps, 'id'), array_pluck($maps, 'name'));
		asort($maps);

		$composer = array('team1' => $teams->first(),
		                  'team2' => $teams->last(),
						  'game' => $game,
						  'maps' => $maps,
						  'gno' => $gno,
						  'match' => $match);
		if (Request::ajax()) {
			return View::make('match/wizard/override', $composer);
		}
		return View::make('match/wizard', $composer);
	}

	public function nextgame($id, $gno = 1) {
		$match = Match::find($id);
		if ($match->won()) {
			return Redirect::route('match.landing', $match->id);
		} else {
			return Redirect::route('match.wizard', array($match->id, $gno + 1));
		}
	}

	public function landing($id) {
		$match = Match::find($id);
		if (!$match->won()) {
			return Redirect::route('match.profile', $match->id);
		}
		$winner = Team::find($match->won());

		return View::make('match/landing', array('match' => $match, 'winner' => $winner));
	}

	public function won($id) {
		$match = Match::find($id);
		$won = $match->won();
		return Response::json(array('won' => $won));
	}
}
