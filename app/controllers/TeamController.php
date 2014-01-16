<?php

class TeamController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$teams = Team::all();
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
		// Todo model validation
    $team = new Team;
    $team->tag = Input::get('tag');
    $team->name = Input::get('name');
    $team->user_id = Sentry::getUser()->id;
		$team->description = "This team is really cool and loves both crayons and Starcraft";
		$team->save();
		
    return Redirect::action('TeamController@index');
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
		$team = Team::find($id);
		$team->description = Input::get('description');
		$team->social_twitter = Input::get('social_twitter');
		$team->social_fb = Input::get('social_fb');
		$team->social_twitch = Input::get('social_twitch');
		$team->website = Input::get('website');
		
		if (Input::hasFile('team_banner_img')) {
			$file = Input::file('team_banner_img');
			$path = $file->getRealPath();
		
			$img = Image::make($path);
			$arr = explode(".", $file->getClientOriginalName());
			$ext = array_pop($arr);
			$img->resize(750, null, true);
			$img->crop(750, 170);
			$img->save('img/team/banner/tid_' . $id . "." . $ext);
			$team->banner_url =  "/img/team/banner/tid_" . $id . "." . $ext;
		}
		if (Input::hasFile('team_logo_img')) {
			$file = Input::file('team_logo_img');
			$path = $file->getRealPath();
		
			$img = Image::make($path);
			$arr = explode(".", $file->getClientOriginalName());
			$ext = array_pop($arr);
			$img->resize(150, null, true);
			$img->crop(150,150);
			$img->save('img/team/logo/tid_' . $id . "." . $ext);
			$team->logo_url =  "/img/team/logo/tid_" . $id . "." . $ext;
		}

		$team->save();
		return Redirect::route('team.profile', $team->id);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Team::destroy($id);

		return Redirect::action('TeamController@index');
	}

	public function add($id) {
		foreach (Input::get("ids") as $uid) {
			$user = User::find($uid);

			$user->team_id = $id;
			$user->save();
		}
		return Response::json(array('success' => 1));
	}

	public function addcontact($id) {
		$team = Team::find($id);

		$team->contact = Input::get('id');

		$team->save();

		$user = User::find(Input::get('id'));
		return View::make('user/profileCardPartial', array('team' => $team, 'member' => $user));
	}

	public function addleader($id) {
		$team = Team::find($id);
		
		$former = User::find($team->leader);
		$former->detachRole(ROLE_TEAM_CAPTAIN);

		$team->leader = Input::get('id');

		$team->save();

		$user = User::find(Input::get('id'));
		$user->attachRole(ROLE_TEAM_CAPTAIN);
		return View::make('user/profileCardPartial', array('team' => $team, 'member' => $user));
	}

	public function evict() {
		$user = User::find(Input::get('id'));
		$user->team_id = 0;
		$user->save();

		return Response::json(array('status' => 0));
	}

	public function search($term) {
		$teams = Team::where(DB::raw('LOWER(name)'), 'LIKE', '%' . strtolower($term) . '%');
		
		$teams = $teams->get();
		return View::make('team/multipleCardPartial', array('teams' => $teams));

	}

}
