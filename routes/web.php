<?php

use Illuminate\Support\Facades\Route;
use App\Models\Articles;

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

    // Templates
    Route::get('/template/inputs', [App\Http\Controllers\TemplateController::class, 'templateInputs'])->name('template.inputs');


    // Editor Modes
    Route::get('/focus-mode/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.focus-mode',compact('article'));
    });
    Route::get('/seo-mode/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.seo-mode',compact('article'));
    });
    Route::get('/power-mode/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.power-mode',compact('article'));
    });
    Route::get('/image-search/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.image-search',compact('article'));
    });
    Route::get('/image-generator/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.image-generator',compact('article'));
    });
    Route::get('/text-to-speech/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.text-to-speech',compact('article'));
    });
    Route::get('/post-article/{id}', function ($id) {
        $article = Articles::where('id', $id)->get()->first();
        return view('layouts.editor-components.post-article',compact('article'));
    });

    // End of editor modes

    // Templates
    Route::get('/admin/templates', [App\Http\Controllers\TemplateController::class, 'adminTemplates'])->name('admin.templates');
    Route::get('/admin/templates/create', [App\Http\Controllers\TemplateController::class, 'templateInputs'])->name('admin.templates.create');
    Route::get('/admin/templates/get', [App\Http\Controllers\TemplateController::class, 'adminTemplateGet'])->name('admin.templates.get');

});
