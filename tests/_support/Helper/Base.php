<?php

namespace Helper;

use Codeception\Module;
use M2T\App;
use M2T\Model\Account;
use M2T\Model\Email;

class Base extends Module
{
    public function _initialize(): void
    {
        /** @noinspection PhpIncludeInspection */
        require_once codecept_root_dir() . '/vendor/autoload.php';
        new App();
    }

    public function accountProvider(): Account
    {
        return new Account(
            123456,
            [
                new Email(
                    'mail2telegram.app@gmail.com',
                    'XXX',
                    'imap.gmail.com',
                    993,
                    'ssl',
                    'smtp.gmail.com',
                    465,
                    'ssl'
                ),
            ]
        );
    }
}
