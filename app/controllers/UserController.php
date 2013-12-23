<?php

class UserController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $users = User::all();
		return View::make('user/index', array('users' => $users));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('user/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $user = User::create(Input::all());

        $user->save();
		Session::forget('email');
		Session::put('uid', $user->id);
		Session::put('username', $user->username);
        return Redirect::action('HomeController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $user = User::find($id);
		
		if (Request::ajax()) {
			$response = ($user) ? $user->toArray() : array('username' => "Not Found");
			return Response::json($response);
		}
		
		$notifications = $user->notifications()->orderBy('created_at', 'desc')->orderBy('read', 'desc')->take(5)->get();
			
		$games = Game::whereRaw('(player1 = ? OR player2 = ?) AND replay_url IS NOT NULL', 
							       array($id, $id))->take(5)->get();
        $wins = Game::where('winner', '=', $id)->count();
		$losses = Game::whereRaw('(player1 = ? OR player2 = ?) AND winner > 0 AND winner <> ?',
		                          array($id, $id, $id))->count();
		if ($losses == 0) {
			$ratio = 100;
		} else {
			$ratio = number_format($wins / ($wins + $losses) * 100, 2);
		}
		return View::make('user/profile', array('user' => $user, 'games' => $games,
		                                        'wins' => $wins, 'losses' => $losses,
												'ratio' => $ratio,
												'notifications' => $notifications));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //Authorize
        $user = User::find($id);

        return View::make('user/edit', array('user' => $user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
    	$user = User::find($id);

		if (Input::has('bnet_name')) $user->bnet_name = Input::get('bnet_name');
		if (Input::has('char_code')) $user->char_code = Input::get('char_code');
		if (Input::has('league')) $user->league = Input::get('league');

		$user->save();
		return Redirect::route('user.profile', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $user = User::destroy($id);
   		return Redirect::action('UserController@index');
	}
	

	public function login($return_url) {
		if ($return_url) {
			Session::put('redirect', urldecode($return_url));
		}

		return Redirect::route('hybridauth');
	}

	public function logout() {
		$hybrid = new Hybrid_Auth(Config::get('hybridauth'));
		$hybrid->restoreSessionData($hybrid->getSessionData());
		$hybrid->getAdapter("Google")->logout();
		Auth::logout();
		Session::flush();
		return Redirect::action('HomeController@index');
	}

	public function leaveteam() {
		$user = Auth::user();
		
		$user->leaveTeam();
		
		$user = Auth::user();
		if ($user->team_id != 0 && $user->team->leader == $user->id) {
			return Redirect::route('team.show', $user->team->id);
		}

		return Redirect::route('team.index');
	}
	
	public function checkTaken($type, $val) {
		$taken = User::where($type, '=', $val)->count();
		return Response::json(array('taken' => $taken));
	}

	public function search($term) {
		$users = User::where(DB::raw('LOWER(username)'), 'LIKE', '%' . strtolower($term) . '%');
		if (Input::has('hasTeam')) {
			if (Input::get('hasTeam') == "true") {
				$users = $users->where('team_id', '>', 0);
			} else {
				$users = $users->where('team_id', '=', 0);
			}
		}
		$users = $users->get();
		return View::make('user/multipleCardPartial', array('members' => $users));
	}

}
