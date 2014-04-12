<?php
return array(
    'permissions' => array(
        'admins' => array(
            'superuser' => 1,
            'modify_ranks' => 1,
            'edit_teams' => 1,
            'report_matches' => 1,
            'add_members' => 1,
            'remove_members' => 1,
            'rename_lineups' => 1,
            'register_lineups' => 1,
            'view_rosters' => 1
        ),
        'casters' => array(
            'vods' => 1,
            'report_matches' => 1,
            'view_rosters' => 1
        ),
        'team_owners' => array(
            'add_team_members' => 1,
            'create_team_lineups' => 1,
            'edit_team' => 1,
            'modify_team_ranks' => 1,
            'register_team_lineups' => 1,
            'report_team_matches' => 1,
            'remove_lineups_members' => 1,
            'remove_team_members' => 1,
            'rename_team_lineups' => 1,
            'view_team_rosters' => 1,
        ),
        'team_captains' => array(
            'add_team_members' => 1,
            'edit_team_lineup' => 1,
            'modify_team_rank' => 1,
            'register_team_lineup' => 1,
            'remove_lineup_members' => 1,
        ),
        'team_officers' => array(
            'report_team_match' => 1,
            'rename_lineup' => 1,
        ),
        'team_members' => array(
            'view_roster' => 1,
            'report_match' => 1,
            'wow' => 1,
        ),
    ),
);