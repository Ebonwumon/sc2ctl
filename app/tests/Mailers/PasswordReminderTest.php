<?php


class PasswordReminderTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $reminderMailer = new \SC2CTL\DotCom\Mailers\PasswordReminder();
        \SC2CTL\DotCom\EloquentModels\PasswordReminder::observe($reminderMailer);
        $this->createDatabase();
    }

    private function createDatabase()
    {
        Artisan::call('migrate');
    }

    public function test_it_fires_on_event()
    {
        Mail::shouldReceive('send')->once();
        $reminder = \SC2CTL\DotCom\EloquentModels\PasswordReminder::create([
            'email' => 'adult@sc2ctl.com',
            'token' => 'mock_token',
        ]);
    }

}
 