<?php

use Griiv\Prestashop\Module\Contracts\Module\ModuleAbstract;

class gcategory extends ModuleAbstract
{
    use \Griiv\Prestashop\Module\Contracts\Trait\ModuleTrait;

    protected $nameSpace = 'Griiv\\Category\\Hook\\';

    public function __construct()
    {
        $this->name = 'gcategory';
        $this->version = '1.0.1';
        $this->author = 'Griiv';

        parent::__construct();

        $this->displayName = $this->trans('Griiv - Category', [], self::getTranslationDomain());
        $this->description = $this->trans('Modify category parts', [], self::getTranslationDomain());
        $this->ps_versions_compliancy = [
            'min' => '1.7.7.0',
            'max' => _PS_VERSION_,
        ];

    }

    public function getHooks(): array
    {
        return [
            'actionCategoryGridDefinitionModifier',
            'actionCategoryGridQueryBuilderModifier',
            'actionCategoryFormBuilderModifier',
            'actionAfterCreateCategoryFormHandler',
            'actionAfterUpdateCategoryFormHandler',
            'actionCategoryFormDataProviderData',
            'actionProductFormBuilderModifier',
            'actionProductFormDataProviderData',
            'actionGetProductPropertiesAfter',
            'actionProductGridDefinitionModifier',
            'actionProductGridQueryBuilderModifier',
        ];
    }

    public function install()
    {
        return parent::install() && $this->registerHook($this->getHooks());
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->unregisterHooks($this->getHooks());
    }

    private function unregisterHooks(array $hooks)
    {
        $success = true;

        foreach ($hooks as $hook) {
            $success &= $this->unregisterHook($hook);
        }

        return $success;
    }
}