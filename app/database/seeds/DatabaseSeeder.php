<?php

class DatabaseSeeder extends Seeder
{

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

class SenGroupSeeder extends Seeder
{
    public function run()
    {

        DB::table('users_sengroups')->delete();
        DB::table('sengroups')->delete();

        $group = Sentry::createGroup(
            array(
                'name' => 'admins',
                'permissions' => Config::get("groups.permissions.admins")
            )
        );
        $group->persistent = true;
        $group->save();

        $group = Sentry::createGroup(
            array(
                'name' => 'casters',
                'permissions' => Config::get("groups.permissions.casters")
            )
        );
        $group->persistent = true;
        $group->save();

        Sentry::createGroup(array(
            'name' => 'team_owners',
            'permissions' => Config::get("groups.permissions.team_owners")
        ));
        $group->persistent = true;
        $group->save();

        Sentry::createGroup(array(
            'name' => 'team_captains',
            'permissions' => Config::get("groups.permissions.team_captains"),
        ));

        Sentry::createGroup(array(
            'name' => 'team_officers',
            'permissions' => Config::get("groups.permissions.team_officers"),
        ));

        Sentry::createGroup(array(
            'name' => 'team_members',
            'permissions' => Config::get("groups.permissions.team_members")));

    }
}

class UserGroupSeeder extends Seeder
{
    public function run()
    {

        foreach (Sentry::findAllUsers() as $user) {
            $user->recalculateGroups();
        }
    }
}
