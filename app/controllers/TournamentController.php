<?php

class TournamentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$tournaments = Tournament::all();

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
		$tournament = Tournament::create(Input::all());

		return Redirect::route('tournament.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id, $phase = false)
	{
		$tournament = Tournament::find($id);
		$phase = ($phase) ? $phase : $tournament->phase;
		if ($tournament->phase <= 3) {
			$data = $tournament->filterPhase($tournament->groups()->get(), $phase);
		} else {
			$data = array(); //TODO MAKE BRACKETS
		}
		
		return View::make('tournament/profile', array('tournament' => $tournament, 'data' => $data, 'phase' => $phase));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$tournament = Tournament::find($id);

		return View::make('tournament/edit', array('tournament' => $tournament));
	}
	
	public function groups($id) {
		$tournament = Tournament::find($id);
		$groups = $tournament->groups;

		return View::make('group.index', array('groups' => $groups));
	}
	
	public function round($id) {
		$tournament = Tournament::find($id);
		$rounds = $tournament->rounds;

		return View::make('round/index', array('tournament' => $tournament));
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$tournament = Tournament::find($id);
		$tournament->phase = Input::get('phase');
		$tournament->name = Input::get('name');
		$tournament->save();
		return Redirect::route('tournament.profile', $tournament->id);
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

	public function register($id) {
		$tournament = Tournament::find($id);

		$tournament->teams()->attach(Auth::user()->team_id);

		return Redirect::route('tournament.profile', $tournament->id);
	}

	public function leave($id) {
		$tournament = Tournament::find($id);

		$tournament->teams()->detach(Auth::user()->team_id);

		return Redirect::route('tournament.profile', $tournament->id);
	}

	public function removeTeam($id) {
		$tournament = Tournament::find($id);

		$tournament->teams()->detach(Input::get('team_id'));

		return Redirect::route('tournament.profile', $tournament->id);
	}

	public function addteam($id) {
		$tournament = Tournament::find($id);

		$tournament->teams()->attach(Input::get('team_id'));
		
		return Redirect::route('tournament.edit', $tournament->id);
	}

	public function generateGroups($id) {
		$tournament = Tournament::find($id);

		$tournament->generateGroups();

		return Redirect::route('tournament.profile', $tournament->id);
	}


}
