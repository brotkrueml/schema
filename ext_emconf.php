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
    'version' => '3.0.0-dev',
    'constraints' => [
        'depends' => [
            'php' => '7.4.0-0.0.0',
            'typo3' => '10.4.11-12.4.99',
        ],
        'conflicts' => [
            'sdbreadcrumb' => '',
        ],
        'suggests' => [
            'adminpanel' => '',
            'lowlevel' => '',
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
