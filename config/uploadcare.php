<?php 

return [
    'public_key' => env('UPLOADCARE_PUBLIC_KEY'),
    'secret_key' => env('UPLOADCARE_SECRET_KEY'),
    'cdn_base'   => env('UPLOADCARE_CDN_BASE', 'https://ucarecdn.com'),
];