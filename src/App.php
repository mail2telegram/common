<?php

namespace M2T;

use M2T\Worker;
use M2T\Service\ServiceManager;
use Psr\Container\ContainerInterface;
use Whoops\Handler\PlainTextHandler;
use Whoops\Run;

final class App
{
    private static ContainerInterface $serviceManager;

    /**
     * @suppress PhanUndeclaredClassReference
     * @suppress PhanUndeclaredClassMethod
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
        $config = array_merge(require './config.php', $config);
        self::$serviceManager = new ServiceManager($config);
    }

    /**
     * @suppress PhanUndeclaredClassReference
     */
    public function run(): void
    {
        self::get(Worker::class)->loop();
    }

    public static function has(string $id): bool
    {
        return self::$serviceManager->has($id);
    }

    public static function get(string $id)
    {
        /** @noinspection PhpUnhandledExceptionInspection */
        return self::$serviceManager->get($id);
    }
}
