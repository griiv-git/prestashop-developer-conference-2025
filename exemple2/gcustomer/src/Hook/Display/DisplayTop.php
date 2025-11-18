<?php

namespace Griiv\Customer\Hook\Display;

class DisplayTop extends \Griiv\Prestashop\Module\Contracts\Hook\Hook implements \Griiv\Prestashop\Module\Contracts\Hook\Contracts\DisplayHookInterface
{
    public function __construct(\Context $context, private $service)
    {
        parent::__construct($context);
    }

    public function display($params): string
    {
        $this->service->doSomething();
        return  __CLASS__."::".__METHOD__;
    }
}