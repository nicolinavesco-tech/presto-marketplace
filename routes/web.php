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
Route::put('/article/edit/{article}',[ArticleController::class, "article_edit"])->name('article_edit');
Route::delete('/article/destroy/{}', [ArticleController::class, "article_destroy"])->name('article_destroy');

// rotta categorie

Route::get("/category/{category}", [ArticleController::class, "byCategory"])->name("byCategory");
