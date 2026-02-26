<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use App\Mail\BecomeRevisor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class RevisorController extends Controller
{
    public function index()
    {
        $article_to_check = Article::whereNull('is_accepted')
            ->whereNotNull('user_id')
            ->whereNotNull('category_id')
            ->with(['user', 'category', 'images'])
            ->first();

        return view('revisor.index', compact('article_to_check'));
    }

    public function accept(Article $article)
    {
        $article->setAccepted(true);

        return redirect()->back()
            ->with('message', "Hai accettato l'articolo {$article->title}");
    }

    public function reject(Article $article)
    {
        $article->setAccepted(false);

        return redirect()->back()
            ->with('message', "Hai rifiutato l'articolo {$article->title}");
    }

    // Undo ultimo articolo revisionato
    public function updateLastReviewed($value = null)
    {
        $lastArticle = Article::whereNotNull('is_accepted')
            ->orderByDesc('updated_at')
            ->first();

        if (!is_null($value)) {
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
        }

        if (!$lastArticle) {
            return redirect()->back()->with('message', 'Nessun articolo trovato.');
        }

        $lastArticle->is_accepted = $value; // null = torna "da revisionare"
        $lastArticle->save();

        return redirect()->back()->with('message', 'Ultimo articolo aggiornato.');
    }

    public function becomeRevisor(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
            'cv'      => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = $request->file('cv')->store('cv', 'public');
        $user = User::where('email', $request->email)->first();

        Mail::to('admin@presto.it')->send(
            new BecomeRevisor(
                name: $request->name,
                email: $request->email,
                messageText: $request->message,
                cvPath: $cvPath,
                user: $user
            )
        );

        return redirect()->route('home')
            ->with('message', 'Complimenti, hai richiesto di diventare revisor');
    }

    public function makeRevisor(User $user)
    {
        Artisan::call('app:make-user-revisor', ['email' => $user->email]);

        return redirect()->back()
            ->with('message', "Ora {$user->email} è revisor");
    }
}