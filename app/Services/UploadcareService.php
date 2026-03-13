<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class UploadcareService
{
    public static function uploadUploadedFile(UploadedFile $file): array
    {
        $publicKey = env('UPLOADCARE_PUBLIC_KEY');

        if (!$publicKey) {
            throw new RuntimeException('UPLOADCARE_PUBLIC_KEY mancante');
        }

        $realPath = $file->getRealPath();

        if (!$realPath || !is_file($realPath)) {
            throw new RuntimeException('File temporaneo non trovato');
        }

        $handle = fopen($realPath, 'r');

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
                    'contents' => $handle,
                    'filename' => $file->getClientOriginalName() ?? 'image.jpg',
                ],
            ]);

        fclose($handle);

        if (!$response->successful()) {
            throw new RuntimeException('Uploadcare error: '.$response->body());
        }

        $uuid = $response->json('file');

        if (!$uuid) {
            throw new RuntimeException('UUID Uploadcare non ricevuto');
        }

        return [
            'uuid' => $uuid,
            'cdn_url' => 'https://ucarecdn.com/'.$uuid.'/',
        ];
    }
}