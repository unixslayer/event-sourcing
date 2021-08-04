<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
    ->exclude(['vendor'])
;

return PhpCsFixer\Config::create()
    ->setFinder($finder)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        'array_syntax' => ['syntax' => 'short'],
        'cast_spaces' => ['space' => 'none'],
        'declare_strict_types' => true,
        'no_superfluous_phpdoc_tags' => ['allow_mixed' => false],
        'php_unit_test_class_requires_covers' => false,
        'php_unit_test_case_static_method_calls' => true,
        'php_unit_internal_class' => false,
        'strict_param' => true,
        'yoda_style' => false,
        'header_comment' => [
            'commentType' => 'PHPDoc',
            'header' => file_get_contents('.docheader'),
        ],
    ])
;
