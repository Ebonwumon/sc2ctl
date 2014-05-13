<?php

App::bind('\domain\interf\GiveawayRepositoryInterface', '\domain\impl\GiveawayRepositoryEloquent');
App::bind('\domain\interf\CodeRepositoryInterface', '\domain\impl\CodeRepositoryEloquent');