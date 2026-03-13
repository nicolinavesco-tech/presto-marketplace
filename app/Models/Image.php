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
        if (empty($this->path)) {
            return '';
        }

        if ($this->isRemote()) {
            return $this->path;
        }

        return '/storage/' . ltrim($this->path, '/');
    }

    public static function getUrlByFilePath($filePath, $w = null, $h = null): string
    {
        if (filled($filePath) && filter_var($filePath, FILTER_VALIDATE_URL)) {
            return $filePath;
        }

        return '/storage/' . ltrim((string) $filePath, '/');
    }
}