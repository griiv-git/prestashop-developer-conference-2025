<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;

class ActionAfterUpdateProductFormHandler extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        return true;
    }
}