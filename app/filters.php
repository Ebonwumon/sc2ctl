<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function($route, $request)
{
	if (!Sentry::check()) { 
    Session::put('redirect', URL::current());
    return Redirect::route('user.login'); 
  }
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Sentry::check()) return Redirect::route('home');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

Route::filter('perm', function($route, $request, $value) {
    $perms = explode(',', $value);
    $user = Sentry::getUser();
    foreach ($perms as $perm) {
      if (!$user->hasAccess($perm)) {
        App::abort('401', "You do not have permission to do that");
      }
    }
});
Route::filter('register_lineup', function($route, $request) {
  $lineup_id = Input::get('lineup_id');
  if (!Sentry::getUser()->registerableLineups()->contains($lineup_id)) {
    App::abort('401', "You're not authorized to do that");
  }
  
});
Route::filter('can_report', function($route, $request, $value) {
  if ($value == "match") {
    $obj = Match::findOrFail($route->getParameter('id'));
  } else if ($value == "game") {
    $obj = Game::findOrFail($route->getParameter('id'));
  }
  if (!$obj->canReport(Sentry::getUser())) {
    App::abort('401', "You're not Authorized to do that");
  }
});

Route::filter('create_roster', function($route, $request) {
  $lineup = Lineup::findOrFail($route->getParameter('lineup_id')); 
  if (!$lineup->canCreateRoster(Sentry::getUser())) {
    App::abort('401', "You're not authorized to do that!");
  }

});

Route::filter('remove_member', function($route, $request) {
  $team = Team::findOrFail($route->getParameter('id'));
  if(!$team->canRemoveMembers(Sentry::getUser())) {
    if (!Input::get('user_id') == Sentry::getUser()->id) {
      App::abort('401', "You're not Authorized to do that");
    }
  }
});

Route::filter('change_rank', function($route, $request) {
  $lineup = Lineup::findOrFail($route->getParameter('id'));
  if (!$lineup->canChangeRanks(Sentry::getUser())) {
    App::abort('401', "You're not Authorized to do that"); 
  }
});
Route::filter('is_user', function($route, $request) {
    if(!Sentry::getUser()->hasAccess('edit_profiles')) {
      if (Sentry::getUser()->id != $route->getParameter('id')) {
        App::abort('401', "You're not Authorized to do that");
      }
    }
});

Route::filter('lineup_captain', function($route, $request) {
    $lineup = Lineup::findOrFail($route->getParameter('id'));
    if (!$lineup->canRename(Sentry::getUser())) {
      App::abort('401', "You're not Authorized to do that");
    }
  });

Route::filter('lineup_captain_on_team', function($route, $request) {
    $team = Team::findOrFail($route->getParameter('id'));
    /*if (!$lineup->canRename(Sentry::getUser())) {
      App::abort('401', "You're not Authorized to do that");
    }*/
    //Todo
  });


View::composer('index', function($view) {
  $randTeam = Team::orderBy(DB::raw('RAND()'))->take(1)->get();
  $randUser = User::orderBy(DB::raw('RAND()'))->take(1)->get();
  $vod = VOD::orderBy(DB::raw('RAND()'))->take(1)->get();
  $view->with('vod', $vod->first());
  $view->with('randTeam', $randTeam->first());
  $view->with('randUser', $randUser->first());
    });
View::composer('team/profile', function($view) {
  if (!isset($view['edit'])) {
    $view->with('edit', false);
  } else {
  }
});
View::composer(array('team/profileCardPartial', 'team/lineup/profileCardPartial'), function($view) {
    if (!isset($view['smallCard'])) {
      $view->with('smallCard', false);
    }
});

View::composer(array('team/lineupPartial'), function($view) {
  $view->with('select', $view['lineup']->team->availablePlayers()->lists('qualified_name', 'id'));   
});

View::composer(array('match/matchCardPartial'), function($view) {
  $score = $view['match']->score();
  while(count($score) < 2) {
    $score['NULL#' . uniqid()] = array('wins' => 0, 'losses' => 0, 'id' => 0, 'won' => false);
  }
  $view->with('matchScore', $score);
  $view->with('keys', array_keys($score));

});

View::composer('user/profileCardPartial', function($view) {
    if (!isset($view['smallCard'])) {
      $view->with('smallCard', false);
    }
    if (!isset($view['dispTip'])) {
      $view->with('dispTip', false);
    }

    if (!isset($view['dispCharcode'])) {
      $view->with('dispCharcode', true);
    }

    if (!isset($view['win'])) {
      $view->with('win', false);
    }

    if(!isset($view['loss'])) {
      $view->with('loss', false);
    }

    if (!isset($view['is_default'])) {
      $view->with('is_default', false);
    }

    if (!isset($view['replay_url']) || $view['replay_url'] == NULL || $view['replay_url'] == "") {
        $view->with('replay_url', "#");
    }
});

View::composer('dogetip/create', function($view) {
  $default = ($view['user_id']) ? $view['user_id'] : null;
  $view->with('default', $default);
  $view->with('players', User::listAll());
});

