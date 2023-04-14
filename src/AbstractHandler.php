<?php

namespace Kali\Elastic;

use Monolog\Logger;
use Monolog\Handler\AbstractProcessingHandler as Handler;

abstract class AbstractHandler extends Handler
{
    public static function boot($level = Logger::DEBUG, bool $bubble = true) {
        parent::$level = Logger::toMonologLevel($level);
        parent::$bubble = $bubble;
    }

    abstract protected function write(array $record): void;
}
