<?php

namespace App\Livewire;

use App\Jobs\GoogleVisionLabelImage;
use App\Jobs\GoogleVisionSafeSearch;
use App\Jobs\RemoveFaces;
use App\Models\Article;
use App\Services\UploadcareService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public array $images = [];
    public $temporary_images = [];

    #[Validate('required|min:5')]
    public $title = '';

    #[Validate('required|min:10')]
    public $description = '';

    #[Validate('required|numeric')]
    public $price = '';

    #[Validate('required')]
    public $category = '';

    public $article = null;

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

        if (!empty($this->images)) {
            foreach ($this->images as $uploadedImage) {
                $dir = "articles/{$this->article->id}";
                $localPath = $uploadedImage->store($dir, 'public');
                $absolutePath = storage_path('app/public/' . $localPath);

                try {
                    $uploadcare = UploadcareService::uploadLocalFile($absolutePath);

                    $newImage = $this->article->images()->create([
                        'path' => $uploadcare['cdn_url'],
                        'uploadcare_uuid' => $uploadcare['uuid'],
                    ]);
                } catch (\Throwable $e) {
                    logger()->error('Uploadcare upload failed', [
                        'error' => $e->getMessage(),
                        'path' => $absolutePath,
                    ]);

                    // fallback definitivo: niente path locale, solo immagine remota di default
                    $newImage = $this->article->images()->create([
                        'path' => 'https://picsum.photos/1200/1200',
                        'uploadcare_uuid' => null,
                    ]);
                }

                try {
                    RemoveFaces::dispatchSync($newImage->id);
                } catch (\Throwable $e) {
                    logger()->error('RemoveFaces failed', [
                        'image_id' => $newImage->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                try {
                    GoogleVisionSafeSearch::dispatchSync($newImage->id);
                } catch (\Throwable $e) {
                    logger()->error('GoogleVisionSafeSearch failed', [
                        'image_id' => $newImage->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                try {
                    GoogleVisionLabelImage::dispatchSync($newImage->id);
                } catch (\Throwable $e) {
                    logger()->error('GoogleVisionLabelImage failed', [
                        'image_id' => $newImage->id,
                        'error' => $e->getMessage(),
                    ]);
                }

                if (is_file($absolutePath)) {
                    @unlink($absolutePath);
                }
            }

            File::deleteDirectory(storage_path('app/livewire-tmp'));
        }

        session()->flash('status', 'Articolo caricato con successo!');
        $this->cleanForm();
    }

    protected function cleanForm(): void
    {
        $this->title = '';
        $this->description = '';
        $this->category = '';
        $this->price = '';
        $this->images = [];
        $this->temporary_images = [];
    }

    public function updatedTemporaryImages(): void
    {
        $this->validate([
            'temporary_images' => 'max:6',
            'temporary_images.*' => 'image|max:1024',
        ]);

        foreach ($this->temporary_images as $image) {
            $this->images[] = $image;
        }

        $this->temporary_images = [];
    }

    public function removeImage($key): void
    {
        if (array_key_exists($key, $this->images)) {
            unset($this->images[$key]);
            $this->images = array_values($this->images);
        }
    }

    public function render()
    {
        return view('livewire.create-article-form');
    }
}