<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;


class ActionAfterUpdateCategoryFormHandler extends Hook implements ActionHookInterface
{
    /**
     * @param array $params
     * @return bool
     */
    public function action($params): bool
    {
        return true;
    }
}