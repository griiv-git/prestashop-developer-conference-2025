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
function upgrade_module_1_0_3($module)
{
    //Particuliers;Administration;Armurerie;Arm export;Police municipale;Arm partenaire;Admin export
    $res = true;

    $sql = "ALTER TABLE `" . _DB_PREFIX_ . "group` ADD `code` VARCHAR(128) DEFAULT NULL";

    $db = Db::getInstance();

    $db->execute('START TRANSACTION');

    $res &= $db->execute($sql);


    if (!$res) {
        $db->execute('ROLLBACK');
        return false;
    }

    $db->execute('COMMIT');

    $customerGroups = [
        [
            'name' => 'Particuliers',
            'code' => Group::generateCode('Particuliers'),
            'reduction' => 0,
            'price_display_method' => 0,
            'show_prices' => 1,
        ],
        [
            'name' => 'Administration',
            'code' => Group::generateCode('Administration'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Armurerie',
            'code' => Group::generateCode('Armurerie'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Arm export',
            'code' => Group::generateCode('Arm export'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Police municipale',
            'code' => Group::generateCode('Police municipale'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Arm partenaire',
            'code' => Group::generateCode('Arm partenaire'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Admin export',
            'code' => Group::generateCode('Admin export'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'CB/VIREMENT Linxo',
            'code' => Group::generateCode('CB/VIREMENT Linxo'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ],
        [
            'name' => 'Virement',
            'code' => Group::generateCode('Virement'),
            'reduction' => 0,
            'price_display_method' => 1,
            'show_prices' => 1,
        ]
    ];

    $idLang = Context::getContext()->language->id;
    foreach ($customerGroups as $groupInfo) {
        $group = new Group();
        $group->name[$idLang] = $groupInfo['name'];
        $group->code = $groupInfo['code'];
        $group->reduction = $groupInfo['reduction'];
        $group->price_display_method = $groupInfo['price_display_method'];
        $group->show_prices = $groupInfo['show_prices'];

        $res &= $group->add();
    }
    return true;
}

function generateCode($name) {
    // 1. Translitération des accents en ASCII
    if (function_exists('transliterator_transliterate')) {
        $name = transliterator_transliterate('Any-Latin; Latin-ASCII', $name);
    } else {
        // fallback si intl n'est pas disponible
        $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
    }

    // 2. Suppression de tout ce qui n'est pas A–Z ou 0–9
    $name = preg_replace('/[^A-Za-z0-9]/', '', $name);

    // 3. Passage en majuscules
    return strtoupper($name);

}
