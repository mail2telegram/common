<?php

use M2T\App;

return [
    'redis' => [
        'host' => 'm2t_redis',
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
