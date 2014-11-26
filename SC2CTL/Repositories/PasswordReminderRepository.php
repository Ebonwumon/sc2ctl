<?php

namespace SC2CTL\DotCom\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use SC2CTL\DotCom\EloquentModels\PasswordReminder;
use SC2CTL\DotCom\Exceptions\PasswordReminderExpiredException;
use SC2CTL\DotCom\Validators\PasswordReminderValidator;

class PasswordReminderRepository extends BaseRepository
{

    public function __construct(PasswordReminder $model, PasswordReminderValidator $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Generates a unique token to send in an email.
     *
     * @return string
     */
    public function generateToken()
    {
        return uniqid("reminder_");
    }

    /**
     * Creates a new PasswordReminder in the database.
     *
     * @param array $attributes
     * @return PasswordReminder
     */
    public function create(array $attributes)
    {
        $attributes = array_merge($attributes, ['token' => $this->generateToken()]);
        return parent::create($attributes);
    }

    /**
     * Finds a password reminder by it's token.
     *
     * @param $token
     * @return PasswordReminder
     * @throws PasswordReminderExpiredException
     * @throws ModelNotFoundException
     */
    public function findByToken($token)
    {
        /** @var PasswordReminder $reminder */
        $reminder = $this->model->newQuery()->where('token', $token)->firstOrFail();
        if (!$reminder->isStillValid()) {
            throw new PasswordReminderExpiredException();
        }

        return $reminder;
    }

} 