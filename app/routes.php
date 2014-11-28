<?php

Route::group([ 'namespace' => 'SC2CTL\DotCom\Controllers' ], function() {

    Route::group([ 'before' => 'guest' ], function() {
        Route::get('login', [ 'as' => 'user.login', 'uses' => 'AuthController@login' ]);
        Route::post('auth', [ 'as' => 'user.auth', 'uses' => 'AuthController@auth' ]);
        Route::get('register', [ 'as' => 'user.register', 'uses' => 'AuthController@register' ]);
        Route::get('login/reset/begin', [ 'as' => 'reminder.start_reset', 'uses' => 'ReminderController@start_reset' ]);
        Route::post('login/reset/send_token', [ 'as' => 'reminder.send_token', 'uses' => 'ReminderController@send_token' ]);
        Route::get('login/reset/finalize_password/{token}', [ 'as' => 'reminder.finalize_password', 'uses' => 'ReminderController@finalize_password' ]);
        Route::post('login/reset/finalize_password', [ 'as' => 'reminder.complete_reset', 'uses' => 'ReminderController@complete_reset' ]);
    });

    Route::group( [ 'before' => 'auth' ], function () {
        Route::post('logout', [ 'as' => 'user.logout', 'uses' => 'AuthController@logout' ]);
        Route::get('bnet_connect', [ 'as' => 'bnet.connect', 'uses' => "BnetAuthController@bnet_connect" ]);
        Route::get('bnet_auth', [ 'as' => 'bnet.auth', 'uses' => "BnetAuthController@bnet_auth" ]);

        Route::group([ 'before' => 'teamless_user|requires_bnet'], function() {
            Route::get('team/create', [ 'as' => 'team.create', "uses" => 'TeamController@create' ]);
            Route::post('team', [ 'as' => 'team.store', 'uses' => 'TeamController@store' ]);
        });

        Route::group([ 'before' => 'edit_team' ], function() {
            Route::get('/team/{id}/edit', [ 'as' => 'team.edit', "uses" => "TeamController@edit" ]);
        });


        Route::group([ 'before' => 'is_user' ], function() {
            Route::get('user/{id}/edit', [ 'as' => 'user.edit', 'uses' => 'UserController@edit' ]);
            Route::post('user/{id}', [ 'as' => 'user.update', 'uses' => 'UserController@update' ]);
        });
    });

    Route::get('/', [ 'as' => 'home.index', "uses" => 'HomeController@index' ]);
    Route::get('contact', [ 'as' => 'home.contact', "uses" => 'HomeController@contact' ]);
    Route::get('about', [ 'as' => 'home.about', 'uses' => 'HomeController@about' ]);
    Route::get('format', [ 'as' => 'home.format', 'uses' => 'HomeController@format' ]);
    Route::get('rules', [ 'as' => 'home.rules', 'uses' => 'HomeController@rules' ]);
    Route::get('sponsors', [ 'as' => 'home.sponsors', 'uses' => 'HomeController@sponsors' ]);
    Route::get('help', [ 'as' => 'help', 'uses' => 'HomeController@help' ]);

    Route::get('team', [ 'as' => 'team.index', 'uses' => 'TeamController@index' ]);
    Route::get('team/{id}', [ 'as' => 'team.show', 'uses' => 'TeamController@show' ]);
    Route::get('user/{id}', [ 'as' => 'user.show', 'uses' => 'UserController@show' ]);

});



Route::get('finals', array('as' => 'home.finals', 'uses' => 'SC2CTL\DotCom\Controllers\HomeController@finals'));
Route::get('dogecoin', array('as' => 'dogecoin', 'uses' => 'SC2CTL\DotCom\Controllers\HomeController@dogecoin'));

Route::get('blog', array('as' => 'blog.index', 'uses' => 'BlogController@index'));
Route::get('blog/{id}', array('as' => 'blog.profile', 'uses' => 'BlogController@show'));
Route::get('stats', array('as' => 'stats', 'uses' => 'StatsController@index'));
Route::get('stats/highest_median_winrate', 'StatsController@highestMedianWR');
Route::get('stats/every_man_on_the_field/{id}', 'StatsController@allPlayedInTournament');
Route::get('stream', array('as' => 'stream', 'uses' => 'SC2CTL\DotCom\Controllers\HomeController@stream'));
Route::get('stream/teams', array('as' => 'stream.getTeams', 'uses' => 'SC2CTL\DotCom\Controllers\HomeController@getTeams'));

