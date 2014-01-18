<?php

namespace tests\speed;

abstract class Base
{
    /**
     * @param callable $logger [optional]
     */
    final public function __construct($logger = true)
    {
        if ($logger === true) {
            $logger = [$this, 'defaultLogger'];
        }
        $this->logger = $logger;
    }

    abstract public function run();

    /**
     * @param string $title
     * @param int $count
     */
    public function measure($title = null, $count = 1, $mul = 1000000, $sec = 'us', $dec = 2)
    {
        $this->log($title);
        $results = [];
        $returns = [];
        $mt = \microtime(true);
        foreach ($this->tests as $name => $method) {
            $mt = \microtime(true);
            $r = $this->$method();
            $mt = \microtime(true) - $mt;
            $results[$name] = (($mt / $count) * $mul);
            $returns[$name] = $r;
        }
        foreach ($results as $name => $time) {
            $line = \sprintf('% -15s', $name).' ';
            $line .= \number_format($time, $dec, ',', ' ').' '.$sec;
            $line .= ' ['.$returns[$name].']';
            $this->log($line);
        }
    }

    /**
     * @param string $message
     */
    final protected function log($message)
    {
        if ($this->logger) {
            \call_user_func($this->logger, $message);
        }
    }

    /**
     * @param string $message
     */
    private function defaultLogger($message)
    {
        echo $message.\PHP_EOL;
    }

    /**
     * @return array
     */
    public static function getAvailableTests()
    {
        $ignore = ['autoload', 'base'];
        $tests = [];
        foreach (\glob(__DIR__.'/*.php') as $filename) {
            $name = \strtolower(\basename($filename, '.php'));
            if (!\in_array($name, $ignore)) {
                $tests[] = $name;
            }
        }
        \sort($tests);
        return $tests;
    }

    /**
     * @var array
     */
    protected $tests;

    /**
     * @var callable
     */
    private $logger;
}
