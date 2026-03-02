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

class UploadImageToUploadcare implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $imageId, public bool $deleteLocalAfterUpload = true)
    {
    }

    public function handle(): void
    {
        $image = Image::find($this->imageId);
        if (!$image) return;

        // Se già su CDN (quindi path è URL), non rifare
        if (is_string($image->path) && preg_match('#^https?://#', $image->path)) {
            return;
        }

        // File locale
        $absolutePath = storage_path('app/public/' . $image->path);

        $result = UploadcareService::uploadLocalFile($absolutePath);

        $image->update([
            // qui decidiamo cosa salvare
            // - path: URL CDN (così la view è semplice)
            // - uploadcare_uuid: UUID separato (utile per transformations pulite)
            'path' => $result['cdn_url'],
            'uploadcare_uuid' => $result['uuid'],
        ]);

        if ($this->deleteLocalAfterUpload) {
            // cancella file originale
            if (file_exists($absolutePath)) {
                @File::delete($absolutePath);
            }
        }
    }
}