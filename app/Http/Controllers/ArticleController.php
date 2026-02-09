<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class ArticleController extends Controller implements HasMiddleware
{
    
public static function middleware(): array{    
    return[
        new Middleware("auth", only:["create"]),
    ];
}

public function article_index(){
    $articles = Article::where('is_accepted', true)->orderBy('created_at','desc')->paginate(6);

    return view ('articles.index', compact('articles',));
    }
public function article_create(){
    return view("articles.create");
}
/**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
  
    Article::create([
        "title"=> $request->title,
        "description"=>$request->content,
        "price"=>$request->price,
        "user_id"=>Auth::user()->id,
        "category_id"=>$request->category_id
    ]);
    return redirect(route('home'));
    
}

public function byCategory(Category $category){

    $articles= $category->articles->where('is_accepted', true);
    return view ("article.byCategory",compact('articles', 'category'));
    //  ["articles"=> $category->articles, "category"=>$category]);
}


public function article_show(Article $article){
    return view('articles.show', compact('article'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
            $article->delete();
            return redirect(route('home')); 
        
    }

}
