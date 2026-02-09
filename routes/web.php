<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Models\Article;

Route::get('/', [PublicController::class, "home"])->name('home');

// rotte per CRUD articoli
Route::get('/articles/index',[ArticleController::class,"article_index"])->name('article_index');
Route::get('/articles/create', [ArticleController::class, "article_create"])->name('article_create');
Route::post('/articles/store',[ArticleController::class, "article_store"])->name('article_store');
Route::get('/article/show/{article}',[ArticleController::class, "article_show"])->name('article_show');
Route::get('/article/edit/{article}',[ArticleController::class, "article_edit"])->name('article_edit');
Route::put('/article/update/{article}', [ArticleController::class, 'update'])->name('article_update');
Route::delete('/article/destroy/{article}', [ArticleController::class, 'destroy'])->name('article_destroy');
// rotta categorie

Route::get("/category/{category}", [ArticleController::class, "byCategory"])->name("byCategory");

// rotta barra di ricerca

Route::get("/search/article", [PublicController::class, "searchArticles"])->name("article.search");
