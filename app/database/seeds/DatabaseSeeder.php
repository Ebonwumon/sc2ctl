<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
    $this->call('SenGroupSeeder');
    $this->command->info('Sentry Groups Seeded');
		// $this->call('UserTableSeeder');
	}

}

class SenGroupSeeder extends Seeder {
  public function run() {

    DB::table('users_sengroups')->delete(); 
    DB::table('sengroups')->delete();
    
    $group = Sentry::createGroup(array(
          'name' => 'admins',
          'permissions' => array(
            'superuser' => 1,
            'modify_ranks' => 1,
            'edit_teams' => 1,
            'report_matches' => 1,
            'add_members' => 1,
            'remove_members' => 1,
            'register_lineups' => 1
            )));
    $group->persistent = true;
    $group->save();

    $group = Sentry::createGroup(array(
          'name' => 'casters',
          'permissions' => array(
            'vods' => 1,
            'report_matches' => 1
            )));
    $group->persistent = true;
    $group->save();

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'add_team_members' => 1,
            'create_team_lineups' => 1,
            'edit_team' => 1,
            'modify_team_ranks' => 1,
            'register_team_lineups' => 1,
            'report_team_matches' => 1,
            'remove_lineups_members' => 1,
            'remove_team_members' => 1,
            )));
    $group->persistent = true;
    $group->save();

    Sentry::createGroup(array(
          'name' => 'team_captains',
          'permissions' => array(
            'add_team_members' => 1,
            'edit_team_lineup' => 1,
            'modify_team_rank' => 1,
            'register_team_lineup' => 1,
            'remove_lineup_members' => 1,
            )));

    Sentry::createGroup(array(
          'name' => 'team_officers',
          'permissions' => array(
            'report_team_match' => 1,
            )));

    Sentry::createGroup(array(
          'name' => 'team_members',
          'permissions' => array(
            'view_team_lineups' => 1,
            )));

    /*Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));

    Sentry::createGroup(array(
          'name' => 'team_owners',
          'permissions' => array(
            'edit_team' => 1,
            'create_team_lineups')));*/

  }
}

class UserGroupSeeder extends Seeder {
  public function run() {

    foreach (Sentry::findAllUsers() as $user) {
      $user->recalculateGroups();
    }
  }
}
