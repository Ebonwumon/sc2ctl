<?php

class GameController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('game/create');	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$team = Team::find(Input::get('team'));

		$game = new Game;
		$game->player1 = $team->leader;
		$game->player2 = $team->leader;
		$game->save();
		return Redirect::route('game.profile', $game->id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$game = Game::find($id);

		return View::make('game/profile', array('game' => $game));
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
		$game = Game::find($id);

		if (Input::has('player1')) {
			$game->player1 = Input::get('player1');
			$game->save();
		}
		if (Input::has('player2')) {
			$game->player2 = Input::get('player2');
		}
		if (Input::has('winner')) {
			$game->reportWinner(Input::get("winner"));
		}
		if (Input::has('replay_url')) {
			$game->replay_url = Input::get('replay_url');
		}
		$game->save();

		if (Request::ajax()) {
			return Response::json(array('status' => 0, 'message' => 'Game updated, friend'));
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

	public function report($id) {
		$game = Game::findOrFail($id);
    if (!Input::has('winner') || Input::get('winner') == null) {
      $errors = array('You must select a winner');
      return Redirect::route('match.report', $game->match->id)->withErrors($errors);
    }

    if (Input::has('is_default') && Input::get('is_default') != null) {
      $game->is_default = true;
      $game->save();
    }

    if (Input::has('loser') && Input::get('loser') != null) {
      if (Input::get('winner') == Input::get('loser')) {
        $errors = array("The winner and loser cannot be the same");
        return Redirect::route('match.report', $game->match->id)->withErrors($errors);
      }

      // Assumption, a user can only be a on a single lineup
      $winner = User::findOrFail(Input::get('winner'));
      $loser = User::findOrFail(Input::get('loser'));
      if ($winner->lineups->first()->id == $loser->lineups->first()->id) {
        $errors = array("The winner and loser cannot be on the same Lineup");
        return Redirect::route('match.report', $game->match->id)->withErrors($errors);
      }

      $game->match->registerAce($winner, $loser);
    }
		$game->reportWinner(Input::get('winner'));
		
	  return Redirect::route('match.report', $game->match->id);
  }

}
