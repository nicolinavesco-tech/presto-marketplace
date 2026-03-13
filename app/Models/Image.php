<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

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

    public function isRemote(): bool
    {
        return filled($this->path) && filter_var($this->path, FILTER_VALIDATE_URL);
    }

    public function getUrl(?int $w = null, ?int $h = null): string
    {
        // 1) Uploadcare UUID
        if (filled($this->uploadcare_uuid)) {
            $base = 'https://ucarecdn.com/' . trim($this->uploadcare_uuid, '/') . '/';

            if ($w && $h) {
                return $base . '-/resize/' . $w . 'x' . $h . '/';
            }

            if ($w) {
                return $base . '-/resize/' . $w . 'x/';
            }

            if ($h) {
                return $base . '-/resize/x' . $h . '/';
            }

            return $base;
        }

        // 2) path remoto già valido
        if ($this->isRemote()) {
            return $this->path;
        }

        // 3) fallback assoluto: immagine di default
        $width = $w ?: 1200;
        $height = $h ?: 1200;

        return "https://picsum.photos/{$width}/{$height}";
    }

    public static function getUrlByFilePath($filePath, $w = null, $h = null): string
    {
        if (filled($filePath) && filter_var($filePath, FILTER_VALIDATE_URL)) {
            return $filePath;
        }

        $width = $w ?: 1200;
        $height = $h ?: 1200;

        return "https://picsum.photos/{$width}/{$height}";
    }
}