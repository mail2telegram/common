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
        if (!$connect->isConnected()) {
            $config = App::get('redis');
            if (!$connect->pconnect(
                $config['host'],
                $config['port'] ?? 6379,
                $config['timeout'] ?? 0.0,
                $config['persistentId'] ?? null,
                $config['retryInterval'] ?? 0,
                $config['readTimeout'] ?? 0.0
            )) {
                throw new RedisException('No Redis connection');
            }
        }
        return $connect;
    },
];