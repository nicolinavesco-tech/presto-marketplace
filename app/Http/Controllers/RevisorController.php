<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class RevisorController extends Controller
{
    public function index(){

        $article_to_check = Article::where('is_accepted', null)->first();
        return view('revisor.index', compact('article_to_check'));
        }

    public function accept(Article $article)
    {
        $article->setAccepted(true);
        return redirect()
            ->back()
            ->with('message',"hai accettato l'articolo $article->title");
    }
}
