<?php return array(
    'root' => array(
        'name' => 'griiv/category',
        'pretty_version' => '1.0.0+no-version-set',
        'version' => '1.0.0.0',
        'reference' => NULL,
        'type' => 'prestashop-module',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'griiv/category' => array(
            'pretty_version' => '1.0.0+no-version-set',
            'version' => '1.0.0.0',
            'reference' => NULL,
            'type' => 'prestashop-module',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'griiv/prestashop-module-contracts' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'cbfea646b2466d13c92941327eded7824d5ebe3e',
            'type' => 'library',
            'install_path' => __DIR__ . '/../griiv/prestashop-module-contracts',
            'aliases' => array(
                0 => '9999999-dev',
            ),
            'dev_requirement' => false,
        ),
    ),
);
