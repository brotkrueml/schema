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
    'version' => '1.3.0',
    'constraints' => [
        'depends' => [
            'typo3' => '9.5.0-10.4.99',
        ],
        'conflicts' => [
            'sdbreadcrumb' => '',
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\Schema\\' => 'Classes']
    ],
];
