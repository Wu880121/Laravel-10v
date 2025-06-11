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

    // ✅ 哪些網域允許來訪
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // 所有 method 都允許（GET、POST...）

    'allowed_origins' => explode(',' , env('FRONTEND_URLS','http://easepleasure.keepgoingpiggy.com')),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],   // 或自定義 ['Content-Type', 'Authorization']

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // ✅ 若你要讓 cookie 傳送（必開）

];
