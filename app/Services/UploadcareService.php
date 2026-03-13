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

        $publicKey = env('UPLOADCARE_PUBLIC_KEY');

        if (!$publicKey) {
            throw new RuntimeException('UPLOADCARE_PUBLIC_KEY mancante');
        }

        $response = Http::timeout(120)
            ->asMultipart()
            ->post('https://upload.uploadcare.com/base/', [
                [
                    'name' => 'UPLOADCARE_PUB_KEY',
                    'contents' => $publicKey,
                ],
                [
                    'name' => 'UPLOADCARE_STORE',
                    'contents' => '1',
                ],
                [
                    'name' => 'file',
                    'contents' => fopen($absolutePath, 'r'),
                    'filename' => basename($absolutePath),
                ],
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Uploadcare error: ' . $response->body());
        }

        $uuid = $response->json('file');

        if (!$uuid) {
            throw new RuntimeException('UUID Uploadcare non ricevuto');
        }

        return [
            'uuid' => $uuid,
            'cdn_url' => 'https://ucarecdn.com/' . $uuid . '/',
        ];
    }
}