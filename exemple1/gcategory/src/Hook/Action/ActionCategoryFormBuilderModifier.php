<?php

namespace Griiv\Category\Hook\Action;

use Griiv\Prestashop\Module\Contracts\Hook\Contracts\ActionHookInterface;
use Griiv\Prestashop\Module\Contracts\Hook\Hook;
use PrestaShopBundle\Form\Admin\Type\SwitchType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\HttpFoundation\Request;

class ActionCategoryFormBuilderModifier extends Hook implements ActionHookInterface
{

    /**
     * @param array $params
     * @return bool
     */
    public function action($params): bool
    {
        $formBuilderModifier = new \PrestaShopBundle\Form\FormBuilderModifier();

        /** @var Request $request */
        $request = $params['request'];
        $route = $request->get('_route');

        $disabled = ($route === "admin_categories_edit");
        /** @var FormBuilder $formBuilder */
        $formBuilder = $params['form_builder'];

        $formBuilder->add('code',
            TextType::class,
            [
                'label' => 'Code',
                'disabled' => $disabled,
                'required' => true,
            ]);
        $formBuilderModifier->addAfter(
            $formBuilder,
            'name',
            $formBuilder->get('code'),
        );

        return true;
    }
}