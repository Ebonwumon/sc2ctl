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
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
      $v = User::validates(Input::all());
      if ($v->passes()) {
        $args = Input::only(
                'email', 
                'username', 
                'password', 
                'bnet_id', 
                'bnet_name', 
                'char_code', 
                'league',
                'bnet_url'
                );
        $user = Sentry::register($args, true);
        Sentry::login($user, false);
        return Redirect::route('user.profile', $user->id);
      }
      return Redirect::route('user.register')->withErrors($v)->withInput(); 
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

    public function edit($id) {
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
	

	public function login($return_url = false) {
		if ($return_url) {
			Session::put('redirect', urldecode($return_url));
		}
	  return View::make('user/login');
  }

  public function auth() {
    $errors = new \Illuminate\Support\MessageBag;
    try {
      Sentry::authenticate(Input::only('email', 'password'), true);
      
    } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
      $errors->add('error', "Email field is required to log in");
    }
    catch (Cartalyst\Sentry\Users\PasswordRequiredException $e) {
      $errors->add('error', "Password field is required to log in");
    }
    catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
    {
      $errors->add('error', "User not activated");
    }
    catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
    {
      $errors->add('error', "Username/Password incorrect");
    }
    catch (Cartalyst\Sentry\Users\WrongPasswordException $e) {
      $errors->add('error', "Could not authenticate. Email/Password incorrect");
    }
    catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
      $errors->add('error', 'User is suspended due to too many login attempts');
    }
    catch (Cartalyst\Sentry\Throttling\UserBannedException $e) {
      $errors->add('error', 'User is banned due to too many login attempts');
    }

    if ($errors->count() > 0) {
      return View::make('user/login', array('errors' => $errors));  
    }
    if (Session::has('redirect')) {
      $url = Session::get('redirect');
      Session::forget('redirect');
      return Redirect::to($url);
    }
    return Redirect::route('home');
  }

  public function start_reset() {
    return View::make('login/start_reset');
  }

  public function send_token() {
    $email = Input::get('email');
    $errors = new \Illuminate\Support\MessageBag;
    try {
      $user = Sentry::findUserByLogin($email);
      $resetCode = $user->getResetPasswordCode();

    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $errors->add('error', "Email not found in database");  
    }

    if ($errors->count() > 0) {
      return View::make('user/start_reset', array('errors' => $errors));  
    }
    Mail::queue('emails.reminder', array('id' => $user->id, 'token' => $resetCode), function($m) use ($user) {
      $m->to($user->email)->subject("SC2CTL Password Reset");
    });
    
    if ($errors->count() > 0)
      return View::make('login/start_reset', array('errors' => $errors));
    
    return Redirect::route('home');
  }

  public function finalize_password($user_id, $token) {
    return View::make('login/finalize_password', array('token' => $token, 'user_id' => $user_id));
  }

  public function complete_reset() {
    $errors = new \Illuminate\Support\MessageBag;
    
    try {
      $user = Sentry::findUserById(Input::get('user_id'));
      if ($user->checkResetPasswordCode(Input::get('token'))) {
        if ($user->attemptResetPassword(Input::get('token'), Input::get('password'))) {
          Sentry::loginAndRemember($user);
          return Redirect::route('home');
        } else {
          $errors->add('error', "Password Reset failed");
        }
      } else {
        // The password reset code is invalid
        $errors->add('error', "Password reset code was invalid, please try again");
        return View::make('login/start_reset', array('errors', $errors));
      }
    } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
      $errors->add('error', "User record was not found");
    }

      return View::make('login/finalize_password', array(
          'errors' => $errors,
          'token' => Input::get('token'),
          'user_id' => Input::get('user_id')
          )
      );
  }

  public function register() {
    return View::make('user/create'); 
  }

	public function logout() {
    Sentry::logout();
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
