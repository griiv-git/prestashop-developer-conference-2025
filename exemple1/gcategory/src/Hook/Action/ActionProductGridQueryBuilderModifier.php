<?php

namespace Griiv\Category\Hook\Action;

use Doctrine\DBAL\Query\QueryBuilder;
use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;

class ActionProductGridQueryBuilderModifier extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        /** @var QueryBuilder $searchQueryBuilder */
        $searchQueryBuilder = $params['search_query_builder'];

        $searchQueryBuilder->addSelect('p.code');
        /* @var $searchCriteria \PrestaShop\PrestaShop\Core\Search\Filters\ProductFilters */
        $searchCriteria = $params['search_criteria'];

        foreach ($searchCriteria->getFilters() as $filterName => $filterValue) {
            if ($filterName === 'code') {
                $searchQueryBuilder->andWhere('p.code LIKE :code');
                $searchQueryBuilder->setParameter('code', '%' . $filterValue . '%');
            }
        }

        return true;
    }
}
