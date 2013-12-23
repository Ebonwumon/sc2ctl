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
		$game = Game::find($id);
		$game->reportWinner(Input::get('winner'));
		
		return Response::json(array('status' => 0));
	}

}
