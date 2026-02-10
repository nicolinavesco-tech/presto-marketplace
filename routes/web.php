<?php

use App\Http\Controllers\AdminController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\RevisorController;

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


// Rotte per Revisione articoli
Route::get('/revisor/index', [RevisorController::class,'index'])->middleware("isRevisor")->name('revisor.index');
Route::patch('/accept/{article}' , [RevisorController::class,'accept'])->name('accept');
Route::patch('/reject/{article}', [RevisorController::class, "reject"])->name("reject");
Route::get('/revisor/request', [RevisorController::class,'becomeRevisor'])->middleware('auth')->name('become.revisor');
Route::get('/make/revisor/{user}' , [RevisorController::class,'makeRevisor'])->name('make.revisor');


// rotta barra di ricerca
Route::get("/search/article", [PublicController::class, "searchArticles"])->name("article.search");

// rotta amministratore
Route::get("/admin/index", [AdminController::class, "index"])->name("admin.index");

