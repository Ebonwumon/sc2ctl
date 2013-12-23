<?php

class StatsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			
	}

	public function allPlayedInTournament($id) {
		$tournament = Tournament::find($id);
		$arr = $tournament->teamsWithAllMembersPlaying();
		$tournament = Tournament::find($id);
		$arr = array_merge($arr, $tournament->teamsWithAllMembersPlaying());
		return View::make('stats/every_man_on_the_field', array('teams' => $arr));
	}
	public function highestMedianWR() {
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
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
