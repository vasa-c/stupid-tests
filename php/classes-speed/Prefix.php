<?php

namespace tests\speed;

class Prefix extends Base
{
    protected $tests = [
        'strpos' => 'testStrpos',
        'substr(strlen)' => 'testSublen',
        'substr(const)' => 'testSubconst',
        'regexp' => 'testRegexp',
    ];

    public function run()
    {
        $this->log('Find prefix');
        $this->log('');

        $this->strings = [];
        for ($i = 0; $i < $this->count; $i++) {
            switch ($i % 4) {
                case 0:
                    $this->strings[] = '';
                    break;
                case 1:
                    $this->strings[] = 'http://'.\substr(\md5($i), 0, 5);
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
                    $this->strings[] = 'http://'.\str_repeat(\md5($i), 100);
                    break;
                default:
                    $this->strings[] = \str_repeat(\md5($i), 100);
            }
        }
        $this->measure('Test big strings (3 200 byte)', $this->count);
    }

    protected function testStrpos()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if (\strpos($str, 'http://') === 0) {
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

    protected function testSublen()
    {
        $prefix = 'http://';
        $e = 0;
        foreach ($this->strings as $str) {
            if (\substr($str, 0, \strlen($prefix)) === $prefix) {
                $e++;
            }
        }
        return $e;
    }

    protected function testSubconst()
    {
        $e = 0;
        foreach ($this->strings as $str) {
            if (\substr($str, 0, 7) === 'http://') {
                $e++;
            }
        }
        return $e;
    }

    protected function testRegexp()
    {
        $e = 0;
        $prefix = 'http://';
        $reg = '/^'.\preg_quote($prefix, '/').'/s';
        foreach ($this->strings as $str) {
            if (\preg_match($reg, $str)) {
                $e++;
            }
        }
        return $e;
    }

    private $strings;

    private $count = 10000;
}
