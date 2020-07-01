<?php

namespace Helper;

use Codeception\Module;
use M2T\Model\Account;
use M2T\Model\Email;

class Data extends Module
{
    /**
     * @return \M2T\Model\Account[]
     */
    public function accountProvider(): array
    {
        return [
            new Account(
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
            ),
            new Account(123, []),
        ];
    }
}
