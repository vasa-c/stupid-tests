#!/usr/bin/env php
<?php

namespace tests;

use tests\speed\Base;

require_once(__DIR__.'/classes-speed/autoload.php');

$args = $_SERVER['argv'];

if (\count($args) < 2) {
    echo 'Format: ./speed.php <testname>'.\PHP_EOL;
    echo 'Available: '.\implode(', ', Base::getAvailableTests()).\PHP_EOL;
    exit();
}

$testname = \strtolower($args[1]);
$classname = 'tests\speed\\'.\ucfirst($testname);
if (!\class_exists($classname)) {
    echo 'Test '.$testname.' is not found'.\PHP_EOL;
    echo 'Available: '.\implode(',', Base::getAvailableTests()).\PHP_EOL;
    exit();
}

echo 'PHP v'.\PHP_VERSION.\PHP_EOL;
$test = new $classname();
$test->run();
