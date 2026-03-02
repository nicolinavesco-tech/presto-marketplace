<?php

$cloudUrl = env('CLOUDINARY_URL');

if (!$cloudUrl) {
    $cloud = env('CLOUDINARY_CLOUD_NAME');
    $key   = env('CLOUDINARY_API_KEY');
    $sec   = env('CLOUDINARY_API_SECRET');

    if ($cloud && $key && $sec) {
        $cloudUrl = "cloudinary://{$key}:{$sec}@{$cloud}";
    }
}

return [
    'url' => $cloudUrl,
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),
];