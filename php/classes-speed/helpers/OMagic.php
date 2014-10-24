<?php

namespace tests\speed\helpers;

class OMagic
{
    public function __construct($props)
    {
        $this->props = $props;
    }

    public function __get($key)
    {
        if (!\array_key_exists($key, $this->props)) {
            throw new \LogicException('error');
        }
        return $this->props[$key];
    }

    public function __set($key, $value)
    {
        if (!\array_key_exists($key, $this->props)) {
            throw new \LogicException('error');
        }
        $this->props[$key] = $value;
    }

    private $props;
}
