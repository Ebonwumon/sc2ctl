<?php

class GroupController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$groups = Group::all();
		return View::make('group/index', array('groups' => $groups));	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$tournaments = Tournament::where('phase', '<', 2)->get();
		$result = array();
		foreach ($tournaments as $tournament) {
			$result[$tournament->id] = $tournament->name;
		}
		return View::make('group/create', array('tournaments' => $result));	
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$group = Group::create(Input::all());
		$team_ids = array();
		for ($i = 1; $i < 5; $i++) {
			if (Input::has("team" . $i)) {
				$team_ids[] = Input::get("team" . $i);
			}
		}
		$group->teams()->sync($team_ids);

		return Redirect::route('group.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$group = Group::find($id);

		return View::make('group/profile', array('group' => $group));
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

	public function generatematch($id) {
		$group = Group::find($id);
		$group->generateMatch();

		return Redirect::route('group.index');
	}

}
