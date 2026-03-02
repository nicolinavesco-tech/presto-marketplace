<?php

namespace App\Services;

use Uploadcare\Api;
use Uploadcare\Configuration;

class UploadcareService
{
    public static function client(): Api
    {
        $public = config('uploadcare.public_key');
        $secret = config('uploadcare.secret_key');

        if (!$public || !$secret) {
            throw new \RuntimeException(
                'Uploadcare non configurato: UPLOADCARE_PUBLIC_KEY / UPLOADCARE_SECRET_KEY mancanti.'
            );
        }

        // ✅ modo corretto per v4.x
        $configuration = Configuration::create($public, $secret);

        return new Api($configuration);
    }

    /**
     * Carica un file locale su Uploadcare e ritorna:
     * - uuid
     * - cdn_url (https://ucarecdn.com/<uuid>/)
     */
    public static function uploadLocalFile(string $absolutePath): array
    {
        if (!file_exists($absolutePath)) {
            throw new \RuntimeException("File non trovato: {$absolutePath}");
        }

        $api = self::client();
        $uploader = $api->uploader();

        $mime = @mime_content_type($absolutePath) ?: 'application/octet-stream';

        // ✅ upload da path (v4.x: fromPath)
        $file = $uploader->fromPath($absolutePath, $mime);

        // Il File object espone uuid
        $uuid = method_exists($file, 'getUuid') ? $file->getUuid() : ($file->uuid ?? null);

        if (!$uuid) {
            throw new \RuntimeException('Uploadcare: UUID non ottenuto dalla risposta upload.');
        }

        $cdnBase = rtrim(config('uploadcare.cdn_base', 'https://ucarecdn.com'), '/');

        return [
            'uuid' => $uuid,
            'cdn_url' => "{$cdnBase}/{$uuid}/",
        ];
    }
}