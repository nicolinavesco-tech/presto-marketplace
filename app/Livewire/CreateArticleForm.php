<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class CreateArticleForm extends Component
{
    #[Validate('required|min:5')]
    public $title;
    #[Validate('required|min:10')]
    public $description;
    #[Validate('required|numeric')]
    public $price;
    #[Validate('required')]
    public $category;
    public $article;

    public function save()
    {
        $this->validate();

        $this->article = Article::create([
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'category_id' => $this->category,
            'user_id' => Auth::id(),
        ]);

        session()->flash('message', 'Articolo creato con successo!');
    }



    public function render()
    {
        return view('livewire.create-article-form');
    }
}
