<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('test', function() {
      dd(DogeAPI::getBalance('DGdsqkLbZb3qgrsjZM8x1mLWENE8sXN6tA'));
    });
Route::get('/', array('as' => 'home', "uses" => 'HomeController@index')); 
Route::get('login/{return_url?}', array('as' => 'user.login', 'uses' => 'UserController@login'));
Route::get('contact', array('as' => 'home.contact', "uses" => 'HomeController@contact'));
Route::get('about', array('as' => 'home.about', 'uses' => 'HomeController@about'));
Route::get('format', array('as' => 'home.format', 'uses' => 'HomeController@format'));
Route::get('rules', array('as' => 'home.rules', 'uses' => 'HomeController@rules'));
Route::get('finals', array('as' => 'home.finals', 'uses' => 'HomeController@finals'));
Route::get('dogecoin', array('as' => 'dogecoin', 'uses' => 'HomeController@dogecoin'));
Route::get('blog', array('as' => 'blog.index', 'uses' => 'BlogController@index'));
Route::get('blog/{id}', array('as' => 'blog.profile', 'uses' => 'BlogController@show'));
Route::get('stats', array('as' => 'stats', 'uses' => 'StatsController@index'));
Route::get('stats/highest_median_winrate', 'StatsController@highestMedianWR');
Route::get('stats/every_man_on_the_field/{id}', 'StatsController@allPlayedInTournament');

//caster authenticated
Route::group(array('before' => 'auth'), function() {
  Route::get('vod/create', array('as' => 'vod.create', 'uses' => 'VODController@create'));
  Route::post('vod', array('as' => 'vod.store', 'uses' => 'VODController@store'));
});

Route::get('stream', array('as' => 'stream', 'uses' => 'HomeController@stream'));
Route::get('stream/teams', array('as' => 'stream.getTeams', 'uses' => 'HomeController@getTeams'));
//Authenticated methods
Route::group(array('before' => 'guest'), function() {
  Route::get('register', array('as' => 'user.register', 'uses' => 'UserController@register'));
  Route::post('login', array('as' => 'user.auth', 'uses' => 'UserController@auth'));
    });
Route::group(array('before' => 'auth'), function() {
	
	Route::get('code', array('as' => 'code.index', 'uses' => 'CodeController@index'));
	Route::post('code/submit', array('as' => 'code.submit', 'uses' => 'CodeController@submit'));
	Route::get('user/logout', array("as" => "user.logout", 'uses' => "UserController@logout"));
	Route::post('user/leaveteam', array('uses' => 'UserController@leaveteam'));
	Route::get('/team/create', array('as' => 'team.create', "uses" => 'TeamController@create'));
	Route::post('team', array('as' => 'team.store', 'uses' => 'TeamController@store'));
	Route::post('tournament/{id}/register', array('as' => 'tournament.register', 'uses' => 'TournamentController@register'));
	Route::post('notification/{id}/mark', array('as' => 'notification.mark', 'uses' => 'NotificationController@mark'));
});

	Route::get('code/create', array('as' => 'code.create', 'uses' => 'CodeController@create'));
	Route::post('code', array('as' => 'code.store', 'uses' => 'CodeController@store'));
	Route::get('code/winner', array('as' => 'code.winner', 'uses' => 'CodeController@winner'));
	Route::post('code/getwinner', array('as' => 'code.getWinner', 'uses' => 'CodeController@getWinner'));
	Route::get('notification/create', array('as' => 'notification.create', 'uses' => 'NotificationController@create'));
	Route::post('notification', array('as' => 'notification.store', 'uses' => 'NotificationController@store'));
Route::group(array('before' => "auth|is_user"), function() {
	Route::get('user/{id}/edit', array('as' => 'user.edit', 'uses' => 'UserController@edit'));
	Route::put('user/{id}', array('as' => 'user.update', 'uses' => 'UserController@update'));
	Route::post('user/{id}/changepic', array('as' => 'user.changepic', 'uses' => 'AssetController@uploadProfileImage'));
});
	Route::put('game/{id}/report', array('as' => 'game.report', 'uses' => 'GameController@report'));
	Route::get('match/{id}/wizard/{gno?}', array('as' => 'match.wizard', 'uses' => 'MatchController@wizard'));
	Route::get('match/{id}/wizard/{gno?}/nextgame', array('as' => 'match.wizard.nextgame', 'uses' => 'MatchController@nextgame'));
	Route::post('asset/upload/replay/{gid}', array('as' => 'replay.upload', 'uses' => 'AssetController@uploadReplay'));

