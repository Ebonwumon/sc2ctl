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
		return View::make('match/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$match = Match::make(Input::all());
		//should be refactored to generate games
		/*for ($i = 0; $i < $match->bo; $i++) {
			$game = new Game;
			$game->player1 = $match->team1->leader;
			$game->player2 = $match->team2->leader;
			$game->winner = 0;
		}*/

		$match->generateGames();
		return "done";
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$match = Match::find($id);
		
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
		return View::make('match/edit', array('match' => $match, 'teams' => $teams));	
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
