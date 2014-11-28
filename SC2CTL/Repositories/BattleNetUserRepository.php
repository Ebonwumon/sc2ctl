<?php

namespace SC2CTL\DotCom\Repositories;

use SC2CTL\DotCom\EloquentModels\BattleNetUser;
use SC2CTL\DotCom\Validators\BattleNetUserValidator;

class BattleNetUserRepository extends BaseRepository
{

    public function __construct(BattleNetUser $model, BattleNetUserValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

} 