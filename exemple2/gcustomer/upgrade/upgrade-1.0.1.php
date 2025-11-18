<?php
/**
 * 2021 Crédit Agricole
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 *
 * @author    PrestaShop / PrestaShop partner
 * @copyright 2020-2021 Crédit Agricole
 * @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

/**
 * Upgrade to 5.1.0
 *
 * @param $module gcustomer
 *
 * @return bool
 */
function upgrade_module_1_0_1($module)
{
    $queries[] = "ALTER TABLE `" . _DB_PREFIX_ . "customer` ADD `code` VARCHAR(128) DEFAULT NULL";
    $queries[] = "ALTER TABLE `" . _DB_PREFIX_ . "customer` ADD `code_internet` VARCHAR(128) DEFAULT NULL";
    $ret = true;
    $db = Db::getInstance();

    $db->execute('START TRANSACTION');
    foreach ($queries as $query) {
        $ret &= $db->execute($query);
    }

    if (!$ret) {
        $db->execute('ROLLBACK');
        return false;
    }

    $db->execute('COMMIT');
    return true;
}
