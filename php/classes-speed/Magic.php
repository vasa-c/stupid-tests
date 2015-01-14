<?php

namespace tests\speed;

use tests\speed\helpers\OPublic;
use tests\speed\helpers\OMagic;

class Magic extends Base
{
    protected $tests = [
        'public' => 'testPublic',
        'magic' => 'testMagic',
    ];

    public function run()
    {
        $this->log('$this->publicVar vs $this->__get');
        $this->log('');

        $this->count = 10000;
        $this->vals = [];
        for ($i = 0; $i < $this->count; $i++) {
            $op = new OPublic();
            $op->one = $i;
            $op->two = $i * 2;
            $this->opublic[] = $op;
            $props = [
                'one' => $i,
                'two' => $i * 2,
                'sum' => null,
            ];
            $this->omagic[] = new OMagic($props);
        }
        $this->measure('Test', $this->count);
    }

    protected function testPublic()
    {
        $res = 0;
        foreach ($this->opublic as $obj) {
            $obj->sum = $obj->one + $obj->two;
            $res += $obj->sum;
        }
        return $res;
    }

    protected function testMagic()
    {
        $res = 0;
        foreach ($this->omagic as $obj) {
            $obj->sum = $obj->one + $obj->two;
            $res += $obj->sum;
        }
        return $res;
    }

    private $count = 10000;

    private $opublic = [];

    private $omagic = [];

    private $vals = [];
}
