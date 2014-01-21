<?php

namespace tests\speed;

class Concat extends Base
{
    protected $tests = [
        'concat' => 'testConcat',
        'implode' => 'testImplode',
    ];

    public function run()
    {
        $this->log('Concat strings');
        $this->log('');

        $this->count = 10;
        $this->fill($this->count, 5);
        $this->measure('Small amount (10) of short (5) strings', $this->count);

        $this->count = 10;
        $this->fill($this->count, 500);
        $this->measure('Small amount (10) of long (500) strings', $this->count);
        
        $this->count = 1000;
        $this->fill($this->count, 5);
        $this->measure('Large amount (1000) of short (5) strings', $this->count);
        
        $this->count = 1000;
        $this->fill($this->count, 500);
        $this->measure('Large amount (1000) of long (500) strings', $this->count);
        
    }
    
    private function fill($count, $len)
    {
        $this->strings = [];
        for ($i = 0; $i < $count; $i++) {
            $s = '';
            while (\strlen($s) < $len) {
                $s .= \md5($i.$s);
            }
            $s = \substr($s, 0, $len);
            $this->strings[] = $s;
        }
    }

    protected function testConcat()
    {
        $res = '';
        foreach ($this->strings as $s) {
            $res .= $s;
        }
    }
    
    protected function testImplode()
    {
        $res = [];
        foreach ($this->strings as $s) {
            $res[] = $s;
        }
        $res = \implode('', $res);
    }

    private $strings;

    private $count = 10000;
}
