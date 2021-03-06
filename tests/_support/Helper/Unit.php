<?php

namespace Helper;

use Codeception\Module;
use M2T\App;

class Unit extends Module
{
    public function _initialize(): void
    {
        /** @noinspection PhpIncludeInspection */
        require_once codecept_root_dir() . '/vendor/autoload.php';
        new App();
    }
}
