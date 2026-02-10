<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Mail\BecomeRevisor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;


class RevisorController extends Controller
{
    public function index(){

        $article_to_check = Article::where('is_accepted', null)->first();
        return view('revisor.index', compact('article_to_check'));
        }

    public function accept(Article $article)
    {
        $article->setAccepted(true);
        return redirect()->back()->with('message',"hai accettato l'articolo $article->title");
    }

    public function reject(Article $article){
        $article->setAccepted(false);
        return redirect()->back()->with("message", "Hai rifiutato l'articolo $article->title");
    }

    // funzione in prova unDo
    public function updateLastReviewed($value = null)
    {
        $lastArticle = Article::whereNotNull('is_accepted')->orderBy('updated_at', 'desc')->first();
    
        if(!is_null($value)){
            $value= filter_var($value, FILTER_VALIDATE_BOOLEAN);

        }
       

        if (!$lastArticle) {
            return redirect()->back()->with('error', 'Nessun articolo trovato.');
        }
    
        $lastArticle->is_accepted = $value;
        $lastArticle->save();
    
        return redirect()->back()->with('success', 'Ultimo articolo aggiornato.');
    }
    // fine prova unDo

    public function becomeRevisor(){
        Mail::to('admin@presto.it')->send(new becomeRevisor(Auth::user()));
        return redirect()->route('home')->with('message','Complimenti,hai richiesto di diventare revisor');
        
    }
    public function makeRevisor(User $user)
    {
        Artisan::call('app:make-user-revisor', ['email' =>$user->email]);
        return redirect()->back();
    }

    
}
