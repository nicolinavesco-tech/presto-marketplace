<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ArticleController extends Controller implements HasMiddleware
{
    
public static function middleware(): array{    
    return[
        new Middleware("auth", only:["create"]),
    ];
}

public function article_index(){
    $articles = Article::orderBy('created_at','desc')->paginate(6);

    return view ('articles.index', compact('articles',));
    }
public function article_create(){
    return view("articles.create");
}


public function article_show(){
    return view('articles.show', compact('article'));
}


}
