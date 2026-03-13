<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class UploadcareService
{
    public static function uploadLocalFile(string $absolutePath): array
    {
        if (!is_file($absolutePath)) {
            throw new RuntimeException("File non trovato: {$absolutePath}");
        }

        $publicKey = config('uploadcare.public_key');
        $store = config('uploadcare.store') ? '1' : '0';

        if (empty($publicKey)) {
            throw new RuntimeException('UPLOADCARE_PUBLIC_KEY mancante');
        }

        $response = Http::asMultipart()
            ->timeout(120)
            ->post(rtrim(config('uploadcare.upload_base', 'https://upload.uploadcare.com'), '/') . '/base/', [
                [
                    'name' => 'UPLOADCARE_PUB_KEY',
                    'contents' => $publicKey,
                ],
                [
                    'name' => 'UPLOADCARE_STORE',
                    'contents' => $store,
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($absolutePath, 'r'),
                    'filename' => basename($absolutePath),
                ],
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Uploadcare upload failed: ' . $response->body());
        }

        $uuid = $response->json('file');

        if (empty($uuid)) {
            throw new RuntimeException('UUID Uploadcare non ricevuto');
        }

        $cdnUrl = rtrim(config('uploadcare.cdn_base', 'https://ucarecdn.com'), '/') . '/' . $uuid . '/';

        return [
            'uuid' => $uuid,
            'cdn_url' => $cdnUrl,
        ];
    }
}