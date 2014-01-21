<?php

namespace tests\speed;

\spl_autoload_register(
    function ($classname) {
        $prefix = __NAMESPACE__.'\\';
        if (\strpos($classname, $prefix) === 0) {
            $short = \substr($classname, \strlen($prefix));
            $filename = __DIR__.'/'.\str_replace('\\', '/', $short).'.php';
            if (\is_file($filename)) {
                require_once($filename);
            }
        }
    }
);