Route::get('game/forfeit', array('as' => 'game.forfeit', function() { return View::make('game/forfeit'); }));

  Route::put('team/{id}/addcontact', array('as' => 'team.addcontact', 'uses' => 'TeamController@addcontact'));
	Route::put('team/{id}/addleader', array('as' => 'team.addleader', 'uses' => 'TeamController@addleader'));
	Route::post('team/{id}/addmembers', 'TeamController@add');
	Route::get('team/{id}/modify', array('as' => 'team.editinfo', "uses" => "TeamController@editinfo"));
	Route::get('/team/{id}/edit', array('as' => 'team.edit', "uses" => "TeamController@edit"));
	Route::put('/team/evict', array('as' => 'team.evict', 'uses' => "TeamController@evict"));
	Route::get('/team/{id}/edit', array('as' => 'team.edit', "uses" => "TeamController@edit"));

	Route::get('/lineup/create/{id}', array('as' => 'lineup.create', 'uses' => "LineupController@create"));
	Route::post('team/{id}/lineup', array('as' => 'lineup.store', 'uses' => "LineupController@store"));

	Route::post('lineup/{id}/remove_user', array('as' => 'lineup.remove_user', 'uses' => "LineupController@remove_user"));

	Route::post('lineup/{id}/add_user', array('as' => 'lineup.add_user', 'uses' => "LineupController@add_user"));

	Route::post('lineup/{id}/change_rank', array('as' => 'lineup.change_rank', 'uses' => "LineupController@change_rank"));

//TODO these don't seem to work
	Route::get('game/create', array('as' => 'game.create', 'uses' => 'GameController@create'));
	Route::post('game', array('as' => 'game.store', 'uses' => 'GameController@store'));


Route::get('user/checktaken/{type}/{val}', 'UserController@checkTaken');
Route::get('user/search/{term}', 'UserController@search');
Route::get('user', array('as' => 'user.index', 'uses' => 'UserController@index'));
Route::post('user', array('as' => 'user.store', 'uses' => 'UserController@store'));
Route::get('user/{id}', array('as' => 'user.profile', 'uses' => 'UserController@show'));

Route::get('team', array('as' => 'team.index', 'uses' => 'TeamController@index'));
Route::get('team/{id}', array('as' => 'team.profile', 'uses' => 'TeamController@show'));
Route::get('team/search/{term}', array('as' => 'team.search', 'uses' => 'TeamController@search'));

Route::post('team/{id}', array('as' => 'team.update', 'uses' => 'TeamController@update'));

Route::delete('team/{id}', array('before' => 'deleteteam', 'as' => 'team.destroy', 'uses' => 'TeamController@destroy'));
Route::delete('user/{id}', array('before' => 'deleteuser', 'as' => 'user.destroy', 'uses' => 'UserController@destory'));

Route::get('role/permission', array('as' => 'permission.index', 'uses' => 'PermissionController@index'));
Route::get('role/permission/create', array('as' => 'permission.create', 'uses' => 'PermissionController@create'));
Route::post('role/permission', array('as' => 'permission.store', 'uses' => 'PermissionController@store'));

Route::get('role', array('as' => 'role.index', 'uses' => 'RoleController@index'));
Route::get('role/create', array('as' => 'role.create', 'uses' => 'RoleController@create'));
Route::get('role/{id}', array('as' => 'role.profile', 'uses' => 'RoleController@show'));
Route::get('role/{id}/edit', array('as' => 'role.edit', 'uses' => 'RoleController@edit'));
Route::put('role/{id}', array('as' => 'role.update', 'uses' => 'RoleController@update'));
Route::post('role', array('as' => 'role.store', 'uses' => 'RoleController@store'));

