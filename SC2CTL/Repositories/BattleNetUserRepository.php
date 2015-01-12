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

    /**
     * Checks if there exists a bnet_user using that particular, unique bnet_id.
     *
     * @param $bnet_id
     * @return bool
     */
    public function isAccountUsed($bnet_id)
    {
        return $this->model->where('bnet_id', $bnet_id)->count() > 0;
    }

} 
