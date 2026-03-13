<?php

namespace App\Jobs;

use App\Models\Image;
use App\Services\UploadcareService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Throwable;

class UploadImageToUploadcare implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $imageId,
        public bool $deleteLocalAfterUpload = true
    ) {}

    public function handle(): void
    {
        $image = Image::find($this->imageId);

        if (!$image) {
            return;
        }

        if ($image->isRemote()) {
            return;
        }

        $relativePath = ltrim((string) $image->path, '/');
        $absolutePath = storage_path('app/public/' . $relativePath);

        if (!is_file($absolutePath)) {
            logger()->error('Uploadcare: file locale non trovato', [
                'image_id' => $this->imageId,
                'path' => $absolutePath,
            ]);
            return;
        }

        try {
            $result = UploadcareService::uploadLocalFile($absolutePath);

            $image->update([
                'path' => $result['cdn_url'],
                'uploadcare_uuid' => $result['uuid'],
            ]);

            if ($this->deleteLocalAfterUpload && is_file($absolutePath)) {
                File::delete($absolutePath);
            }
        } catch (Throwable $e) {
            logger()->error('Uploadcare upload error', [
                'image_id' => $this->imageId,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}