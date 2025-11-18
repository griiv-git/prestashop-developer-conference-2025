<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;

class ActionCategoryFormDataProviderData extends Hook implements ActionHookInterface
{
    public function action($params): bool
    {
        if (isset($params['data'], $params['id'])) {
            $category = new \Category((int)$params['id']);
            $params['data']['code'] = $category->code;
        }
        return true;
    }
}