<?php

namespace Helper;

use Codeception\Module;
use M2T\App;
use Redis;

class Base extends Module
{
    public function _initialize(): void
    {
        /** @noinspection PhpIncludeInspection */
        require_once codecept_root_dir() . '/vendor/autoload.php';
        new App(
            [
                Redis::class => static function () {
                    $connect = new Redis();
                    $connect->pconnect(App::get('redis')['host']);
                    $connect->select(1);
                    return $connect;
                },
            ]
        );
    }
}
