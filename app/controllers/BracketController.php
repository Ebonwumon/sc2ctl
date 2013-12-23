<?php

class BracketController extends \BaseController {

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
		$tournaments = Tournament::where('phase', '<=', 2)->get();
		$result = array();
		foreach ($tournaments as $tournament) {
			$result[$tournament->id] = $tournament->name;
		}

		return View::make('bracket/create', array('tournaments' => $result));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		dd(Input::get('test'));	
		// We assume the admin knows what they're doing for now
		$ro = Round::calculateRo(count(Input::get('position')));
			
		if (!$ro) {
			return View::make('bracket.create', array('error' => 'Participants must be 2<sup>x</sup>'));
		}
		$tournament = Tournament::find(Input::get('tournament_id'));
		$tournament->generateBracket(Input::get('position'));

		return Redirect::route('tournament.profile', $tournament->id);
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

	public function generateMatches($id) {
		$tournament = Tournament::find($id);
		$tournament->brackets->first()->generateMatches();

		return Redirect::route('tournament.profile', $tournament->id);
	}

}
