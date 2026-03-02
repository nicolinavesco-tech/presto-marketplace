<?php

namespace App\Jobs;

use App\Models\Image;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadImageToCloudinary implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $imageId)
    {
    }

    public function handle(): void
    {
        $image = Image::find($this->imageId);
        if (!$image) return;

        // Se è già un URL cloud, non rifare
        if (is_string($image->path) && preg_match('#^https?://#', $image->path)) {
            return;
        }

        // Path fisico del file locale su storage/app/public/...
        $absolutePath = storage_path('app/public/' . $image->path);

        $result = Cloudinary::upload($absolutePath, [
            'folder' => "presto/articles/{$image->article_id}",
        ]);

        $image->update([
            'path' => $result->getSecurePath(),
            'public_id' => $result->getPublicId(),
        ]);
    }
}