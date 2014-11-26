<?php

namespace SC2CTL\DotCom\Mailers;

use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use Mail;
use URL;


/**
 * Class PasswordReminder
 *
 * This class handles sending of emails whenever a user requests a password reset.
 * It should be registered as a model observer for the PasswordReminder model, which will in turn call the created method
 * once it has been serialized properly to the database.
 *
 * @package SC2CTL\DotCom\Mailers
 */
class PasswordReminder
{

    const EMAIL_VIEW = "emails.reminder";

    public function created(\SC2CTL\DotCom\EloquentModels\PasswordReminder $model)
    {
        $email = $model->email;

        Mail::send(
            self::EMAIL_VIEW,
            [ 'reset_link' => URL::route('reminder.finalize_password', $model->token) ],
            function (Message $message) use ($email) {
                $message->to($email)->subject("SC2CTL Password Reset");
            }
        );
    }

}