Route::get('game/{id}', array('as' => 'game.profile', 'uses' => 'GameController@show'));

Route::get('lineup/{id}', array('as' => 'lineup.show', 'uses' => 'LineupController@show'));
Route::get('lineup/{id}/matches', array('as' => 'lineup.matches', 'uses' => 'LineupController@matches'));
//caster authenticated

Route::get('auth/fb_logout', array('as' => 'auth.fbLogout', 'uses' => 'SC2CTL\DotCom\Controllers\AuthenticationController@fblogout'));
Route::get('auth/fb_login', array('as' => 'auth.fbLogin', 'uses' => 'SC2CTL\DotCom\Controllers\AuthenticationController@fbLogin'));

Route::group(array('before' => 'auth|perm:vods'), function() {
  Route::get('vod/create', array('as' => 'vod.create', 'uses' => 'VODController@create'));
  Route::post('vod', array('as' => 'vod.store', 'uses' => 'VODController@store'));
});



Route::group(array('before' => 'guest'), function() {


  Route::post('user', array('as' => 'user.store', 'uses' => 'SC2CTL\DotCom\Controllers\UserController@store'));


});

Route::group(array('before' => 'auth'), function() {
	Route::post('user/leaveteam', array('uses' => 'SC2CTL\DotCom\Controllers\UserController@leaveteam'));

	Route::post('notification/{id}/mark', array('as' => 'notification.mark', 'uses' => 'NotificationController@mark'));
});

Route::group(array('before' => 'auth|register_lineup'), function() {
  Route::post('tournament/{id}/register', array('as' => 'tournament.register', 'uses' => 'TournamentController@register'));
});

Route::group(array('before' => 'auth|perm:codes'), function() {
	Route::get('code/create', array('as' => 'code.create', 'uses' => 'CodeController@create'));
	Route::post('code', array('as' => 'code.store', 'uses' => 'CodeController@store'));
});

Route::group(array('before' => 'auth|perm:create_notifications'), function() {
	Route::get('notification/create', array('as' => 'notification.create', 'uses' => 'NotificationController@create'));
	Route::post('notification', array('as' => 'notification.store', 'uses' => 'NotificationController@store'));
});



//TODO make can_report
Route::group(array('before' => "auth|can_report:match"), function() {
  Route::get('match/{id}/report/{override?}', array('as' => 'match.report', 'uses' => 'MatchController@report'));
  Route::post('match/{id}/report', array('as' => 'match.report_default', 'uses' => 'MatchController@report_default')); 
	Route::get('match/{id}/wizard/{gno?}', array('as' => 'match.wizard', 'uses' => 'MatchController@wizard'));
	Route::get('match/{id}/wizard/{gno?}/nextgame', array('as' => 'match.wizard.nextgame', 'uses' => 'MatchController@nextgame'));
});

Route::group(array('before' => "auth|can_report:game"), function() {
	Route::post('game/{id}', array('as' => 'game.report', 'uses' => 'GameController@report'));
	Route::post('asset/replay/{id}', array('as' => 'replay.upload', 'uses' => 'AssetController@uploadReplay'));
});

Route::get('game/forfeit', array('as' => 'game.forfeit', function() { return View::make('game/forfeit'); }));

Route::group(array('before' => "auth|can_manage_team_members"), function() {
  // TODO add enrollment here.
});

// TODO make team_owner and team_officer, team_captain
Route::group(array('before' => 'auth|team_owner'), function() {
  Route::get('lineup/create/{id}', array('as' => 'lineup.create', 'uses' => "LineupController@create"));
  Route::delete('lineup/{id}', array('as' => 'lineup.delete', 'uses' => "LineupController@destroy"));
	Route::post('team/{id}/lineup', array('as' => 'lineup.store', 'uses' => "LineupController@store"));
});

Route::group(array('before' => 'auth|lineup_captain'), function() {
  Route::post('lineup/{id}', array('as' => 'lineup.update', 'uses' => 'LineupController@update'));
	Route::post('team/{id}/addmembers', 'TeamController@add');
	Route::put('team/evict', array('as' => 'team.evict', 'uses' => "TeamController@evict"));
	});

Route::post('lineup/{id}/change_rank', array('before' => 'auth|change_rank', 
                                             'as' => 'lineup.change_rank', 
                                             'uses' => "LineupController@change_rank"));

