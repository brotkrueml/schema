<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Embedding schema.org vocabulary',
    'description' => 'API and view helpers for schema.org markup',
    'category' => 'fe',
    'state' => 'stable',
    'author' => 'Chris Müller',
    'author_email' => 'typo3@brotkrueml.dev',
    'version' => '4.0.0-dev',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
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
