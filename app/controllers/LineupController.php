<?php
class LineupController extends \BaseController {

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
	public function create($id)
	{
		$team = Team::find($id);
		return View::make('team/lineup/create', array('team' => $team));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		$lineup = new Lineup;
		$lineup->team_id = $id;
		$lineup->name = Input::get('name');
		$lineup->save();
		foreach (Input::get('users') as $userID) {
			$lineup->players()->attach($userID, array('active' => true));
		}
		return Redirect::route('team.profile', $id);
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

	public function change_rank($id) {
		$lineup = Lineup::find($id);

		$entry = $lineup->players()->where('user_id', '=', Input::get('user_id'))->where('lineup_id', '=', $id)->get()[0]; // Lets hope to hell this doesn't fail
		$entry->pivot->role_id = Input::get('role_id');
		$entry->pivot->save();
		return Response::json(array('status' => 0));
	}

	public function add_user($id) {
		$lineup = Lineup::find($id);

		$uid = Input::get('user_id');

		if ($lineup->historicalPlayers->contains($uid)) {
			$entry = $lineup->historicalPlayers()->where('user_id', '=', $uid)->get()[0];
			$entry->pivot->active = true;
			$entry->pivot->role_id = Role::MEMBER;
			$entry->pivot->save();
			return Response::json(array('status' => 0));
		}
		
		$lineup->players()->attach($uid);
		return Response::json(array('status' => 0));

	}

	public function remove_user($id) {
		$lineup = Lineup::find($id);
		$entry = $lineup->players()->where('user_id', '=', Input::get('user_id'))->get()[0];

		$entry->pivot->active = false;
		$entry->pivot->role_id = Role::NULL_ROLE;
		$entry->pivot->save();

		return Response::json(array('status' => 0));
	}

}