Route::post('team/{id}/remove', array('before' => 'auth|remove_member',
                                      'as' => 'team.remove',
                                      'uses' => 'TeamController@remove'));

Route::group(array('before' => 'auth|lineup_captain_on_team'), function() {
});

Route::group(array('before' => 'auth|lineup_officer'), function() {
  Route::get('team/{id}/modify', array('as' => 'team.editinfo', "uses" => "TeamController@editinfo"));
	Route::post('lineup/{id}/add_user', array('as' => 'lineup.add_user', 'uses' => "LineupController@add_user"));
	Route::post('lineup/{id}/remove_user', array('as' => 'lineup.remove_user', 'uses' => "LineupController@remove_user"));
});

// TODO fix protection
Route::group(array('before' => 'auth'), function() {
  Route::get('tournament/{id}/manage_rosters', array('as' => 'roster.index', 'uses' => 'RosterController@index'));
  Route::get('roster/create/{match_id}/{lineup_id}', array('as' => 'roster.create',
      'uses' => 'RosterController@create'));
  Route::get('roster/{id}/edit', array('as' => 'roster.edit', 'uses' => 'RosterController@edit'));
  Route::post('roster/{id}', array('as' => 'roster.update', 'uses' => 'RosterController@update'));
});

// TODO protect this
  Route::post('roster', array('as' => 'roster.store', 'uses' => 'RosterController@store'));
  
Route::group(array('before' => 'auth|perm:create_games'), function() {
	Route::get('game/create', array('as' => 'game.create', 'uses' => 'GameController@create'));
	Route::post('game', array('as' => 'game.store', 'uses' => 'GameController@store'));
});

Route::group(array('before' => 'auth|perm:superupser'), function() {
  Route::get('team/{id}/delete', array('as' => 'team.delete', 'uses' => 'TeamController@delete'));
  Route::delete('team/{id}', array('as' => 'team.destroy', 'uses' => 'TeamController@destroy'));
});

Route::get('user/checktaken/{type}/{val}', 'SC2CTL\DotCom\Controllers\UserController@checkTaken');
Route::get('user/search/{term}', 'SC2CTL\DotCom\Controllers\UserController@search');
Route::get('user', array('as' => 'user.index', 'uses' => 'SC2CTL\DotCom\Controllers\UserController@index'));





//TODO proper authorization
Route::post('team/{id}', array('as' => 'team.update', 'uses' => 'TeamController@update'));

Route::group(array('before' => 'auth|perm:delete_teams'), function() {
  Route::delete('team/{id}', array('before' => 'deleteteam', 'as' => 'team.destroy', 'uses' => 'TeamController@destroy'));
});

Route::group(array('before' => 'auth|perm:delete_users'), function() {
  Route::delete('user/{id}', array('before' => 'deleteuser', 'as' => 'user.destroy', 'uses' => 'SC2CTL\DotCom\Controllers\UserController@destory'));
});

Route::group(array('before' => 'auth|perm:admin'), function() {
    Route::get('role/permission', array('as' => 'permission.index', 'uses' => 'PermissionController@index'));
  Route::get('role/permission/create', array('as' => 'permission.create', 'uses' => 'PermissionController@create'));
  Route::post('role/permission', array('as' => 'permission.store', 'uses' => 'PermissionController@store'));
  Route::get('role', array('as' => 'role.index', 'uses' => 'RoleController@index'));
  Route::get('role/create', array('as' => 'role.create', 'uses' => 'RoleController@create'));
  Route::get('role/{id}', array('as' => 'role.profile', 'uses' => 'RoleController@show'));
  Route::get('role/{id}/edit', array('as' => 'role.edit', 'uses' => 'RoleController@edit'));
  Route::put('role/{id}', array('as' => 'role.update', 'uses' => 'RoleController@update'));
  Route::post('role', array('as' => 'role.store', 'uses' => 'RoleController@store'));

    Route::get('giveaway/create', array('as' => 'giveaway.create', 'uses' => 'GiveawayController@create'));
    Route::post('giveaway', array('as' => 'giveaway.store', 'uses' => 'GiveawayController@store'));
});

// TODO read this if it's broken
// Must remain open until I refactor the javascript in the wizard to user report instead of update
// Route::put('game/{id}', array('as' => 'game.update', 'uses' => 'GameController@update'));
// Route::get('game/{id}', array('as' => 'game.profile', 'uses' => 'GameController@show'));

