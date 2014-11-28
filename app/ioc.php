<?php
// Register our mailer as a model observer of the PasswordReminder.
use Depotwarehouse\OAuth2\Client\Provider\BattleNet;

\SC2CTL\DotCom\EloquentModels\PasswordReminder::observe(new \SC2CTL\DotCom\Mailers\PasswordReminder());

App::bind(BattleNet::class, function () {
    return new BattleNet([
        'clientId' => getenv('BNET_CLIENT_ID'),
        'clientSecret' => getenv('BNET_CLIENT_SECRET'),
        'redirectUri' => getenv("BNET_REDIRECT_URI"),
    ]);
});

App::bind('\domain\interf\GiveawayRepositoryInterface', '\domain\impl\GiveawayRepositoryEloquent');
App::bind('\domain\interf\CodeRepositoryInterface', '\domain\impl\CodeRepositoryEloquent');