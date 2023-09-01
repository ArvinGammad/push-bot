<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('member.dashboard');

    // Start Related Article Routes
    Route::get('/article', [App\Http\Controllers\ArticleController::class, 'index'])->name('article.index');
    Route::delete('/article/delete', [App\Http\Controllers\ArticleController::class, 'deleteArticle'])->name('article.delete');

    Route::get('/article/keywords', [App\Http\Controllers\ArticleController::class, 'articleKeywords'])->name('article.keywords');
    Route::post('/article/keyword/create', [App\Http\Controllers\ArticleController::class, 'createArticleKeywords'])->name('article.keywords.create');

    Route::get('/article/title', [App\Http\Controllers\ArticleController::class, 'articleTitle'])->name('article.title');

    Route::get('/article/editor/{id}', [App\Http\Controllers\ArticleController::class, 'editor'])->name('article.editor');
    Route::post('/article/editor/save', [App\Http\Controllers\ArticleController::class, 'editorSave'])->name('article.editor.save');
    Route::post('/article/editor/create', [App\Http\Controllers\ArticleController::class, 'editorCreate'])->name('article.editor.create');
    Route::post('/article/editor/compose', [App\Http\Controllers\ArticleController::class, 'editorCompose'])->name('article.editor.compose');
    
    // End Related Article Routes
});
