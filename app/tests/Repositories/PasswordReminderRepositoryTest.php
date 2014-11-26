<?php


class PasswordReminderRepositoryTest extends PHPUnit_Framework_TestCase
{

    public function test_it_returns_random_token()
    {
        $repository = new \SC2CTL\DotCom\Repositories\PasswordReminderRepository(
            new \SC2CTL\DotCom\EloquentModels\PasswordReminder(),
            new \SC2CTL\DotCom\Validators\PasswordReminderValidator()
        );
        $token1 = $repository->generateToken();
        $token2 = $repository->generateToken();

        $this->assertNotEquals($token1, $token2);
    }

    public function test_token_starts_with_string()
    {
        $repository = new \SC2CTL\DotCom\Repositories\PasswordReminderRepository(
            new \SC2CTL\DotCom\EloquentModels\PasswordReminder(),
            new \SC2CTL\DotCom\Validators\PasswordReminderValidator()
        );

        $this->assertStringStartsWith("reminder_", $repository->generateToken());
    }

}
 