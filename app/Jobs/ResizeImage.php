<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Spatie\Image\Enums\CropPosition;
use Spatie\Image\Enums\Unit;
use Spatie\Image\Image;

class ResizeImage implements ShouldQueue
{
    use Queueable;

    private int $w;
    private int $h;
    private string $fileName;
    private string $path;

    public function __construct(string $filePath, int $w, int $h)
    {
        $this->path = dirname($filePath);
        $this->fileName = basename($filePath);
        $this->w = $w;
        $this->h = $h;
    }

    public function handle(): void
    {
        $srcPath = storage_path("app/public/{$this->path}/{$this->fileName}");
        $destPath = storage_path("app/public/{$this->path}/crop_{$this->w}x{$this->h}_{$this->fileName}");

        if (!is_file($srcPath)) {
            return;
        }

        Image::load($srcPath)
            ->crop($this->w, $this->h, CropPosition::Center)
            ->watermark(
                public_path('media/logo_bw.png'),
                width: 200,
                height: 200,
                alpha: 40,
                paddingX: 5,
                paddingY: 5,
                paddingUnit: Unit::Percent
            )
            ->save($destPath);
    }
}