// Must remain open until I refactor the javascript in the wizard to user report instead of update
Route::put('game/{id}', array('as' => 'game.update', 'uses' => 'GameController@update'));
Route::get('game/{id}', array('as' => 'game.profile', 'uses' => 'GameController@show'));

// admin matches
	Route::get('match/create', array('as' => 'match.create', 'uses' => 'MatchController@create'));
	Route::post('match', array('as' => 'match.store', 'uses' => 'MatchController@store'));
	Route::get('match/{id}/edit', array('as' => 'match.edit', 'uses' => 'MatchController@edit'));

Route::post('match/{id}', array('as' => 'match.update', 'uses' => 'MatchController@update'));

Route::get('match/{id}', array('as' => 'match.profile', 'uses' => 'MatchController@show'));
Route::get('match/{id}/landing', array('as' => 'match.landing', 'uses' => 'MatchController@landing'));
Route::get('match/{id}/won', array('as' => 'match.won', 'uses' => 'MatchController@won'));

// admin groups 
	Route::get('group/create', array('as' => 'group.create', 'uses' => 'GroupController@create'));
	Route::post('group', array('as' => 'group.store', 'uses' => 'GroupController@store'));
	Route::post('group/{id}/generatematch', array('as' => 'group.generate', 'uses' => 'GroupController@generatematch'));
	Route::get('group', array('as' => 'group.index', 'uses' => 'GroupController@index'));

Route::get('group/{id}', array('as' => 'group.profile', 'uses' => 'GroupController@show'));

//admin routes
  Route::get('round/create', array('as' => 'round.create', 'uses' => 'RoundController@create'));
	Route::post('round', array('as' => 'round.store', 'uses' => 'RoundController@store'));
	Route::post('round/{id}/generatematches', array('as' => 'round.generate', 'uses' => 'RoundController@generatematches'));

// admin tournaments
  Route::get('tournament/create', array('as' => 'tournament.create', 'uses' => 'TournamentController@create'));
	Route::post('tournament', array('as' => 'tournament.store', 'uses' => 'TournamentController@store'));
	Route::get('tournament/{id}/edit', array('as' => 'tournament.edit', 'uses' => 'TournamentController@edit'));
	Route::get('tournament/{id}/edit/groups', array('as' => 'tournament.groups', 'uses' => 'TournamentController@groups'));
	Route::get('tournament/{id}/edit/round', array('as' => 'tournament.round', 'uses' => 'TournamentController@round'));
	Route::put('tournament/{id}', array('as' => 'tournament.update', 'uses' => 'TournamentController@update'));
	Route::post('tournament/{id}/generategroups', array('as' => 'tournament.generategroups', 'uses' => 'TournamentController@generateGroups'));

Route::get('tournament', array('as' => 'tournament.index', 'uses' => 'TournamentController@index'));
Route::get('tournament/{id}', array('as' => 'tournament.profile', 'uses' => 'TournamentController@show'));
Route::get('tournament/{id}/phase/{phase}', array('as' => 'tournament.filterphase', 'uses' => 'TournamentController@show'));
Route::post('tournament/{id}/addteam', array('as' => 'tournament.addteam', 'uses' => 'TournamentController@addteam'));
Route::post('tournament/{id}/removeteam', array('as' => 'tournament.removeteam', 'uses' => 'TournamentController@removeteam'));
Route::post('tournament/{id}/leave', array('as' => 'tournament.leave', 'uses' => 'TournamentController@leave'));

Route::get('dogetip/create/{id?}', array('as' => 'dogetip.create', 'uses' => 'DogetipController@create'));
Route::get('dogetip/list/{confirmation?}', array('as' => 'dogetip.list', 'uses' => 'DogetipController@index'));
Route::post('dogetip', array('as' => 'dogetip.store', 'uses' => 'DogetipController@store'));
Route::get('dogetip/scan', array('as' => 'dogetip.scan', 'uses' => 'DogetipController@scan'));
Route::get('dogetip/{id}', array('as' => 'dogetip.show', 'uses' => 'DogetipController@show'));
