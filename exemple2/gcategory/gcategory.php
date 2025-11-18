<?php

use Griiv\Prestashop\Module\Contracts\Module\ModuleAbstract;

require_once __DIR__ . '/vendor/autoload.php';

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
        return ['displayTop'];
    }

    public function install()
    {
        return parent::install() && $this->registerHook($this->getHooks());
    }

    public function uninstall()
    {
        return parent::uninstall();
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