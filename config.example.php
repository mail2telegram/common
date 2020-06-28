<?php

use M2T\App;
use M2T\Model\Account;
use M2T\Model\Email;

return [
    'redis' => [
        'host' => 'm2t_redis',
    ],
    'test' => [
        'accounts' => [
            new Account(
                123456,
                [
                    new Email(
                        'mail2telegram.app@gmail.com',
                        'XXXXXX',
                        'imap.gmail.com',
                        993,
                        'ssl',
                        'smtp.gmail.com',
                        465,
                        'ssl'
                    ),
                ]
            ),
        ],
    ],
    Redis::class => static function () {
        static $connect;
        if (null === $connect) {
            $connect = new Redis();
        }
        if (!$connect->isConnected() && !$connect->pconnect(App::get('redis')['host'])) {
            throw new RuntimeException('No Redis connection');
        }
        return $connect;
    },
];
