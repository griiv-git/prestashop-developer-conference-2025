<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;

class ActionProductFormBuilderModifier extends Hook implements ActionHookInterface
{

    public function action($params): bool
    {
        $formBuilderModifier = new \PrestaShopBundle\Form\FormBuilderModifier();

        /** @var Request $request */
        $request = $params['request'];
        $route = $request->get('_route');

        /** @var FormBuilder $formBuilder */
        $formBuilder = $params['form_builder']->get('details')?->get('references');

        $newProduct = false;
        if ($route === "admin_products_edit" && $request->get('forceDefaultActive')) {
            $newProduct = true;
        }

        $formBuilder->add('code',
            TextType::class,
            [
                'label' => 'Code BGM',
                'disabled' => !$newProduct,
                'required' => true,
            ]
        );

        $formBuilderModifier->addAfter(
            $formBuilder,
            'upc',
            $formBuilder->get('code'),
        );

        return true;
    }
}