<?php

namespace SC2CTL\DotCom\Repositories;

use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SC2CTL\DotCom\EloquentModels\User;
use SC2CTL\DotCom\Validators\UserValidator;

/**
 * Class UserRepository
 * @package SC2CTL\DotCom\Repositories
 */
class UserRepository extends BaseRepository
{

    public function __construct(User $model, UserValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Create a new user record (including hashing of the password).
     *
     * @param array $attributes
     * @return User
     * @throws \Depotwarehouse\Toolbox\Exceptions\ValidationException
     */
    public function create(array $attributes)
    {
        $this->validator->validate($attributes);

        $attributes['password'] = Hash::make($attributes['password']);

        // We're only going to pass in the explicitly fillable fields - we don't want MassAssignmentExceptions!
        $attributes = array_only($attributes, $this->getFillableFields());
        $model = $this->model->create($attributes);

        return $model;
    }

    /**
     * @param mixed $id
     * @param array $attributes
     * @return int|void
     * @throws \Depotwarehouse\Toolbox\Exceptions\ValidationException
     */
    public function update($id, array $attributes = array()) {
        // Throws a ModelNotFoundException if the model does not exist
        $object = $this->find($id);

        // Throws a ValidationException if validation fails
        $this->validator->updateValidate($attributes, $id);

        $attributes['password'] = Hash::make($attributes['password']);

        $attributes = array_only($attributes, $this->getUpdateableFields());
        $object->update($attributes);
    }

    /**
     * Finds a user by their Email address.
     *
     * @param $email
     * @throws ModelNotFoundException
     * @return User
     */
    public function findByEmail($email)
    {
        return $this->model->newQuery()->where('email', $email)->firstOrFail();
    }

} 
