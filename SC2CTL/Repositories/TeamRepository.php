<?php

namespace SC2CTL\DotCom\Repositories;

use DB;
use Depotwarehouse\Toolbox\Exceptions\ValidationException;
use SC2CTL\DotCom\EloquentModels\Enrollment;
use SC2CTL\DotCom\EloquentModels\Role;
use SC2CTL\DotCom\EloquentModels\Team;
use SC2CTL\DotCom\Mailers\PasswordReminder;
use SC2CTL\DotCom\Validators\TeamValidator;

class TeamRepository extends BaseRepository
{

    public function __construct(Team $model, TeamValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Create the team, and attach the given user to the team.
     *
     * In order for this function to be successful, the $attributes array *must* contain a 'user_id' key, in addition
     * to all the required fields for a Team.
     *
     * This is transactional, so it will either all work or all fail.
     *
     * @param array $attributes
     * @return Team
     * @throws ValidationException
     * @throws \Exception
     */
    public function create(array $attributes) {
        DB::beginTransaction();

        try {
            /** @var Team $team */
            $team = parent::create($attributes);
            $team->members()->attach($attributes['user_id'], [ 'role_id' => Role::TEAM_OWNER ]);
            DB::commit();
            return $team;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $id
     * @throws \Exception
     * @return int|void
     */
    public function destroy($id) {
        $team = $this->find($id);

        DB::beginTransaction();
        try {
            foreach ($team->members as $member) {
                /** @var Enrollment $enrollment */
                $enrollment = $member->pivot;
                $enrollment->delete();
            }
            $team->delete();
            DB::commit();
            return $id;

        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }


    }

} 