// admin matches
Route::group(array('before' => 'auth|perm:create_matches'), function() {
	Route::get('match/create', array('as' => 'match.create', 'uses' => 'MatchController@create'));
	Route::post('match', array('as' => 'match.store', 'uses' => 'MatchController@store'));
});

Route::group(array('before' => 'auth|perm:edit_matches'), function() {
	Route::get('match/{id}/edit', array('as' => 'match.edit', 'uses' => 'MatchController@edit'));
  Route::post('match/{id}', array('as' => 'match.update', 'uses' => 'MatchController@update'));
});

//TODO I think these are broken
Route::get('match/{id}', array('as' => 'match.profile', 'uses' => 'MatchController@show'));
Route::get('match/{id}/landing', array('as' => 'match.landing', 'uses' => 'MatchController@landing'));
Route::get('match/{id}/won', array('as' => 'match.won', 'uses' => 'MatchController@won'));

Route::group(array('before' => 'auth|perm:create_groups'), function() {
	Route::get('group/create', array('as' => 'group.create', 'uses' => 'GroupController@create'));
	Route::post('group', array('as' => 'group.store', 'uses' => 'GroupController@store'));
	Route::post('group/{id}/generatematch', array('as' => 'group.generate', 'uses' => 'GroupController@generatematch'));
});

Route::get('group', array('as' => 'group.index', 'uses' => 'GroupController@index'));
Route::get('group/{id}', array('as' => 'group.profile', 'uses' => 'GroupController@show'));

Route::group(array('before' => 'auth|perm:create_rounds'), function() {  
  Route::get('round/create', array('as' => 'round.create', 'uses' => 'RoundController@create'));
	Route::post('round', array('as' => 'round.store', 'uses' => 'RoundController@store'));
	Route::post('round/{id}/generatematches', array('as' => 'round.generate', 'uses' => 'RoundController@generatematches'));
});

Route::group(array('before' => 'auth|perm:create_tournaments'), function() {
  Route::get('tournament/create', array('as' => 'tournament.create', 'uses' => 'TournamentController@create'));
	Route::post('tournament', array('as' => 'tournament.store', 'uses' => 'TournamentController@store'));
  Route::post('season', array('as' => 'tournament.store_season', 'uses' => 'TournamentController@store_season'));
});

//TODO maybe editing of groups and rounds should be moved elsewhere?
Route::group(array('before' => 'auth|perm:edit_tournaments'), function() {
	Route::get('tournament/{id}/edit', array('as' => 'tournament.edit', 'uses' => 'TournamentController@edit'));
	Route::get('tournament/{id}/edit/groups', array('as' => 'tournament.groups', 'uses' => 'TournamentController@groups'));
	Route::get('tournament/{id}/edit/round', array('as' => 'tournament.round', 'uses' => 'TournamentController@round'));
	Route::put('tournament/{id}', array('as' => 'tournament.update', 'uses' => 'TournamentController@update'));
	Route::post('tournament/{id}/start', array('as' => 'tournament.start', 'uses' => 'TournamentController@start'));
});

// TODO I give up
Route::get('tournament', array('as' => 'tournament.index', 'uses' => 'TournamentController@index'));
Route::get('tournament/{id}', array('as' => 'tournament.profile', 'uses' => 'TournamentController@show'));
Route::get('tournament/{id}/phase/{phase}', array('as' => 'tournament.filterphase', 'uses' => 'TournamentController@show'));

Route::post('tournament/{id}/leave', array('as' => 'tournament.leave', 'uses' => 'TournamentController@leave'));

Route::get('dogetip/create/{id?}', array('as' => 'dogetip.create', 'uses' => 'DogetipController@create'));
Route::get('dogetip/list/{confirmation?}', array('as' => 'dogetip.list', 'uses' => 'DogetipController@index'));
Route::post('dogetip', array('as' => 'dogetip.store', 'uses' => 'DogetipController@store'));
Route::get('dogetip/scan', array('as' => 'dogetip.scan', 'uses' => 'DogetipController@scan'));
Route::get('dogetip/{id}', array('as' => 'dogetip.show', 'uses' => 'DogetipController@show'));

Route::get('giveaway/{id?}', array('as' => 'giveaway.index', 'uses' => 'GiveawayController@index'));
Route::post('giveaway/{id}/enter', array('as' => 'giveaway.enter', 'uses' => "GiveawayController@enter"));
Route::get('giveaway/{id}/success', array('as' => 'giveaway.success', 'uses' => 'GiveawayController@success'));
