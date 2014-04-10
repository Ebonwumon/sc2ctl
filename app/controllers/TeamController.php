<?php

class TeamController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$teams = Team::orderBy('name')->get();
		return View::make('team/index', array('teams' => $teams));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('team/create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
    $teamInput = Input::only(array('tag', 'name'));
    
    $v = Team::validate($teamInput);
    if (!$v->passes()) {
      return Redirect::route('team.create')->withInput()->withErrors($v);
    }
    try {
      $team = new Team;
      $team->fill($teamInput);
      $team->user_id = Sentry::getUser()->id;
      $team->description = "This team is really cool and loves both crayons and Starcraft";
      $team->save();
      
      $group = Sentry::findGroupById(Role::TEAM_OWNER);
      Sentry::getUser()->addGroup($group);
      $user = Sentry::getUser();
      $user->team_id = $team->id;
      $user->save();

      
      return Redirect::route('team.profile', $team->id);
    } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $ex) {
      $errors = array("Team Owner group not found. Please contact an adult");
      return Redirect::route('team.create')->withInput()->withErrors($errors);
    }
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$team = Team::find($id);
		
		if (Request::ajax()) {
			$response = ($team) ? $team->toArray() : array('name' => "Not Found");
			return Response::json($response);
		}

		return View::make('team/profile', array('team' => $team));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$team = Team::find($id);
		return View::make('team/profile', array('team' => $team, 'edit' => true));
	}


	public function editinfo($id) {
		$team = Team::find($id);
		return View::make('team/modify', array('team' => $team));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$team = Team::findOrFail($id);
    $inputArr = Input::only(array('description',
                                  'social_twitter',
                                  'social_fb',
                                  'social_twitch',
                                  'website'
          ));
    
    if (Input::has('name') && Input::get('name') != null) {
      if (Input::get('name') != $team->name) {
        $inputArr['name'] = Input::get('name');
      }
    }
    if (Input::has('tag') && Input::get('tag') != null) {
      if (Input::get('tag') != $team->tag) {
        $inputArr['tag'] = Input::get('tag');
      }
    }

    $v = Team::validate($inputArr);
    if (!$v->passes()) {
      return Redirect::route('team.editinfo', $team->id)->withInput()->withErrors($v);
    }
				
		if (Input::hasFile('team_banner_img')) {
			$file = Input::file('team_banner_img');
		
			$img = Image::make($file->getRealPath());
			$arr = explode(".", $file->getClientOriginalName());
			$ext = array_pop($arr);
			$img->resize(750, null, true);
			$img->crop(750, 170);
			$img->save('img/team/banner/tid_' . $id . "." . $ext);
			$team->banner_url =  "/img/team/banner/tid_" . $id . "." . $ext;
      $team->save();
		}

		if (Input::hasFile('team_logo_img')) {
      $file = Input::file('team_logo_img');
			$path = $file->getRealPath();
		
			$img = Image::make($path);
			$arr = explode(".", $file->getClientOriginalName());
			$ext = array_pop($arr);
			$img->resize(150, null, true);
			$img->crop(150,150);
      $path = 'img/team/logo/tid_' . $id . "." . $ext;
			$img->save($path);
			$team->logo_url =  "/" . $path;
      $team->save();
		}
    $team->fill($inputArr);
		$team->save();
		return Redirect::route('team.profile', $team->id);
	}
  
  public function delete($id) {
    $team = Team::findOrFail($id);

    return View::make('team/delete', array('team' => $team));
  }
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
    $team = Team::find($id);
    $members = $team->members;
   	$team->delete();
    
    foreach ($team->members as $member) {
      $member->team_id = 0;
      $member->save();
      $member->recalculateGroups();
    }

		return Redirect::action('TeamController@index');
	}

	public function add($id) {
    $team = Team::findOrFail($id);
    $user_id = Input::get('user_id');

    $user = User::findOrFail($user_id);
    if ($user->team_id) {
      $errors = array("That user is already on a team");
      return Redirect::route('team.edit', $team->id)->withErrors($errors);
    }

    $user->team_id = $id;
    $user->save();

		return Redirect::route('team.edit', $team->id);
  }

	public function remove($id) {
    $team = Team::findOrFail($id);
    $user_id = Input::get('user_id');
		
    $user = User::findOrFail($user_id);
    if (!$user->team_id || $user->team_id != $team->id) {
      $errors = array("User is not currently on this team");
      return Redirect::route('team.edit', $team->id)->withErrors($errors);
    }

    if ($team->user_id == $user->id) {
      $errors = array("Cannot remove the team owner");
      return Redirect::route('team.edit', $team->id)->withErrors($errors);
    }
    foreach ($user->lineups as $lineup) {
      $lineup->remove($user->id);
    }
		
    $user->team_id = 0;
		$user->save();

		return Redirect::route('team.edit', $team->id);
  }

	public function search($term) {
		$teams = Team::where(DB::raw('LOWER(name)'), 'LIKE', '%' . strtolower($term) . '%');
		
		$teams = $teams->get();
		return View::make('team/multipleCardPartial', array('teams' => $teams));

	}

}
