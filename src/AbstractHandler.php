<?php

namespace Kali\Elastic;

use Monolog\Logger;
use Monolog\Handler\AbstractHandler as Handler;

abstract class AbstractHandler extends Handler
{
    public static function boot($level = Logger::Debug, bool $bubble = true) {
        self::$level = Logger::toMonologLevel($level);
        self::$bubble = $bubble;
    }
    
}
