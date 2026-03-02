<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    // ✅ permette update() su public_id, labels, adult, ecc
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'labels' => 'array',
        ];
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Article::class);
    }

    public static function getUrlByFilePath($filePath, $w = null, $h = null)
    {
        // URL Cloudinary
        if (is_string($filePath) && preg_match('#^https?://#', $filePath)) {
            if (!$w || !$h) return $filePath;

            return preg_replace(
                '#/upload/#',
                "/upload/c_fill,w_{$w},h_{$h},q_auto,f_auto/",
                $filePath,
                1
            );
        }

        // Locale
        if (!$w && !$h) return Storage::url($filePath);

        $path = dirname($filePath);
        $filename = basename($filePath);
        $file = "{$path}/crop_{$w}x{$h}_{$filename}";

        return Storage::url($file);
    }

    public function getUrl($w = null, $h = null)
    {
        return self::getUrlByFilePath($this->path, $w, $h);
    }
}