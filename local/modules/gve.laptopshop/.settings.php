<?php
    //modules/laptopshop/.settings.php
    return [
        'controllers' => [
            'value' => [
                'defaultNamespace' => '\\Gve\\Laptopshop\\Controller',
                'namespaces' => [
                    '\\Gve\\Laptopshop\\Controller' => 'api',
                ],
            ],
            'readonly' => true,
        ],
        'exception_handling' => [

            'value' =>
                [
                    'debug' => true,
                    'handled_errors_types' => 4437,
                    'exception_errors_types' => 4437,
                    'ignore_silence' => false,
                    'assertion_throws_exception' => true,
                    'assertion_error_type' => 256,
                    'log' => NULL,
                ],
            'readonly' => false,
        ],
    ];
?>
