<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'My PWA App'),
        'short_name' => 'BroBug',
        'description' => 'News tech website',
        'start_url' => '/admin/login',
        'background_color' => '#fff',
        'theme_color' => '#fff',
        'display' => 'standalone',
        'orientation' => 'portrait-primary',
        'status_bar' => 'black',
        "lang" => "en-US",
        'icons' => [
            '144x144' => [
                'path' => '/assets/bugbro-144x144.png',
            ],
            '192x192' => [
                'path' => '/assets/bugbro-192x192.png',
            ],
        ],
        'custom' => []
    ]
];
