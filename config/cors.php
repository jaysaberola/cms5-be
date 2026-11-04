<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'file-manager/*'],

    'allowed_methods' => ['*'],

    'allowed_origins' => array_values(array_filter(array_map(
        'trim',
        preg_split(
            '/\s*,\s*/',
            (string) env(
                'CORS_ALLOWED_ORIGINS',
                env('CORS_ALLOWED_ORIGIN', 'https://cms4-nextjs.vercel.app')
            )
        ) ?: []
    ))),

    'allowed_origins_patterns' => array_values(array_filter(array_map(
        'trim',
        preg_split(
            '/\s*,\s*/',
            (string) env('CORS_ALLOWED_ORIGIN_PATTERNS', '#^https://cms5-fe[-a-z0-9]*\.vercel\.app$#')
        ) ?: []
    ))),

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,
];
