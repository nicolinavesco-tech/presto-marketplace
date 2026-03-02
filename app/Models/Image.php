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
        return is_string($this->path) && preg_match('#^https?://#', $this->path);
    }

    /**
     * Ritorna URL immagine:
     * - se locale: Storage::url(...)
     * - se Uploadcare: usa uuid se presente, altrimenti usa path (URL)
     *
     * $w e $h opzionali:
     * - se solo $w: resize width
     * - se $w e $h: crop WxH center
     */
    public function getUrl(?int $w = null, ?int $h = null): string
    {
        // LOCALE
        if (!$this->isRemote()) {
            if (!$w && !$h) {
                return Storage::url($this->path);
            }

            // se usi i crop locali generati dal tuo job ResizeImage
            $path = dirname($this->path);
            $filename = basename($this->path);
            $file = "{$path}/crop_{$w}x{$h}_{$filename}";
            return Storage::url($file);
        }

        // REMOTO (Uploadcare)
        // Se hai uuid, costruisci URL pulito.
        $cdnBase = rtrim(config('uploadcare.cdn_base', 'https://ucarecdn.com'), '/');
        $base = $this->uploadcare_uuid
            ? "{$cdnBase}/{$this->uploadcare_uuid}/"
            : $this->path; // fallback: path già URL

        // niente resize/crop
        if (!$w && !$h) {
            // puoi sempre chiedere format auto
            return rtrim($base, '/') . "/-/format/auto/";
        }

        // solo width
        if ($w && !$h) {
            return rtrim($base, '/') . "/-/resize/{$w}/-/format/auto/";
        }

        // crop WxH center
        return rtrim($base, '/') . "/-/crop/{$w}x{$h}/center/-/format/auto/";
    }

    public static function getUrlByFilePath($filePath, $w = null, $h = null)
    {
        // Mantieni compatibilità con chiamate statiche del tuo progetto
        $tmp = new self();
        $tmp->path = $filePath;
        return $tmp->getUrl($w, $h);
    }
}