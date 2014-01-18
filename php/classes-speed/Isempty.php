<?php

namespace tests\speed;

class Isempty extends Base
{
    protected $tests = [
        'empty($str)' => 'testEmpty',
        '$str === ""' => 'testEquiv',
        '$str == ""' => 'testEqual',
        'strlen($str)' => 'testStrlen',
    ];

    public function run()
    {
        $this->log('Check if string is empty');
        $this->log('WARNING: empty("0") === TRUE');
        $this->log('');

        $this->strings = [];
        for ($i = 0; $i < $this->count; $i++) {
            switch ($i % 4) {
                case 0:
                    $this->strings[] = '';
                    break;
                case 1:
                    $this->strings[] = '0';
                    break;
                default:
                    $this->strings[] = \substr(\md5($i), 0, 5);
            }
        }
        $this->measure('Test small strings', $this->count);

        $this->strings = [];
        for ($i = 0; $i < $this->count; $i++) {
            switch ($i % 4) {
                case 0:
                    $this->strings[] = '';
                    break;
                case 1:
                    $this->strings[] = '0';
                    break;
                default:
                    $this->strings[] = \str_repeat(\md5($i), 100);
            }
        }
        $this->measure('Test big strings (3 200 byte)', $this->count);
    }

    protected function testEmpty()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if (empty($str)) {
                $e++;
            }
        }
        return $e;
    }

    protected function testEquiv()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if ($str === '') {
                $e++;
            }
        }
        return $e;
    }

    protected function testEqual()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if ($str == '') {
                $e++;
            }
        }
        return $e;
    }

    protected function testStrlen()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if (\strlen($str) === 0) {
                $e++;
            }
        }
        return $e;
    }

    private $strings;

    private $count = 10000;
}
