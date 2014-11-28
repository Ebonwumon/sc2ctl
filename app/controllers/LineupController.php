<?php
use SC2CTL\DotCom\EloquentModels\Role;

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
    $available_players = $team->availablePlayers()->lists('qualified_name', 'id');
   	return View::make('team/lineup/create', array('team' => $team, 'available_players' => $available_players));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
    $users = array();
    if (!Input::has('users') || count(Input::get('users')) == 0) {
      $errors = "You must select at least one user for your lineup";
      return Redirect::route('lineup.create', $id)->withInput()->withErrors($errors);
    }
    
    $v = Lineup::validate(Input::only('name'));
    if (!$v->passes()) {
      return Redirect::route('lineup.create', $id)->withInput()->withErrors($v);
    }

    foreach (Input::get('users') as $userID) {
      $user = User::findOrFail($userID);
      if ($user->lineups->count() > 0) {
        $errors = "User " . $user->qualified_name . " is already registered on another Lineup.";
        return Redirect::route('lineup.create', $id)->withInput()->withErrors($errors);
      }
      $users[] = $user;
    }

		$lineup = new Lineup;
		$lineup->team_id = $id;
		$lineup->name = Input::get('name');
		$lineup->save();

		foreach ($users as $user) {
			$lineup->players()->attach($user->id, array('role_id' => Role::MEMBER));
      $user->recalculateGroups();
		}
		return Redirect::route('team.edit', $id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
    $lineup = Lineup::findOrFail($id);
    
	  if (Request::ajax()) {
      return View::make('team/lineupPartial', array('lineup' => $lineup));
    }
    return Redirect::route('home');
	}

  public function matches($id) {
    $lineup = Lineup::findOrFail($id);
    
    $matches = array();
    
    $i = 0;
    foreach ($lineup->tournaments as $tournament) {
      $curMatches = array();
      foreach ($tournament->swissRounds as $round) {
        $curMatches[] = $round->matchForLineup($id);
      }

      $matches[$i]['tournament'] = $tournament;
      $matches[$i]['matches'] = $curMatches;
    }
    return View::make('team/lineup/matches', array('matches' => $matches, 'lineup' => $lineup));
  }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
    	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
    $lineup = Lineup::findOrFail($id);
	  $inputArr = array();
    if (Input::has('name')) {
      $name = Input::get('name');
      if ($name != null && $name != $lineup->name) {
        $inputArr['name'] = $name;
      }
    }

    $v = Lineup::validate($inputArr);

    if (!$v->passes()) {
      return Redirect::route('team.show', $lineup->team->id)->withErrors($v);
    }
    
    $lineup->fill($inputArr);
    $lineup->save();

	  return Redirect::route('team.show', $lineup->team->id);
  }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
    $lineup = Lineup::findOrFail($id);
    $team_id = $lineup->team->id;
    $users = $lineup->players;
    foreach ($users as $user) {
      $lineup->remove($user->id);
    }
    Lineup::destroy($id);
    return Redirect::route('team.edit', $team_id);
  }

	public function change_rank($id) {
		$lineup = Lineup::findOrFail($id);
    $user_id = Input::get('user_id');
    $user = User::findOrFail($user_id);

		$entry = $lineup->players()->where('user_id', '=', $user_id)
                                ->where('lineup_id', '=', $id)->get()[0]; // Lets hope to hell this doesn't fail
		$entry->pivot->role_id = Input::get('role_id');
		$entry->pivot->save();
    
    $user->recalculateGroups(); 

		return Response::json(array('status' => 0));
	}

	public function add_user($id) {
		$lineup = Lineup::find($id);

		$uid = Input::get('user_id');

		if ($lineup->historicalPlayers->contains($uid)) {
			$entry = $lineup->historicalPlayers()->where('user_id', '=', $uid)->get()[0];
      $entry->restore();
			$entry->pivot->role_id = Role::MEMBER;
			$entry->pivot->save();
			
      if (Request::ajax()) {
        return Response::json(array('status' => 0));
      }

      return Redirect::route('team.edit', $lineup->team->id);
		}
		
		$lineup->players()->attach($uid, array('role_id' => Role::MEMBER));
		
    if (Request::ajax()) {
      return Response::json(array('status' => 0));
    }

    return Redirect::route('team.edit', $lineup->team->id);
	}

	public function remove_user($id) {
		$lineup = Lineup::find($id);
    try {
      $lineup->remove(Input::get('user_id'));
    } catch (Exception $ex) {
      return Response::json(array('status' => 1, 'message' => $ex->getMessage()));
    }
		return Response::json(array('status' => 0));
	}

}
