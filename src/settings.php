<?php
return [
    'settings' => [
        'displayErrorDetails' => false,

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates',
            'options'       => [
                'cache' => __DIR__ . '/../templates/cache/',
                'auto_reload' => true
            ]
        ],

        // Database settings
        'database' => [
            'host' => 'localhost',
            'dbname' => 'marketplace',
            'username' => 'root',
            'password' => 'root',
        ],
    ],
];
