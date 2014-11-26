<?php

namespace SC2CTL\DotCom\EloquentModels;

use Illuminate\Auth\UserInterface;

class User extends BaseModel implements UserInterface
{
    protected $hidden = ['password'];

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [self::GUARDED],
        'username' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'email' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'password' => [self::FILLABLE, self::UPDATEABLE]
    ];

    public function currentlyOnTeam()
    {
        return false; // TODO
    }

    public function hasConnectedBattleNet()
    {
        return false;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
