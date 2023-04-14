<?php

namespace Elastic;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\AbstractHandler as Handler;

abstract class AbstractHandler extends Handler
{
    public static function boot(int|string|Level $level = Level::Debug, bool $bubble = true) {
        self::setLevel($level);
        self::$bubble = $bubble;
    }

    public static function setLevel(int|string|Level $level): self
    {
        self::$level = Logger::toMonologLevel($level);

        return self;
    }
}
