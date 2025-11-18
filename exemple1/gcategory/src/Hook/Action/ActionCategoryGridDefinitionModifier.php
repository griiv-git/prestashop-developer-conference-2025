<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinition;

class ActionCategoryGridDefinitionModifier extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        /** @var GridDefinition $gridDefinition */
        $gridDefinition = $params['definition'];
        $columns = $gridDefinition->getColumns();
        $codeColumn = (new DataColumn('code'))->setName('code')->setOptions(['field' => 'code']);

        $columns->addAfter('name', $codeColumn);

        $gridDefinition->setColumns($columns);;

        return true;
    }
}