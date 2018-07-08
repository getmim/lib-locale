<?php
/**
 * Module lib-locale config
 * @package lib-locale
 * @version 0.0.1
 */

return [
    '__name' => 'lib-locale',
    '__version' => '0.0.1',
    '__git' => 'git@github.com:getphun/lib-locale.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'etc/locale' => ['install', 'remove'],
        'modules/lib-locale' => ['install', 'update', 'remove']
    ],
    '__dependencies' => [
        'required' => [
            [
                'core' => null
            ]
        ],
        'optional' => []
    ],
    'autoload' => [
        'classes' => [
            'LibLocale\\Library' => [
                'type' => 'file',
                'base' => 'modules/lib-locale/library'
            ]
        ],
        'files' => [
            'modules/lib-locale/helper/locale.php' => true
        ]
    ]
];