<?php

return [
    '__name' => 'lib-locale',
    '__version' => '0.0.2',
    '__git' => 'git@github.com:getphun/lib-locale.git',
    '__license' => 'MIT',
    '__author' => [
        'name' => 'Iqbal Fauzi',
        'email' => 'iqbalfawz@gmail.com',
        'website' => 'https://iqbalfn.com/'
    ],
    '__files' => [
        'etc/locale' => ['install','remove'],
        'etc/cache/locale' => ['install','remove'],
        'modules/lib-locale' => ['install','update','remove']
    ],
    '__dependencies' => [
        'required' => [],
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
            'modules/lib-locale/helper/locale.php' => TRUE
        ]
    ],

    'cliApp' => [
        'callback' => [
            'reconfig' => [
                'LibLocale\\Library\\Config::reconfig' => true
            ]
        ]
    ]
];