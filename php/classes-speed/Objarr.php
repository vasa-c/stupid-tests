<?php

namespace tests\speed;

class ObjArr extends Base
{
    protected $tests = [
        'object' => 'testObject',
        'array' => 'testArray',
    ];

    public function run()
    {
        $this->log('Object vs Array');
        $this->log('');

        $this->count = 1000;
        $this->objects = [];
        $this->arrays = [];
        for ($i = 0; $i < $this->count; $i++) {
            $a = [
                'one' => $i,
                'two' => $i * 2,
            ];
            $this->arrays[] = $a;
            $this->objects[] = (object)$a;
        }
        $this->measure('Test', $this->count * 10);
    }
    
    protected function testObject()
    {
        $obj = (object)[];
        $obj->sum = 0;
        for ($i = 0; $i < 10; $i++) {
            foreach ($this->objects as $item) {
                foreach ($item as $k => $v) {
                    $obj->sum += $v;
                }
            }
        }
        return $obj->sum;
    }
    
    protected function testArray()
    {
        $arr = [];
        $arr['sum'] = 0;
        for ($i = 0; $i < 10; $i++) {
            foreach ($this->arrays as $item) {
                foreach ($item as $k => $v) {
                    $arr['sum'] += $v;
                }
            }
        }
        return $arr['sum'];
    }

    private $count = 10000;
    
    private $objects;
    
    private $arrays;
}
