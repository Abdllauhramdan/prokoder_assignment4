<?php
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ArticleController as WebArticleController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('create', function () {
//     return view('subscriptions.create');
// });

// Route::get('create1', function () {
//     return view('subscriptions.create1');
// });



// SubscriptionRoutes
Route::get('subscriptions/create', [SubscriptionController::class, 'create'])->name('subscriptions.create');
Route::post('subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');

// ArticleRoutes 
Route::get('articles', [WebArticleController::class, 'index'])->name('articles.index');
Route::get('articles/{id}', [WebArticleController::class, 'show'])->name('articles.show');
