<?php

declare(strict_types=1);

namespace Griiv\Customer\Form\Configuration;

use Context;
use Db;
use PrestaShopBundle\Form\Admin\Type\TranslatableType;
use PrestaShopBundle\Form\Admin\Type\TranslatorAwareType;
use Shop;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Choice;

class ConfigurationForm extends TranslatorAwareType
{

    public const GRIIV_CUSTOMER_FORM_FIELD_1 = 'GRIIV_CUSTOMER_FORM_FIELD_1';
    public const GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS = 'GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS';

    public const GRIIV_CUSTOMER_HIGHLIGHT_LINK = 'GRIIV_CUSTOMER_HIGHLIGHT_LINK';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('GRIIV_CUSTOMER_FORM_FIELD_1', TranslatableType::class, [
                'type' => TextType::class,
                'label' => $this->trans('Titre de la section'),
                'attr' => [
                    'placeholder' => 'Meilleures ventes',
                ],
                'locales' => \Language::getLanguages(),
            ])
            ->add('GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS', ChoiceType::class, [
            'multiple' => true,
            'choices'  => $this->getProducts(),
            'placeholder' => $this->trans('Choose products'),
            'choice_translation_domain' => \griivproducthighlight::getTranslationDomain(),
            "empty_data" => [],
            'label' => $this->trans('Produits à afficher'),
            'help' => 'Sélectionnez les produits que vous souhaitez mettre en avant. Vous pouvez sélectionner jusqu\'à 4 produits.',
            'attr' => [
                'data-toggle' => 'select2',
            ],
            'constraints' => [
                new Choice([
                    'multiple' => true,
                    'max' => 4,
                    'choices' => $this->getProducts(),
                    'maxMessage' => $this->trans('Vous devez selectionné au maximum {{ limit }} produits.'),
                ]),
            ],
        ])
        ->add('GRIIV_CUSTOMER_HIGHLIGHT_LINK', TranslatableType::class, [
            'type' => UrlType::class,
            'label' => $this->trans('Lien pour "voir tous les produits"'),
            'attr' => [
                'placeholder' => '/ma-category-ou-ma-page',
            ],
            'locales' => \Language::getLanguages(),
        ]);
    }

    protected function trans($key, $domain = null,  $parameters = [])
    {
        return parent::trans($key, \griivproducthighlight::getTranslationDomain(), $parameters);
    }

    private array $products = [];


    protected function getProducts()
    {
        if ($this->products === []) {
            $shop_criteria = Shop::addSqlAssociation('product', 'g');
            $id_lang = Context::getContext()->language->id;
            $psProducts = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS('
        SELECT DISTINCT  CONCAT(gl.`name`, " (", g.`reference`, ")") as name, g.`id_product`
        FROM `' . _DB_PREFIX_ . 'product` g
        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` AS gl ON (g.`id_product` = gl.`id_product` AND gl.`id_lang` = ' . (int) $id_lang . ')
        ' . $shop_criteria . '
        ORDER BY gl.`name` ASC');
            $return = [];
            foreach ($psProducts as $psProduct) {
                $return[$psProduct['name']] = $psProduct['id_product'];
            }
            $this->products = $return;
        }

        return $this->products;
    }
}