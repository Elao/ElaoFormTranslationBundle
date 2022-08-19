<?php

$header = <<<'EOF'
This file is part of the ElaoFormTranslation bundle.

Copyright (C) Elao

@author Elao <contact@elao.com>
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setUsingCache(true)
    ->setFinder($finder)
    ->setRules([
        '@Symfony' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'header_comment' => ['header' => $header],
        'native_function_invocation' => ['include' => ['@compiler_optimized']],
        'ordered_imports' => true,
        'php_unit_namespaced' => true,
        'php_unit_method_casing' => false,
        'phpdoc_annotation_without_dot' => false,
        'phpdoc_summary' => false,
        'phpdoc_order' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'psr_autoloading' => true,
        'single_line_throw' => false,
        'simplified_null_return' => false,
        'void_return' => true,
        'yoda_style' => [],

        // @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/5495
        'binary_operator_spaces' => ['operators' => ['|' => null]]
    ])
;
