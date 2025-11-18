<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use Symfony\Component\HttpFoundation\Request;

class ActionProductFormDataProviderData extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        //forceDefaultActive
        /** @var Request $request */
        $request = $params['request'];
        $route = $request->get('_route');

        if ($route === "admin_products_edit" && !$request->get('forceDefaultActive')) {
            $idProduct = (int)$params['id'];
            $product = new \Product($idProduct);
            $params['data']['details']['references']['code'] = $product->code;
        }


        return true;
    }
}