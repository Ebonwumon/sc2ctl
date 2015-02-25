<?php

namespace SC2CTL\DotCom\EloquentModels;

use Config;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Log;

class Team extends BaseModel
{
    use SoftDeletingTrait;

    public function lineups()
    {
        //TODO
        //return $this->belongsTo(\Lineup::class);
    }

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
     * Get the web-compatible path to the team's logo image.
     *
     * @return string
     */
    public function getLogoImgAttribute()
    {
        $img_path = Config::get('storage.team_profile_img_path');

        if (file_exists(public_path() . $img_path . "tid_{$this->id}.jpg")) {
            return $img_path . "tid_{$this->id}.jpg";
        }
        return $img_path . "tid_0.jpg";
    }

    /**
     * Get the web-compatible path to the team's banner image.
     *
     * @return string
     */
    public function getBannerImgAttribute()
    {
        $img_path = Config::get('storage.team_profile_banner_path');

        if (file_exists(public_path() . $img_path . "tid_{$this->id}.jpg")) {
            return $img_path . "tid_{$this->id}.jpg";
        }
        return $img_path . "tid_0.jpg";
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
