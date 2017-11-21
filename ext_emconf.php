<?php

/*
 * Copyright notice
 *
 * (c) 2017 arndtteunissen <dev@arndtteunissen.de>
 * All rights reserved
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Simple 404 handler',
    'description' => 'Enables simple 404 Page NotFound handling, also for multilingual sites.',
    'version' => '1.0.1',
    'category' => 'fe',
    'constraints' => [
        'depends' => [
            'typo3' => '6.2.0-8.7.99'
        ]
    ],
    'state' => 'stable',
    'uploadfolder' => 0,
    'createDirs' => '',
    'clearCacheOnLoad' => false,
    'author' => 'Arndtteunissen',
    'author_email' => 'dev@arndtteunissen.de',
    'author_company' => 'Arndtteunissen',
    'autoload' => [
        'psr-4' => [
            'Arndtteunissen\\Simple404Handler\\' => 'Classes'
        ]
    ]
];