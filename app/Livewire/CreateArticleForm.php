<?php

namespace App\Livewire;

use App\Jobs\RemoveFaces;
use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\ResizeImage;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Support\Facades\File;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class CreateArticleForm extends Component
{
    use WithFileUploads;
    public $images = [];
    public $temporary_images;
    #[Validate('required|min:5')]
    public $title;
    #[Validate('required|min:10')]
    public $description;
    #[Validate('required|numeric')]
    public $price;
    #[Validate('required')]
    public $category;
    public $article;



    public function store()
    {
        $this->validate();

        $this->article = Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id(),
        ]);

        if (!empty($this->images) && count($this->images) > 0) {

            foreach ($this->images as $image) {

                // 1) Salva localmente (serve alla pipeline)
                $newFileName = "articles/{$this->article->id}";
                $localPath = $image->store($newFileName, 'public'); // es: articles/4/xxxxx.jpg

                $newImage = $this->article->images()->create([
                    'path' => $localPath, // temporaneo: path locale
                ]);

                // 2) Esegui pipeline 
                try {
                    RemoveFaces::withChain([
                        // ✅ tieni questi (Google Vision)
                        new GoogleVisionSafeSearch($newImage->id),
                        new GoogleVisionLabelImage($newImage->id),


                    ])->dispatch($newImage->id);
                } catch (\Throwable $e) {
                    logger()->error('Image pipeline failed', [
                        'image_id' => $newImage->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // Upload Cloudinary (anche se pipeline fallisce)
                $absolutePath = storage_path('app/public/' . $localPath);

                $result = Cloudinary::upload($absolutePath, [
                    'folder' => "presto/articles/{$this->article->id}",
                ]);

                $newImage->update([
                    'path' => $result->getSecurePath(),
                    'public_id' => $result->getPublicId(),
                ]);

                // 3) Upload su Cloudinary usando il file locale
                $absolutePath = storage_path('app/public/' . $localPath);

                try {
                    if (!file_exists($absolutePath)) {
                        throw new \Exception("File non trovato: {$absolutePath}");
                    }

                    // Meglio usare config invece di env in production
                    if (!config('cloudinary.cloud_url')) {
                        throw new \Exception('Cloudinary non configurato: cloudinary.cloud_url mancante');
                    }

                    $articleId = $this->article?->id;
                    if (!$articleId) {
                        throw new \Exception('Article ID mancante (article non creato?)');
                    }
                    logger()->info('Cloudinary debug', [
                        'has_env' => !empty(env('CLOUDINARY_URL')),
                        'has_config' => !empty(config('cloudinary.cloud_url')),
                        'config_len' => strlen((string) config('cloudinary.cloud_url')),
                        'file_exists' => file_exists($absolutePath),
                        'file_size' => file_exists($absolutePath) ? filesize($absolutePath) : null,
                    ]);

                    $result = Cloudinary::upload($absolutePath, [
                        'folder' => "presto/articles/{$articleId}",
                    ]);

                    // 4) Aggiorna DB con URL Cloudinary (ora la view vede l'immagine)
                    $newImage->update([
                        'path' => $result->getSecurePath(),
                        'public_id' => $result->getPublicId(),
                    ]);
                } catch (\Throwable $e) {
                    logger()->error('Cloudinary upload failed', [
                        'article_id' => $this->article?->id,
                        'image_id' => $newImage->id ?? null,
                        'localPath' => $localPath ?? null,
                        'absolutePath' => $absolutePath ?? null,
                        'error' => $e->getMessage(),
                    ]);
                }
                // 5) (opzionale) cancella il file locale per non accumulare roba su Render
                // File::delete($absolutePath);
            }

            File::deleteDirectory(storage_path("/app/livewire-tmp"));
        }

        session()->flash("status", "Articolo caricato con successo!");
        $this->cleanForm();
    }

    protected function cleanForm()
    {
        $this->title = '';
        $this->description = '';
        $this->category = '';
        $this->price = '';
        $this->images = [];
    }
    public function updatedTemporaryImages()
    {
        if ($this->validate([
            'temporary_images.*' => 'image|max:1024',
            'temporary_images' => 'max:6'
        ])) {
            foreach ($this->temporary_images as $image) {
                $this->images[] = $image;
            }
        }
    }
    public function removeImage($key)
    {
        if (in_array($key, array_keys($this->images))) {
            unset($this->images[$key]);
            // dd( $this->images);
        }
    }



    public function render()
    {
        return view('livewire.create-article-form');
    }
}
