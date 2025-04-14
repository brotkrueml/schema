<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Embedding schema.org vocabulary',
    'description' => 'API and view helpers for schema.org markup',
    'category' => 'fe',
    'state' => 'stable',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@brotkrueml.dev',
    'version' => '3.12.0',
    'constraints' => [
        'depends' => [
            'php' => '8.1.0-0.0.0',
            'typo3' => '11.5.19-13.4.99',
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
