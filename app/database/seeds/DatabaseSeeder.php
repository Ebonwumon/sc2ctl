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
        //$this->call('SenGroupSeeder');
        //$this->command->info('Sentry Groups Seeded');
        $this->call('MapSeeder');
        $this->command->info('Seeded Maps');
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

class MapSeeder extends Seeder
{
    public function run()
    {
        Map::create(array('name' => "Habitation Station LE", "path" => "/maps/400px-Habitation_Station.jpg"));
        Map::create(array('name' => "King Sejong Station LE", "path" => "/maps/800px-King_Sejong_Station_LE.jpg"));
        Map::create(array('name' => "Overgrowth LE", "path" => "/maps/400px-Overgrowth.jpg"));
        Map::create(array('name' => "Merry Go Round LE", "path" => "/maps/400px-Merry_Go_Round.jpg"));
        Map::create(array('name' => "Waystation LE", "path" => "/maps/400px-Waystation.jpg"));
        Map::create(array('name' => "Galaxy - Veridian", "path" => "/maps/400px-Veridian.jpg"));
        Map::create(array('name' => "Galaxy - Bloodmist", "path" => "/maps/bloodmist.jpg"));

        $round = SwissRound::find(22);
    }
}
