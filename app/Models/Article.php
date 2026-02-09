<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Article extends Model
{
    use Searchable;

    protected $fillable=[
        'title',
        'description',
        'price',
        'category_id',
        'user_id',
        
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function toSearchableArray()
    {
        return[
            "id"=>$this->id,
            "title"=>$this->title,
            "description"=>$this->description,
            "category"=>$this->category,

        ];
    }

}
