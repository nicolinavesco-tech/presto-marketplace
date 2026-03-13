<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

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
        return is_string($this->path) && preg_match('#^https?://#i', $this->path) === 1;
    }

    public function getUrl(?int $w = null, ?int $h = null): string
    {
        if (empty($this->path)) {
            return '';
        }

        // REMOTO: Uploadcare
        if ($this->isRemote()) {
            $base = !empty($this->uploadcare_uuid)
                ? 'https://ucarecdn.com/' . trim($this->uploadcare_uuid, '/') . '/'
                : rtrim($this->path, '/') . '/';

            if (!$w && !$h) {
                return $base;
            }

            if ($w && $h) {
                return $base . "-/resize/{$w}x{$h}/";
            }

            if ($w) {
                return $base . "-/resize/{$w}x/";
            }

            return $base . "-/resize/x{$h}/";
        }

        // LOCALE
        if (!$w || !$h) {
            return '/storage/' . ltrim($this->path, '/');
        }

        $dir = dirname($this->path);
        $filename = basename($this->path);
        $cropFile = "{$dir}/crop_{$w}x{$h}_{$filename}";

        if (Storage::disk('public')->exists($cropFile)) {
            return '/storage/' . ltrim($cropFile, '/');
        }

        return '/storage/' . ltrim($this->path, '/');
    }
}
