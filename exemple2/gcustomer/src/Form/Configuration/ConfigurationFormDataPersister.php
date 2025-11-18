<?php

declare(strict_types=1);

namespace Griiv\Customer\Form\Configuration;

use PrestaShop\PrestaShop\Core\Configuration\DataConfigurationInterface;
use PrestaShop\PrestaShop\Core\ConfigurationInterface;

final class ConfigurationFormDataPersister implements DataConfigurationInterface
{
    public function __construct(private ConfigurationInterface $configuration)
    {
    }

    public function getConfiguration(): array
    {
        $titles = json_decode($this->configuration->get(ConfigurationForm::GRIIV_CUSTOMER_FORM_FIELD_1), true);
        if (!is_array($titles)) {
            $titles = [ 0 => "", 1 => ""];
        }
        $links = json_decode($this->configuration->get(ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_LINK), true);
        if (!is_array($links)) {
            $links = [ 0 => "", 1 => ""];
        }

        return [
            ConfigurationForm::GRIIV_CUSTOMER_FORM_FIELD_1 => $titles,
            ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS => unserialize($this->configuration->get(ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS)),
            ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_LINK => $links,
        ];
    }

    public function updateConfiguration(array $configuration): array
    {
        $errors = [];

        if ($this->validateConfiguration($configuration)) {
            $this->configuration->set(ConfigurationForm::GRIIV_CUSTOMER_FORM_FIELD_1, json_encode($configuration[ConfigurationForm::GRIIV_CUSTOMER_FORM_FIELD_1]));
            $this->configuration->set(ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS, serialize($configuration[ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_ID_PRODUCTS]));
            $this->configuration->set(ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_LINK, json_encode($configuration[ConfigurationForm::GRIIV_CUSTOMER_HIGHLIGHT_LINK]));
        }

        /* Errors are returned here. */
        return $errors;
    }

    public function validateConfiguration(array $configuration): bool
    {
        return true;
    }
}