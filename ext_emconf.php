<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Embedding schema.org vocabulary',
    'description' => 'schema.org structured data for your website',
    'category' => 'fe',
    'state' => 'stable',
    'createDirs' => '',
    'clearCacheOnLoad' => true,
    'author' => 'Chris Müller',
    'author_email' => 'typo3@krue.ml',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-9.5.99',
        ],
        'conflicts' => [
        ],
    ],
    'autoload' => [
        'psr-4' => ['Brotkrueml\\Schema\\' => 'Classes']
    ],
];
