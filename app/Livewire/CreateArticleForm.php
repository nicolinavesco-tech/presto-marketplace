<?php

namespace App\Livewire;

use App\Models\Article;
use App\Services\UploadcareService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateArticleForm extends Component
{
    use WithFileUploads;

    public array $images = [];
    public $temporary_images = [];

    #[Validate('required|min:5')]
    public $title;

    #[Validate('required|min:10')]
    public $description;

    #[Validate('required|numeric')]
    public $price;

    #[Validate('required')]
    public $category;

    public function store()
    {
        $this->validate();

        $article = Article::create([
            'title'=>$this->title,
            'description'=>$this->description,
            'price'=>$this->price,
            'category_id'=>$this->category,
            'user_id'=>Auth::id()
        ]);

        if(!empty($this->images)){

            foreach($this->images as $image){

                try{

                    $uploadcare = UploadcareService::uploadUploadedFile($image);

                    $article->images()->create([
                        'path'=>$uploadcare['cdn_url'],
                        'uploadcare_uuid'=>$uploadcare['uuid']
                    ]);

                }catch(\Throwable $e){

                    logger()->error($e->getMessage());

                    $article->images()->create([
                        'path'=>"https://picsum.photos/1200/1200",
                        'uploadcare_uuid'=>null
                    ]);

                }

            }

        }

        session()->flash('status',"Articolo creato");

        $this->reset();
    }

    public function updatedTemporaryImages()
    {
        $this->validate([
            'temporary_images.*'=>'image|max:1024',
            'temporary_images'=>'max:6'
        ]);

        foreach($this->temporary_images as $img){
            $this->images[]=$img;
        }
    }

    public function render()
    {
        return view('livewire.create-article-form');
    }
}