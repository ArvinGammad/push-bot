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
    Route::get('/profile', [App\Http\Controllers\DashboardController::class, 'profilePage'])->name('member.profilePage');
    Route::post('/profile/save-profile', [App\Http\Controllers\DashboardController::class, 'saveProfile'])->name('member.saveProfile');
    Route::put('/profile/change-password', [App\Http\Controllers\DashboardController::class, 'changePassword'])->name('member.changePassword');

    // Articles
    Route::get('/article', [App\Http\Controllers\ArticleController::class, 'index'])->name('article.index');
    Route::delete('/article/delete', [App\Http\Controllers\ArticleController::class, 'deleteArticle'])->name('article.delete');

    Route::get('/article/keywords', [App\Http\Controllers\ArticleController::class, 'articleKeywords'])->name('article.keywords');
    Route::post('/article/keyword/create', [App\Http\Controllers\ArticleController::class, 'createArticleKeywords'])->name('article.keywords.create');

    Route::get('/article/title', [App\Http\Controllers\ArticleController::class, 'articleTitle'])->name('article.title');

    Route::get('/article/editor/{id}', [App\Http\Controllers\ArticleController::class, 'editor'])->name('article.editor');
    Route::post('/article/editor/save', [App\Http\Controllers\ArticleController::class, 'editorSave'])->name('article.editor.save');
    Route::post('/article/editor/create', [App\Http\Controllers\ArticleController::class, 'editorCreate'])->name('article.editor.create');
    Route::post('/article/editor/compose', [App\Http\Controllers\ArticleController::class, 'editorCompose'])->name('article.editor.compose');

    // Templates
    Route::get('/template/inputs', [App\Http\Controllers\TemplateController::class, 'getTemplateInputs'])->name('template.inputs');
    Route::get('/templates', [App\Http\Controllers\TemplateController::class, 'getAllTemplate'])->name('template.list');
    Route::get('/template/editor/{slug}', [App\Http\Controllers\TemplateController::class, 'templateEditor'])->name('template.editor');
    Route::get('/templates/editor/history/get', [App\Http\Controllers\TemplateController::class, 'templateEditorHistory'])->name('template.editor.history');
    Route::get('/get/templates/generated/{generated_id}', [App\Http\Controllers\TemplateController::class, 'templateGetGenerated'])->name('template.editor.get.generated');
    Route::post('/admin/templates/generate', [App\Http\Controllers\TemplateController::class, 'adminTemplateGenerate'])->name('admin.templates.generate');

    // SEO
    Route::post('/seo/generate-urls', [App\Http\Controllers\SEOController::class, 'getSEOUrl'])->name('seo.generate.urls');
    Route::get('/seo/crawl-url', [App\Http\Controllers\SEOController::class, 'crawlData'])->name('seo.crawl.url');
    Route::get('/seo/get-seo-data', [App\Http\Controllers\SEOController::class, 'getSEOData'])->name('seo.get.data');
    Route::get('/seo/get-crawled-data', [App\Http\Controllers\SEOController::class, 'getSEOCrawledData'])->name('seo.get.crawled.data');
    Route::get('/seo/check-crawled-data', [App\Http\Controllers\SEOController::class, 'checkSEOCrawledData'])->name('seo.check.crawled.data');

    // Image search pexels
    Route::post('/pexels/search', [App\Http\Controllers\ArticleController::class, 'searchPexelsImages'])->name('article.pexels.search');


    // Image Editor
    Route::get('/image/editor', [App\Http\Controllers\ImageEditorController::class, 'imageEditor'])->name('image.editor');


    // WordPress Integration
    Route::get('/wp/list', [App\Http\Controllers\WordPressController::class, 'index'])->name('wp.index');
    Route::get('/wp/connect', [App\Http\Controllers\WordPressController::class, 'connectPage'])->name('wp.connectPage');
    Route::get('/wp/edit/{id}', [App\Http\Controllers\WordPressController::class, 'editPage'])->name('wp.editPage');
    Route::put('/wp/update', [App\Http\Controllers\WordPressController::class, 'wpUpdate'])->name('wp.wpUpdate');
    Route::delete('/wp/delete', [App\Http\Controllers\WordPressController::class, 'wpDelete'])->name('wp.wpDelete');
    Route::post('/wp/save', [App\Http\Controllers\WordPressController::class, 'wpSave'])->name('wp.wpSave');

    // WordPress Articles
    Route::get('/wp/get-wp-detail', [App\Http\Controllers\WordPressController::class, 'getWPDetails'])->name('wp.getWPDetails');
    Route::post('/wp/wp-post', [App\Http\Controllers\WordPressController::class, 'wpPost'])->name('wp.wpPost');

    // Shopify
    Route::get('/shopify/index', [App\Http\Controllers\DashboardController::class, 'maintenance'])->name('shopify.index');
    // Wix
    Route::get('/wix/index', [App\Http\Controllers\DashboardController::class, 'maintenance'])->name('wix.index');
    // BigCommerce
    Route::get('/bigcommerce/index', [App\Http\Controllers\DashboardController::class, 'maintenance'])->name('bigcommerce.index');
    // Facebook
    Route::get('/facebook/index', [App\Http\Controllers\DashboardController::class, 'maintenance'])->name('facebook.index');


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

    // Admin Templates
    Route::get('/admin/templates', [App\Http\Controllers\TemplateController::class, 'adminTemplates'])->name('admin.templates');
    Route::get('/admin/templates/create', [App\Http\Controllers\TemplateController::class, 'templateInputs'])->name('admin.templates.create');
    Route::get('/admin/templates/get', [App\Http\Controllers\TemplateController::class, 'adminTemplateGet'])->name('admin.templates.get');

});
