<?php

namespace Griiv\Customer\Service;

class MyService
{
    private $inner;

    public function __construct($inner)
    {
        $this->inner = $inner;
    }

    public function doSomething(): string
    {
        $parent = $this->inner->doSomething();
        return "Hello, World! from GCustomer" . PHP_EOL . $parent;
    }
}