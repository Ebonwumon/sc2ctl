<?php

namespace SC2CTL\DotCom\EloquentModels;

use Config;
use Illuminate\Auth\UserInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class User extends BaseModel implements UserInterface
{
    use SoftDeletingTrait;

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

    public function getProfileImgAttribute()
    {
        $img_path = Config::get('storage.user_profile_img_path');

        if (file_exists(public_path() . $img_path . "uid_{$this->id}.jpg")) {
            return $img_path . "uid_{$this->id}.jpg";
        }
        return $img_path . "uid_0.jpg";
    }

    public function bnet()
    {
        return $this->hasOne(BattleNetUser::class, 'user_id', 'id');
    }

    public function team()
    {
        return $this->belongsToMany(Team::class, 'team_enrollments', 'user_id', 'team_id');
    }

    /**
     * Get the team the user is enrolled on.
     *
     * @return Team
     */
    public function getTeam()
    {
        return $this->team()->first();
    }

    /**
     * Is the user on a team right now?
     *
     * @return bool
     */
    public function currentlyOnATeam()
    {
        return $this->team()->count() > 0;
    }

    public function hasConnectedBattleNet()
    {
        return $this->bnet()->count() > 0;
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
