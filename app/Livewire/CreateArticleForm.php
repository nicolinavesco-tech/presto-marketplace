<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
use App\Jobs\UploadImageToUploadcare;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Article;

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
                $dir = "articles/{$this->article->id}";
                $localPath = $image->store($dir, 'public'); // es: articles/4/xxxxx.jpg

                // 2) Crea record immagine: path locale
                $newImage = $this->article->images()->create([
                    'path' => $localPath,
                ]);

                // 3) Pipeline (Vision ecc.) - usa path locale: OK
                try {
                    RemoveFaces::withChain([
                        new GoogleVisionSafeSearch($newImage->id),
                        new GoogleVisionLabelImage($newImage->id),

                        // se vuoi anche resize/watermark in coda, mettilo qui
                        // new ResizeImage($newImage->path, 600, 600),
                    ])->dispatch($newImage->id);
                } catch (\Throwable $e) {
                    logger()->error('Image pipeline failed', [
                        'image_id' => $newImage->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                // 4) Upload su Uploadcare (job separato)
                //    Nota: se vuoi aspettare che RemoveFaces finisca prima di uploadare,
                //    allora sposta l’upload in coda *dopo* RemoveFaces (dipende da come hai scritto RemoveFaces).
                UploadImageToUploadcare::dispatch($newImage->id, true);
            }

            // ripulisci tmp livewire
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
        $this->validate([
            'temporary_images.*' => 'image|max:1024',
            'temporary_images' => 'max:6'
        ]);

        foreach ($this->temporary_images as $image) {
            $this->images[] = $image;
        }
    }

    public function removeImage($key)
    {
        if (array_key_exists($key, $this->images)) {
            unset($this->images[$key]);
        }
    }

    public function render()
    {
        return view('livewire.create-article-form');
    }
}