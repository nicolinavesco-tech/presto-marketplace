<?php

return [
    'public_key' => env('UPLOADCARE_PUBLIC_KEY'),
    'secret_key' => env('UPLOADCARE_SECRET_KEY'),
    'upload_base' => env('UPLOADCARE_UPLOAD_BASE', 'https://upload.uploadcare.com'),
    'cdn_base' => env('UPLOADCARE_CDN_BASE', 'https://ucarecdn.com'),
    'store' => filter_var(env('UPLOADCARE_STORE', true), FILTER_VALIDATE_BOOL),
];