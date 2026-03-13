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

    public function getUrl(?int $w = null, ?int $h = null): string
    {
        if ($this->uploadcare_uuid) {

            $base = "https://ucarecdn.com/{$this->uploadcare_uuid}/";

            if ($w && $h) {
                return $base."-/resize/{$w}x{$h}/";
            }

            if ($w) {
                return $base."-/resize/{$w}x/";
            }

            if ($h) {
                return $base."-/resize/x{$h}/";
            }

            return $base;
        }

        return "https://picsum.photos/".($w ?: 1200)."/".($h ?: 1200);
    }
}