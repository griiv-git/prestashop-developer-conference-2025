<?php

declare(strict_types=1);

namespace Griiv\Customer\Form\Configuration;


use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\Form\FormDataProviderInterface;

final class ConfigurationFormDataProvider implements FormDataProviderInterface
{

    public function __construct(private DataConfigurationInterface $dataConfiguration)
    {}

    public function getData(): array
    {
        return $this->dataConfiguration->getConfiguration();
    }

    public function setData(array $data): array
    {
        return $this->dataConfiguration->updateConfiguration($data);
    }
}