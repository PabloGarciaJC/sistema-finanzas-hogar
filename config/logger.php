<?php

use Monolog\Logger;
use Monolog\Level;
use Monolog\Handler\StreamHandler;

class LoggerWrapper
{
    private static $instance = null;
    private $log;
    private $handler;

    private function __construct($name = 'logs', $file = __DIR__ . '/.log/app.log', $level = Level::Debug)
    {
        $this->log = new Logger($name);
        $this->handler = new StreamHandler($file, $level);
        $this->log->pushHandler($this->handler);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new LoggerWrapper();
        }
        return self::$instance;
    }

    public function debug($message)
    {
        $this->log->debug($message);
    }

    public function info($message)
    {
        $this->log->info($message);
    }

    public function notice($message)
    {
        $this->log->notice($message);
    }

    public function warning($message)
    {
        $this->log->warning($message);
    }

    public function error($message)
    {
        $this->log->error($message);
    }

    public function critical($message)
    {
        $this->log->critical($message);
    }

    public function alert($message)
    {
        $this->log->alert($message);
    }

    public function emergency($message)
    {
        $this->log->emergency($message);
    }
}

