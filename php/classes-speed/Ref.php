<?php

namespace tests\speed;

class Ref extends Base
{
    protected $tests = [
        '$this->prop' => 'testProp',
        '$prop = &' => 'testRef',
    ];

    public function run()
    {
        $this->log('$this->prop va $prop = &$this->prop');
        $this->log('');

        $this->count = 10000;
        $this->vals = [];
        for ($i = 0; $i < $this->count; $i++) {
            $this->vals[] = \mt_rand(0, 1000);
        }
        $this->measure('Test', $this->count);
    }
    
    protected function testProp()
    {
        $this->prop = 0;
        foreach ($this->vals as $val) {
            $this->prop += $val;
        }
        return $this->prop;
    }
    
    protected function testRef()
    {
        $this->prop = 0;
        $prop = &$this->prop;
        foreach ($this->vals as $val) {
            $prop += $val;
        }
        return $this->prop;
    }

    private $vals;

    private $count = 10000;
    
    private $prop;
}
