<?php
// Register our mailer as a model observer of the PasswordReminder.
\SC2CTL\DotCom\EloquentModels\PasswordReminder::observe(new \SC2CTL\DotCom\Mailers\PasswordReminder());

App::bind('\domain\interf\GiveawayRepositoryInterface', '\domain\impl\GiveawayRepositoryEloquent');
App::bind('\domain\interf\CodeRepositoryInterface', '\domain\impl\CodeRepositoryEloquent');