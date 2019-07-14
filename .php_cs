<?php

return PhpCsFixer\Config::create()
    ->setRules([
        '@PSR2'                             => true,
        '@Symfony'                          => true,
        'binary_operator_spaces'            => ['align_double_arrow' => true],
        'linebreak_after_opening_tag'       => true,
        'not_operator_with_successor_space' => true,
        'ordered_imports'                   => [
            'sortAlgorithm' => 'length', // https://styleci.readme.io/docs/presets#laravel && https://styleci.readme.io/docs/fixers#length_ordered_imports
        ],
        'phpdoc_order'      => true,
        'no_unused_imports' => true,
        'array_syntax'      => [
            'syntax' => 'short',
        ],
    ])
    ;
