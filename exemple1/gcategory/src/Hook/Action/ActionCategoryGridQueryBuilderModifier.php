<?php

namespace Griiv\Category\Hook\Action;

use Doctrine\DBAL\Query\QueryBuilder;
use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use PrestaShop\PrestaShop\Core\Search\Filters\CategoryFilters;

class ActionCategoryGridQueryBuilderModifier extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        /** @var QueryBuilder $searchQueryBuilder */
        $searchQueryBuilder = $params['search_query_builder'];

        $searchQueryBuilder->addSelect('c.code');
        return true;
    }
}