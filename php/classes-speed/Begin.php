<?php

namespace tests\speed;

class Begin extends Base
{
    protected $tests = [
        'strpos' => 'testStrpos',
        'substr' => 'testSubstr',
        'mbstrpos' => 'testMbStrpos',
        'mbsubstr' => 'testMbSubstr',
    ];

    public function run()
    {
        $this->log('Check begin');
        $this->log('');

        $this->count = 3000;
        $this->haystack = $this->getMd5(0);
        $this->needles = [];
        $a = $this->getMd5(0);
        $b = $this->getMd5(1);
        $c = $this->getMd5(2);
        for ($i = 0; $i < 1000; $i++) {
            $this->needles[] = $a;
            $this->needles[] = $b;
            $this->needles[] = $c;
        }
        $this->measure('Short haystack (64) and long needle (32)', $this->count);
        $this->needles = [];
        for ($i = 0; $i < $this->count; $i++) {
            $this->needles[] = $this->getMd5($i % 3);
        }
        $this->haystack = implode('', \array_slice($this->needles, 0, 2000));
        $this->measure('Long haystack ('.strlen($this->haystack).') and long needle (32)', $this->count);
        foreach ($this->needles as &$n) {
            $n = \substr($n, 0, 2);
        }
        unset($n);
        $this->measure('Long haystack ('.strlen($this->haystack).') and short needle (2)', $this->count);
    }

    public function testStrpos()
    {
        $r = 0;
        $h = $this->haystack;
        foreach ($this->needles as $n) {
            $r += (strpos($h, $n) === 0) ? 1 : 0;
        }
        return $r;
    }

    public function testSubstr()
    {
        $r = 0;
        $h = $this->haystack;
        foreach ($this->needles as $n) {
            $r += (substr($h, 0, strlen($n)) === $n) ? 1 : 0;
        }
        return $r;
    }

    public function testMbStrpos()
    {
        $r = 0;
        $h = $this->haystack;
        foreach ($this->needles as $n) {
            $r += (mb_strpos($h, $n, 0, 'UTF-8') === 0) ? 1 : 0;
        }
        return $r;
    }

    public function testMbSubstr()
    {
        $r = 0;
        $h = $this->haystack;
        foreach ($this->needles as $n) {
            $r += (mb_substr($h, 0, mb_strlen($n, 'UTF-8'), 'UTF-8') === $n) ? 1 : 0;
        }
        return $r;
    }

    private function getMd5($i)
    {
        $r = md5($i);
        return str_replace('a', 'а', $r); // lat to cyr
    }

    private $count = 1000;

    private $haystack, $needles;
}
