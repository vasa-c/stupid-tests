<?php

namespace tests\speed;

class First extends Base
{
    protected $tests = [
        'substr(s,0,1)' => 'testSubstr',
        's[0]===char' => 'testInd',
        '(s!=="") + s[0]' => 'testIndIf',
        'strpos() === 0' => 'testStrpos',
        'regexp' => 'testRegexp',
    ];

    public function run()
    {
        $this->log('Check first char');
        $this->log('');

        $this->strings = [];
        for ($i = 0; $i < $this->count; $i++) {
            $this->strings[] = \md5(\mt_rand(0, $i + 1));
        }
        $this->measure($this->count.' cycles', $this->count);
    }

    protected function testSubstr()
    {
        $res = 0;
        foreach ($this->strings as $s) {
            if (\substr($s, 0, 1) === 'a') {
                $res++;
            }
        }
        return $res;
    }

    protected function testInd()
    {
        $res = 0;
        foreach ($this->strings as $s) {
            if ($s[0] === 'a') {
                $res++;
            }
        }
        return $res;
    }

    protected function testIndIf()
    {
        $res = 0;
        foreach ($this->strings as $s) {
            if (($s !== '') && ($s[0] === 'a')) {
                $res++;
            }
        }
        return $res;
    }

    protected function testStrpos()
    {
        $res = 0;
        foreach ($this->strings as $s) {
            if (\strpos($s, 'a') === 0) {
                $res++;
            }
        }
        return $res;
    }

    protected function testRegexp()
    {
        $res = 0;
        foreach ($this->strings as $s) {
            if (\preg_match('/^a/s', $s)) {
                $res++;
            }
        }
        return $res;
    }

    private $strings;

    private $count = 10000;
}
