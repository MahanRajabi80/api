<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',
        'api/admin/*',
        'api/client/*',
        'sanctum/csrf-cookie'
    ],
    'allowed_methods' => ['*'],
    'allowed_origins' => [
        'http://localhost:3000',
        'http://localhost:3046',
        'http://127.0.0.1:3000',
        'http://127.0.0.1:3046',
        'http://localhost:2000',
        'http://127.0.0.1:2000',
        'https://tajrobe.wiki',
        'https://admin.tajrobe.wiki',
        'tajrobe.wiki',
        '*.tajrobe.wiki'
    ],
    'allowed_origins_patterns' => [''],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,

];
