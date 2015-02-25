<?php

namespace SC2CTL\DotCom\EloquentModels;

use Carbon\Carbon;
use SC2CTL\PasswordReminderExpiredException;

class PasswordReminder extends BaseModel
{
    const SECONDS_TO_EXPIRE = 600;

    public $table = "password_reminders";

    public function setUpdatedAtAttribute($value)
    {
        // We do nothing, we don't want updated at timestamps.
    }

    public function isStillValid()
    {
        /** @var Carbon $created_at */
        $created_at = $this->created_at;
        if (Carbon::now()->diffInSeconds($created_at) > self::SECONDS_TO_EXPIRE) {
            return false;
        }
        return true;
    }
} 
