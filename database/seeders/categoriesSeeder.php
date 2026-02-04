<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesSeeder extends Seeder
{
    public $categories = [
        'Elettronica',
        'Abbigliamento',
        'Salute e Bellezza',
        'Casa e Giardinaggio',
        'Giocattoli',
        'Sport',
        'Animali Domestici', 
        'Libri e Riviste',
        'Accessori',
        'Motori'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category
            ]);
        }
        
    }
}
