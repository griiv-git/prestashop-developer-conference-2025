<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinition;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ActionProductGridDefinitionModifier extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        /** @var GridDefinition $gridDefinition */
        $gridDefinition = $params['definition'];
        $columns = $gridDefinition->getColumns();
        $codeColumn = (new DataColumn('code'))->setName('Code BGM')->setOptions(['field' => 'code']);

        $columns->addAfter('name', $codeColumn);

        $gridDefinition->setColumns($columns);;
        $filters = $gridDefinition->getFilters();

        $filters->add( (new Filter('code', TextType::class))
            ->setTypeOptions([
                'required' => false,
                'attr' => [
                    'placeholder' => 'Code BGM',
                ],
            ])
            ->setAssociatedColumn('code'));

        return true;
    }
}