<?php

declare(strict_types=1);

namespace Griiv\Customer\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Request;


class ConfigurationController extends FrameworkBundleAdminController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request)
    {
        $formDataHandler = $this->get('griiv.producthighlight.form.configuration.data_handler');

        $form = $formDataHandler->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $formDataHandler->save($form->getData());

            if (empty($errors)) {
                $this->addFlash('success', $this->trans('Mise à jour réussi.', \griivproducthighlight::getTranslationDomain()));

                return $this->redirectToRoute('griiv_product_highlight_configuration_index');
            }

            $this->flashErrors($errors);
        }

        return $this->render('@Modules/griivproducthighlight/views/templates/admin/configuration.html.twig', [
            'configurationProductHighlight' => $form->createView(),
            'layoutTitle' => $this->trans('Mise en avant produits', \griivproducthighlight::getTranslationDomain()),
        ]);
    }
}