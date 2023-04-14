<?php

namespace Kali\Elastic;

use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\AbstractHandler as Handler;

abstract class AbstractHandler extends Handler
{
    public static function boot(int|string|Level $level = Level::Debug, bool $bubble = true) {
        self::$level = Logger::toMonologLevel($level);
        self::$bubble = $bubble;
    }
    
}
