<?php

namespace SC2CTL\DotCom\Repositories;

use SC2CTL\DotCom\EloquentModels\User;
use SC2CTL\DotCom\Validators\UserValidator;

/**
 * Class UserRepository
 * @package SC2CTL\DotCom\Repositories
 * @method User create(array $attributes)
 */
class UserRepository extends BaseRepository
{

    public function __construct(User $model, UserValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

} 
