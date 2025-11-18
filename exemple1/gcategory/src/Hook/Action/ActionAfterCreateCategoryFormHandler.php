<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;

class ActionAfterCreateCategoryFormHandler extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        $idCategory = $params['id'];
        $category = new \Category($idCategory);
        $category->code = $params['form_data']['code'];

        $category->save();
        return true;
    }
}