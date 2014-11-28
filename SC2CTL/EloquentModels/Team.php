<?php

namespace SC2CTL\DotCom\EloquentModels;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Log;

class Team extends BaseModel
{
    use SoftDeletingTrait;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);
    }

    protected $meta = [
        'id' => [self::GUARDED],
        'name' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'tag' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'description' => [self::FILLABLE, self::UPDATEABLE, self::SEARCHABLE],
        'social_fb' => [self::FILLABLE, self::UPDATEABLE],
        'social_twitter' => [self::FILLABLE, self::UPDATEABLE],
        'social_twitch' => [self::FILLABLE, self::UPDATEABLE],
        'website' => [self::FILLABLE, self::UPDATEABLE],
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'team_enrollments', 'team_id', 'user_id')
            ->withPivot('role_id')
            ->withTimestamps();
    }

    public function getQualifiedNameAttribute()
    {
        return "[{$this->tag}] {$this->name}";
    }

    /**
     * Gets the current owner of this team.
     *
     * @return User
     * @throws ModelNotFoundException
     */
    public function getOwner()
    {
        try {
            return $this->members()->wherePivot('role_id', Role::TEAM_OWNER)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            Log::error("Team ID: {$this->id} does not seem to have an owner");
            throw $exception;
        }

    }
}