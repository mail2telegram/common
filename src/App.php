<?php

namespace M2T;

use M2T\Worker;
use Mqwerty\DI\Container;
use Psr\Container\ContainerInterface;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

final class App
{
    private static ContainerInterface $dic;

    /**
     * @suppress PhanUndeclaredClassReference
     * @suppress PhanUndeclaredClassMethod
     * @suppress PhanMissingRequireFile
     * @noinspection PhpIncludeInspection
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        // In dev enviroment convert php errors to exceptions (including notice)
        // In prod enviroment see `docker logs`
        if (class_exists(Run::class)) {
            (new Run())
                ->pushHandler(new PlainTextHandler())
                ->register();
        }
        $configInitial = file_exists('./config.initial.php') ? require './config.initial.php' : [];
        $configLocal = file_exists('./config.php') ? require './config.php' : [];
        $config = array_merge($configInitial, $configLocal, $config);
        self::$dic = new Container($config);
    }

    public function run(): void
    {
        self::get(Worker::class)->loop();
    }

    public static function has(string $id): bool
    {
        return self::$dic->has($id);
    }

    public static function get(string $id)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::$dic->get($id);
    }

    public static function build(string $id, array $params = [])
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::$dic->build($id, $params);
    }
}
