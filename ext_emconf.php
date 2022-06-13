<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Embedding schema.org vocabulary',
    'description' => 'API and view helpers for schema.org markup',
    'category' => 'fe',
    'state' => 'stable',
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '1.13.1-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.16-11.5.99',
        ],
        'conflicts' => [
            'sdbreadcrumb' => '',
        ],
        'suggests' => [
            'adminpanel' => '',
            'schema_auto' => '',
            'schema_bib' => '',
            'schema_health' => '',
            'schema_pending' => '',
            'schema_virtuallocation' => '',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\Schema\\' => 'Classes']
    ],
];
