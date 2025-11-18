<?php

namespace Griiv\Category\Hook\Display;

use Griiv\Category\Service\MyService;

class DisplayTop extends \Griiv\Prestashop\Module\Contracts\Hook\Hook implements \Griiv\Prestashop\Module\Contracts\Hook\Contracts\DisplayHookInterface
{
    public function __construct(\Context $context, public $myService)
    {
        parent::__construct($context);
    }

    public function display($params): string
    {
        echo $this->myService->doSomething();
        echo "\n";
        echo "<br/>";
        echo "<br/>";
        return  __CLASS__."::".__METHOD__;
    }
}